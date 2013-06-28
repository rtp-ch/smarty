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
 * @throws Tx_Smarty_Exception_InvalidArgumentException
 * @return mixed
 */
function smarty_function_file($params, Smarty_Internal_Template $template)
{
    //
    $params = array_change_key_case($params,CASE_LOWER);
    if(!isset($params['path'])) {
        throw new Tx_Smarty_Exception_InvalidArgumentException('Missing required "path" setting for smarty plugin "file"!', 1324021795);
    }

    //
    return str_replace(PATH_site, '', t3lib_div::getFileAbsFileName($params['path']));
}