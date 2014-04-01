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
//@codingStandardsIgnoreStart
function smarty_modifier_format($content, $setup = false)
{
//@codingStandardsIgnoreEnd
    $parameters = array();
    if ($setup) {
        $parameters['setup'] = $setup;

    } else {
        // The default formatting rules are in lib.parseFunc_RTE
        $parameters['setup'] = 'lib.parseFunc_RTE.';
    }

    list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromParameters($parameters);
    $frontend = Tx_Smarty_Service_Compatibility::makeInstance('Tx_Smarty_Core_FrontendProxy');

    return $frontend->cObj->parseFunc($content, $setup);
}
