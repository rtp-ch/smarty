<?php

/**
 * Smarty plugin "typolinkURL"
 * -------------------------------------------------------------
 * File:    function.typolinkURL.php
 * Type:    function
 * Name:    Typolink URL
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Return the URL of a typolink
 * Example: {url setup="lib.link" parameter="10"}
 * Note:    url and typolinkURL are identical (i.e. {url setup="lib.link"} and {typolinkURL setup="lib.link"}
 *          are interchangeable
 * Note:    You can add any property valid for the TypoScript typolink object.
 *          For example, parameter="1" or useCacheHash="1" or addQueryString.exclude="id,L" etc.
 *          For details of available parameters check the typolink documentation at:
 *          http://typo3.org/documentation/document-library/references/doc_core_tsref/4.1.0/view/5/8/
 * Note:    The parameter "setup" will reference the global template scope, so you can pass a typoscript
 *          object which defines your link configuration.
 *          For example, if your TypoScript setup contains an element lib.myLink, adding
 *          setup="lib.myLInk" will use the TypoScript configuration from lib.myLink to build the link
 * Note:    Any parameters inside the url tag will override the corresponding parameters in a TypoScript
 *          object. For example, {url setup="lib.link" parameter="10"} will use the TypoScript configuration
 *          from lib.link, but set the property 'parameter' to 10
 * -------------------------------------------------------------
 *
 * @param $params
 * @param Smarty_Internal_Template $template
 * @return string
 */
//@codingStandardsIgnoreStart
function smarty_function_typolinkURL($params, Smarty_Internal_Template $template)
{
//@codingStandardsIgnoreEnd
    Tx_Smarty_Service_Smarty::loadPlugin($template, 'smarty_block_typolink');
    $params['returnLast'] = 'url';
    $repeat = 0;
    $url = smarty_block_typolink($params, '', $template, $repeat);

    // Returns or assigns the result
    if (isset($params['assign'])) {
        $template->assign($params['assign'], $url);

    } else {
        return $url;
    }
}
