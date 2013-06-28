<?php

/**
 * Smarty plugin "number_format"
 * -------------------------------------------------------------
 * File:    modifier.number_format.php
 * Type:    modifier
 * Name:    Format
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Format a string as a number using "number_format"
 * Example: {$number|number_format:2:".":"'"}
 * -------------------------------------------------------------
 *
 * @param $string
 * @param int $decimals
 * @param string $dec_point
 * @param string $thousands_sep
 * @return string
 */
function smarty_modifier_number_format($string, $decimals = 2, $dec_point = '.', $thousands_sep = '')
{
    return number_format($string, $decimals, $dec_point, $thousands_sep);
}
