<?php

/**
 * @param $params
 * @param $content
 * @param Smarty_Internal_Template $template
 * @param $repeat
 * @return string
 * @see smarty_block_LLL
 */
//@codingStandardsIgnoreStart
function smarty_block_translate($params, $content, Smarty_Internal_Template $template, &$repeat)
{
//@codingStandardsIgnoreEnd
    if (!$repeat) {
        Tx_Smarty_Service_Smarty::loadPlugin($template, 'smarty_block_LLL');
        return smarty_block_LLL($params, $content, $template, $repeat);
    }
}
