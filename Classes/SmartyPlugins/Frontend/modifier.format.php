<?php

/**
 * Smarty plugin "format"
 * -------------------------------------------------------------
 * File:    modifier.format.php
 * Type:    modifier
 * Name:    Format
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtp.ch>
 * Purpose: Formats a variable according to lib.parseFunc_RTE
 * Example: {$assignedPHPvariable|format}
 * Note:	For more details on lib.parseFunc_RTE & parseFunc in general see:
 *			http://typo3.org/documentation/document-library/references/doc_core_tsref/4.1.0/view/5/14/
 * Note:	To define an alternate parseFunc configuration set the paramater "parsefunc"
 *			in the tag e.g. {$assignedPHPvariable|format:"lib.myParseFunc"}
 * -------------------------------------------------------------
 *
 * @param $content
 * @param bool $setup
 * @return string
 **/
function smarty_modifier_format($content, $setup = false)
{
    if ($setup) {
        $parameters['setup'] = $setup;

    } else {
        $parameters = array();
    }

    list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromParameters($parameters);
    $cObj = t3lib_div::makeInstance('Tx_Smarty_Core_CobjectProxy');

    return $cObj->parseFunc($content, $setup);
}
