<?php

/**
 * Smarty plugin "typolink"
 * -------------------------------------------------------------
 * File:    block.typolink.php
 * Type:    block
 * Name:    Typolink
 * Version: 3.0
 * Author: Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Return a linked text using the typolink function
 * Example: {typolink setup="lib.link" parameter="10"}click here{/typolink}
 * Note:    You can add any property valid for the TypoScript typolink object,
 *          For example, parameter="1" or useCacheHash="1" or addQueryString.exclude="id,L" etc.
 *          For details of available parameters check the typolink documentation at:
 *          http://typo3.org/documentation/document-library/references/doc_core_tsref/4.1.0/view/5/8/
 * Note:    In addition to the normal typolink parameters you can use parameter="_self" to link to the current
 *          page. And you can define absRefPrefix="1" to prefix the link with the current base url or
 *          absRefPrefix="http://www.mysite.com/" to prefix the link with a different url.
 * Note:    The parameter "setup" will reference the global template scope, so you can pass a typoscript
 *          object which defines your link configuratiopn.
 *          For example, if your TypoScript setup contains an element lib.myLink, adding
 *          setup="lib.myLInk" will use the TypoScript configuration from lib.myLink to build the link
 * Note:    Any parameters inside the typolink tag will override the corresponding parameters in a TypoScript
 *          object. For example, {typolink setup="lib.link" parameter="10"}click here{/typolink} will use
 *          the TypoScript configuration from lib.link, but set the property 'parameter' to 10
 * Note:    If you haven't defined a title for the link the content between the tags will automatically be used
 *          for the link title attribute.
 * -------------------------------------------------------------
 *
 * @param $params
 * @param $content
 * @param Smarty_Internal_Template $template
 * @param $repeat
 * @return mixed|string
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
//@codingStandardsIgnoreStart
function smarty_block_typolink($params, $content, Smarty_Internal_Template $template, &$repeat)
{
//@codingStandardsIgnoreEnd

    // Execute the block function on the closing tag
    if (!$repeat) {

        // Gets an instance of tslib_cobj
        $cObj = Tx_Smarty_Service_Compatibility::makeInstance('Tx_Smarty_Core_CobjectProxy');

        // Catch the keyword _self to create a link to the current page
        $params['parameter'] = getLinkParameter($params['parameter']);

        // Deprecated means of forcing an absolute URL
        if (isset($params['absRefPrefix'])) {
            // Save a copy of the current global $GLOBALS['TSFE']->absRefPrefix setting
            $originalAbsRefPrefix = $GLOBALS['TSFE']->absRefPrefix;

            // Set the global absRefPrefix setting(!!!)
            $GLOBALS['TSFE']->absRefPrefix = getTemporaryAbsRefPrefix($params['absRefPrefix']);
        }

        // Gets the link
        list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromParameters($params);

        // Apply htmlspecialchars to any alt/title text
        if ($setup['title'] || $setup['title.']) {
            $setup['title'] = $cObj->stdWrap($setup['title'], $setup['title.']);
            $setup['title'] = sanitizeString($setup['title']);
            unset($setup['title.']);
        }

        // Generate the link
        $link = $cObj->typolink($content, $setup);

        // Deprecated means of forcing an absolute URL
        if (isset($params['absRefPrefix'])) {
            $GLOBALS['TSFE']->absRefPrefix = $originalAbsRefPrefix;
        }

        // Automatically set the "title" attribute from the content of the tag if undefined
        $link = addTitleFromContent($link, $content);

        // Returns or assigns the result
        if (isset($params['assign'])) {
            $template->assign($params['assign'], $link);

        } else {
            return $link;
        }
    }
}

/**
 * Evaluates the _self setting which points to the current page id
 *
 * @param bool $parameter
 * @return bool|mixed
 */
function getLinkParameter($parameter = false)
{
    if ($parameter) {
        // Catch the keyword _self to create a link to the current page
        $parameter = preg_replace('/^_self\b/im', $GLOBALS['TSFE']->id, $parameter);
    }

    return $parameter;
}

/**
 * Applies the content of the link as the link title if no title is available
 *
 * @param $link
 * @param $content
 * @return mixed
 */
function addTitleFromContent($link, $content)
{
    // Automatically set the "title" attribute from the content of the tag if undefined
    if (!preg_match('%<a[^>]*title=[^>]*>[^<]*</a>%i', $link)) {
        $content = sanitizeString($content);
        $link = preg_replace('%(<a[^>]*)(>)([^<]*</a>)%i', '\1 title="'.$content.'">\3', $link);
    }

    return $link;
}

/**
 * Configured htmlspecialchars application
 *
 * @param $string
 * @return string
 */
function sanitizeString($string)
{
    return htmlspecialchars(trim($string), ENT_COMPAT | ENT_HTML401, SMARTY_RESOURCE_CHAR_SET, false);
}

/**
 * Gets an URL which is used to temporarily override $GLOBALS['TSFE']->absRefPrefix thereby forcing
 * an absolute URL on the link which is being generated. This feature is deprecated and should be avoided!
 * Instead use the TypoScript property "forceAbsoluteUrl" to force absolute URLs
 *
 * @param $absRefPrefix
 * @return string
 * @deprecated
 */
function getTemporaryAbsRefPrefix($absRefPrefix)
{
    Tx_Smarty_Service_Compatibility::logDeprecatedFunction();

    if (parse_url($absRefPrefix, PHP_URL_SCHEME)) {
        $temporaryAbsRefPrefix = trim($absRefPrefix);

    } else {
        $temporaryAbsRefPrefix = trim($GLOBALS['TSFE']->baseUrl);
    }

    if (substr($temporaryAbsRefPrefix, -1, 1) !== '/') {
        $temporaryAbsRefPrefix .= '/';
    }

    return $temporaryAbsRefPrefix;
}
