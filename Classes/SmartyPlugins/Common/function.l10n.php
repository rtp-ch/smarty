<?php

/**
 *
 * Smarty plugin "l10n"
 * -------------------------------------------------------------
 * File:    function.l10n.php
 * Type:    function
 * Name:    Translate
 * Version: 1.0
 * Author:	Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Translate a block of text from the current TYPO3 language library (e.g. locallang.xml)
 * Example: {l10n label="enter_name"}
 * Note:	The parameter 'label' refers to the label xml file. If you do not provide a key
 * 			the content between the tags will be used as the key.
 * Note:	The 'alt' parameter enables you to provide an alternative text if no translation was found.
 * Note:	If the translated text contains Smarty variables it will be cycled through Smarty again!
 *			That means you can include Smarty tags in your language library
 * -------------------------------------------------------------
 *
 * @param $params
 * @param Smarty_Internal_Template $template
 * @return string
 * @see smarty_block_LLL
 **/
function smarty_function_l10n($params, Smarty_Internal_Template $template)
{
    Tx_Smarty_Service_Smarty::loadPlugin($template, 'smarty_block_LLL');
    $repeat = 0;
    return smarty_block_LLL($params, '', $template, $repeat);
}