<?php

/**
 * Smarty plugin "gmdate_format"
 * -------------------------------------------------------------
 * File:    modifier.gmdate_format.php
 * Type:    modifier
 * Name:    Format
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Same as date_format but uses gmstrftime instead of strftime
 * Example: See date_format documentation
 * -------------------------------------------------------------
 *
 * @param        $string
 * @param string $format
 * @param string $defaultDate
 * @param string $formatter
 *
 * @return string
 */
//@codingStandardsIgnoreStart
function smarty_modifier_gmdate_format($string = '', $format = null, $defaultDate = '', $formatter = 'auto')
{
//@codingStandardsIgnoreEnd

    /**
     * Include the shared.make_timestamp.php plugin
     */
    require_once SMARTY_PLUGINS_DIR . 'shared.make_timestamp.php';

    if (is_null($format)) {
        $format = Smarty::$_DATE_FORMAT;
    }

    $string    = trim($string) ? $string : $defaultDate;
    $timestamp = smarty_make_timestamp($string);

    if ($formatter === 'strftime' || ($formatter === 'auto' && strpos($format, '%') !== false)) {
        $gmdate = strftime($format, $timestamp);
    } else {
        $gmdate = gmdate($format, $timestamp);
    }

    return $gmdate;
}
