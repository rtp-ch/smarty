<?php

/***************************************************************
 *  Copyright notice
 *
 *
 *    Created by Simon Tuck <stu@rtpartner.ch>
 *    Copyright (c) 2006-2007, Rueegg Tuck Partner GmbH (wwww.rtpartner.ch)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *
 *    @copyright     2006, 2007 Rueegg Tuck Partner GmbH
 *    @author     Simon Tuck <stu@rtpartner.ch>
 *    @link         http://www.rtpartner.ch/
 *    @package     Smarty (smarty)
 *
 ***************************************************************/

/**
 * Smarty plugin "LLL"
 * -------------------------------------------------------------
 * File:    block.LLL.php
 * Type:    block
 * Name:    Translate Text
 * Version: 1.1
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
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
        if($key) {

            // Gets the language file and/or label information
            if (t3lib_div::isFirstPartOfStr($key, 'LLL:')) {
                $key = substr($key, 4);
            }

            if ($parts = Tx_Smarty_Utility_Array::trimExplode(':', $key)) {
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