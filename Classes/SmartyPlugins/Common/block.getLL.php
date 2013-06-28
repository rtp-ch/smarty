<?php

/**
 * @param $params
 * @param $content
 * @param Smarty_Internal_Template $template
 * @param $repeat
 * @return string
 * @see smarty_block_LLL
 */
function smarty_block_getLL($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    if (!$repeat) {
        Tx_Smarty_Service_Smarty::loadPlugin($template, 'smarty_block_LLL');
        return smarty_block_LLL($params, $content, $template, $repeat);
    }
}