<?php

/**
 * Smarty plugin "data"
 * -------------------------------------------------------------
 * File:    function.data.php
 * Type:    function
 * Name:    Data
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
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
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
//@codingStandardsIgnoreStart
function smarty_function_data($params, Smarty_Internal_Template $template)
{
//@codingStandardsIgnoreEnd
    //
    $params = array_change_key_case($params, CASE_LOWER);

    if (!isset($params['source'])) {
        // Throws an exception if the source setting is missing
        $msg = 'Missing required "source" setting for smarty function {data}!';
        throw new Tx_Smarty_Exception_PluginException($msg, 1324020249);
    }

    $frontend = Tx_Smarty_Service_Compatibility::makeInstance('Tx_Smarty_Core_FrontendProxy');
    $data = $frontend->cObj->getData($params['source'], null);

    // Returns or assigns the result
    if (isset($params['assign'])) {
        $template->assign($params['assign'], $data);

    } else {
        return $data;
    }
}
