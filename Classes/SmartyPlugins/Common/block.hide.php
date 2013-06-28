<?php

/**
 * Smarty plugin "hide"
 * -------------------------------------------------------------
 * File:    block.hide.php
 * Type:    block
 * Name:    Hide
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Hide (do not render) anything between the hide tags
 * Example: {hide}This won't show up in the rendered html{/hide}
 * -------------------------------------------------------------
 *
 * @param $params
 * @param $content
 * @param Smarty_Internal_Template $template
 * @param $repeat
 * @return void
 */
function smarty_block_hide($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    return null;
}