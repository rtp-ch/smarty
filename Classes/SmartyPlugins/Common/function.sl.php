<?php

/**
 * @param $params
 * @param Smarty_Internal_Template $template
 * @return string
 * @see smarty_block_LLL
 */
function smarty_function_sl($params, Smarty_Internal_Template $template)
{
    Tx_Smarty_Service_Smarty::loadPlugin($template, 'smarty_block_LLL');
    $repeat = 0;
    return smarty_block_LLL($params, '', $template, $repeat);
}