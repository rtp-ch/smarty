<?php

/**
 * Smarty plugin "substr"
 * -------------------------------------------------------------
 * File:    block.substr.php
 * Type:    block
 * Name:    Substring
 * Version: 1.0
 * Author:    Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Apply PHP substr to a block of text
 * Example:    {substr start="-1" length="5"}Some text{/substr}
 * -------------------------------------------------------------
 *
 * @param $params
 * @param $content
 * @param Smarty_Internal_Template $template
 * @param $repeat
 * @return string
 */
function smarty_block_substr($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    if (!$repeat) {
        Tx_Smarty_Service_Smarty::loadPlugin($template, 'smarty_modifier_substr');
        $params = array_change_key_case($params);
        return smarty_modifier_substr($content, $params['start'], $params['length']);
    }
}
