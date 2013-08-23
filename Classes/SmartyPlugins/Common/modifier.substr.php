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
 * Example: {$str|substr:-1:5}
 * -------------------------------------------------------------
 *
 * @param $string
 * @param $start
 * @param $length
 * @return null|string
 */
//@codingStandardsIgnoreStart
function smarty_modifier_substr($string, $start, $length)
{
//@codingStandardsIgnoreEnd
    if (is_null($string)) {
        return null;
    }

    $start = intval($start);
    $start = $start <= strlen($string) && $start >= -strlen($string) ? $start : 0;
    $length = $length ? intval($length) : null;

    return substr($string, $start, $length);
}
