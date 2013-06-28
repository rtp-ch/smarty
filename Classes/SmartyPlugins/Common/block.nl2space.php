<?php

/**
 * Smarty plugin "nl2space"
 * -------------------------------------------------------------
 * File:    block.nl2space.php
 * Type:    block
 * Name:    Newlines to spaces
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Regex all linebreaks to spaces in a block of text
 * Example: {nl2space}
 *                This is a line of text
 *                This is another line of text
 *                But this will all end up on 1 line...
 *          {/nl2space}
 * -------------------------------------------------------------
 *
 * @param $params
 * @param $content
 * @param Smarty_Internal_Template $template
 * @param $repeat
 * @return string
 */
function smarty_block_nl2space($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    if (!$repeat) {
        Tx_Smarty_Service_Smarty::loadPlugin($template, 'smarty_modifier_nl2space');
        return smarty_modifier_nl2space($content);
    }
}