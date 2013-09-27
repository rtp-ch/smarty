<?php

/**
 * Smarty plugin "LLL"
 * -------------------------------------------------------------
 * File:    block.LLL.php
 * Type:    block
 * Name:    Translate Text
 * Version: 1.1
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Translate a block of text from the current TYPO3 language library (e.g. locallang.xml)
 * Example: {LLL alt="Please enter your name" label="enter_name"}Your name{/LLL}
 * Note:    The parameter 'label' refers to the label in the xml file. If you do not provide a label
 *             the content between the tags will be used as the label.
 * Note:    The 'alt' parameter enables you to provide an alternative text if no translation was found.
 * Note:    If the translated text contains Smarty variables it will be cycled through Smarty again!
 *            That means you can include Smarty tags in your language library
 * -------------------------------------------------------------
 *
 * @param $params
 * @param $content
 * @param Smarty_Internal_Template $template
 * @param $repeat
 * @return string
 * @todo Check performance, compare with extBase approach
 */
//@codingStandardsIgnoreStart
function smarty_block_LLL($params, $content, Smarty_Internal_Template $template, &$repeat)
{
//@codingStandardsIgnoreEnd

    if (!$repeat) {

        // Make sure params are lowercase
        $params = array_change_key_case($params, CASE_LOWER);

        // Key for looking up the translation in the language file
        $key = ($params['label']) ? $params['label'] : $content;

        if ($key) {

            // Gets the relevant translation files (key must be included because it may
            // contain the file reference.
            list($key, $languageFiles) = getTranslationFiles($key, $template);

            // Finds the appropriate translation for the given key from the available translation files
            $translation = getTranslation($key, $languageFiles, $params['alt']);

            // Sets an alternate translation if no translation was found and the "alt" parameter is available.
            if ($translation !== false) {

                // Evaluates the translation as a smarty template
                $translation = renderTranslation($translation, $template);

                // Runs the translated text through htmlspecialchars if set
                $translation = (boolean) $params['hsc'] ? htmlspecialchars($translation) : $translation;

                // Sets the original content if the translation is empty
                $translation = trim($translation) ? $translation : $content;

                return returnOrAssignResult($translation, $template, $params['assign']);
            }
        }
    }
}

/**
 * Returns or assigns the result
 *
 * @param $translation
 * @param $template
 * @param null $assign
 * @return mixed
 */
function returnOrAssignResult($translation, $template, $assign = null)
{
    if (!is_null($assign)) {
        $template->assign($assign, $translation);

    } else {
        return $translation;
    }
}

/**
 * @param $key
 * @param Smarty_Internal_Template $template
 * @return array
 */
function getTranslationFiles($key, Smarty_Internal_Template $template)
{
    // Gets the language file and/or label information
    if (stripos($key, 'LLL:') === 0) {
        $key = substr($key, 4);
    }

    $parts = Tx_Smarty_Utility_Array::trimExplode($key, ':');
    if (count($parts) > 1) {
        $key = array_pop($parts);
        $languageFile = implode(':', $parts);
    }

    if (isset($languageFile)) {
        $languageFiles = array($languageFile);

    } else {
        $languageFiles = $template->smarty->getLanguageFile();
    }

    return array($key, $languageFiles);
}

/**
 * Find the translation for the given label
 *
 * @param $key
 * @param $languageFiles
 * @return mixed
 * @SuppressWarnings(PHPMD.CamelCaseVariableName)
 */
function getTranslation($key, $languageFiles, $alt = null)
{
    $translation = false;

    // Calls the sL method from tslib_fe to translate the label
    foreach ($languageFiles as $languageFile) {

        // Makes sure only relative path is used for readLLfile
        $languageFile = str_replace(
            Tx_Smarty_Service_Compatibility::getIndpEnv('TYPO3_SITE_URL'),
            '',
            $languageFile
        );

        // TODO: Break when a translation has been found(?)
        if (is_object($GLOBALS['LANG'])) {
            $translation = getLang()->sL('LLL:' . $languageFile . ':' . $key);

        } elseif (Tx_Smarty_Utility_Typo3::isFeInstance()) {
            $translation = $GLOBALS['TSFE']->sL('LLL:' . $languageFile . ':' . $key);
        }

        // Exit as soon as we have a translation
        if ($translation !== false || $translation !== '') {
            break;
        }
    }

    if ($translation === false && !is_null($alt)) {
        $translation = $alt;
    }

    return $translation;
}

/**
 * Passes the given string through smarty's rendering engine. In other words translated text snippets can in themselves
 * contain smarty variables
 *
 * @param $translation
 * @param Smarty_Internal_Template $template
 * @return string
 */
function renderTranslation($translation, Smarty_Internal_Template $template)
{
    // If the translation contains Smarty template vars run it through Smarty as s string resource
    $lDel = preg_quote($template->smarty->getLeftDelimiter(), '%');
    $rDel = preg_quote($template->smarty->getRightDelimiter(), '%');
    if (preg_match('%[' . $lDel . '[^' . $rDel . ']*' . $rDel . '%m', $translation)) {
        $translation = $template->smarty->fetch('string:' . $translation);
    }

    return $translation;
}
