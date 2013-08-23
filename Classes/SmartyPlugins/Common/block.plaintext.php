<?php

/**
 * @param $params
 * @param $content
 * @param Smarty_Internal_Template $template
 * @param $repeat
 * @return string
 * @see smarty_block_html2markdown
 */
//@codingStandardsIgnoreStart
function smarty_block_plaintext($params, $content, Smarty_Internal_Template $template, &$repeat)
{
//@codingStandardsIgnoreEnd
    if (!$repeat) {
        Tx_Smarty_Service_Smarty::loadPlugin($template, 'smarty_block_html2markdown');
        return smarty_block_html2markdown($params, $content, $template, $repeat);
    }
}
