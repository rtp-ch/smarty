<?php

/**
 * Smarty plugin "file"
 * -------------------------------------------------------------
 * File:    function.file.php
 * Type:    function
 * Name:    File reference
 * Version: 1.0
 * Author:    Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Returns a path to a file relative to the site root (i.e. PATH_site)
 * Example:    {file path="EXT:my_ext/res/my_style.css"}
 * -------------------------------------------------------------
 *
 * @param $params
 * @param Smarty_Internal_Template $template
 * @throws Tx_Smarty_Exception_PluginException
 * @return mixed
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
//@codingStandardsIgnoreStart
function smarty_function_file($params, Smarty_Internal_Template $template)
{
//@codingStandardsIgnoreEnd

    $params = array_change_key_case($params, CASE_LOWER);

    if (!isset($params['path'])) {
        $msg = 'Missing required "path" setting for smarty plugin "file"!';
        throw new Tx_Smarty_Exception_PluginException($msg, 1324021795);
    }

    // Gets the absolute path to the file
    $pathToFile = str_replace(PATH_SITE, '', Tx_Smarty_Service_Compatibility::getFileAbsFileName($params['path']));

    // Returns or assigns the result
    if (isset($params['assign'])) {
        $template->assign($params['assign'], $pathToFile);

    } else {
        return $pathToFile;
    }
}
