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
 * @todo Inneficient if each translate causes a seek, check extBase approach
 * @todo extBase compatibility
 * @todo run through string resource
 */
function smarty_block_LLL($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    if (!$repeat) {
        // Make sure params are lowercase
        $params = array_change_key_case($params, CASE_LOWER);

        // Key for looking up the translation in the language file
        $key = ($params['label']) ? $params['label'] : $content;

        if ($key) {

            // Gets the language file and/or label information
            if (t3lib_div::isFirstPartOfStr($key, 'LLL:')) {
                $key = substr($key, 4);
            }

            if ($parts = Tx_Smarty_Utility_Array::trimExplode($key, ':')) {
                $key = array_pop($parts);
                $languageFile = implode(':', $parts);
            }

            if (isset($languageFile)) {
                $languageFiles = array($languageFile);

            } else {
                $languageFiles = $template->smarty->getLanguageFile();
            }

            // Calls the sL method from tslib_fe to translate the label
            foreach ($languageFiles as $languageFile) {
                // Makes sure only relative path is used for readLLfile
                $languageFile = str_replace(t3lib_div::getIndpEnv('TYPO3_SITE_URL'), '', $languageFile);

                if (Tx_Smarty_Utility_Typo3::isFeInstance()) {
                    $translation = $GLOBALS['TSFE']->sL('LLL:' . $languageFile . ':' . $key);

                } elseif (is_object($GLOBALS['LANG'])) {
                    $translation = $GLOBALS['LANG']->sL('LLL:' . $languageFile . ':' . $key);
                }
            }

            // Sets an alternate translation if no translation was found
            // and the "alt" parameter is available.
            if ((!isset($translation) || !$translation) && isset($params['alt'])) {
                $translation = $params['alt'];
            }

            // If the translation contains Smarty template vars run it through Smarty as s string resource
            $lDel = preg_quote($template->smarty->getLeftDelimiter(), '%');
            $rDel = preg_quote($template->smarty->getRightDelimiter(), '%');
            if (preg_match('%[' . $lDel . '[^' . $rDel . ']*' . $rDel . '%m', $translation)) {
                $translation = $template->smarty->fetch('string:' . $translation);
            }

            // Runs the translated text through htmlspecialchars if set
            if ((boolean) $params['hsc']) {
                $translation = htmlspecialchars($translation);
            }
        }

        // Returns the original content if no translation was found
        return trim($translation) ? $translation : $content;
    }
}