<?php

/**
 * Smarty plugin "trim"
 * -------------------------------------------------------------
 * File:    block.trim.php
 * Type:    block
 * Name:    Trim
 * Version: 1.0
 * Author:	Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Apply PHP trim to a block of text
 * Example:	{trim}Some text{/trim}
 * -------------------------------------------------------------
 *
 **/
function smarty_block_trim($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    if (!$repeat) {

        // Make sure params are lowercase
        $params = array_change_key_case($params, CASE_LOWER);

        if (isset($params['charlist'])) {
            $content = trim($content, $params['charlist']);

        } else {
            $content = trim($content);
        }
    }

    return $content;
}
