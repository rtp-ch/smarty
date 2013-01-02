<?php

/**
 * Smarty plugin "data"
 * -------------------------------------------------------------
 * File:    function.data.php
 * Type:    function
 * Name:    Data
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Implements the TypoScript data type "getText". For details check
 *          http://typo3.org/documentation/document-library/references/doc_core_tsref/current/view/2/2/
 * Example: {data source="page:title"} Gets the current page title
 * Example: {data source="DB:tt_content:234:header"} Gets the header for content id 234
 * Example: {data source="DB:TSFE:lang"} Gets the current language key
 * Note:    Use the parameter "source" to define the type & pointer for the getText function
 * -------------------------------------------------------------
 *
 * @param $params
 * @param Smarty_Internal_Template $template
 * @return mixed
 * @throws Tx_Smarty_Exception_PluginException
 */
function smarty_function_data($params, Smarty_Internal_Template $template)
{
    //
    $params = array_change_key_case($params, CASE_LOWER);

    //
    if (isset($params['source'])) {
        $cObj = t3lib_div::makeInstance('Tx_Smarty_Core_CobjectProxy');
        return $cObj->getData($params['source'], null);

    // Throws an exception if the source setting is missing
    } else {
        $msg = 'Missing required "source" setting for template function {data}!';
        throw new Tx_Smarty_Exception_PluginException($msg, 1324020249);
    }
}