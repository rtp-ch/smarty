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
 * @param $string
 * @param string $format
 * @param string $default_date
 * @param string $formatter
 * @return string
 */
function smarty_modifier_gmdate_format($string, $format = null, $default_date = '', $formatter = 'auto')
{
    /**
    * Include the {@link shared.make_timestamp.php} plugin
    */
    require_once SMARTY_PLUGINS_DIR . 'shared.make_timestamp.php';

    if (is_null($format)) {
        $format = Smarty::$_DATE_FORMAT;
    }

    if ($string !== '') {
        $timestamp = smarty_make_timestamp($string);

    } elseif ($default_date !== '') {
        $timestamp = smarty_make_timestamp($default_date);

    } else {
        return null;
    }

    if ($formatter === 'strftime' || ($formatter === 'auto' && strpos($format, '%') !== false)) {

        if (DS == '\\') {

            $_win_from = array('%D', '%h', '%n', '%r', '%R', '%t', '%T');
            $_win_to = array('%m/%d/%y', '%b', "\n", '%I:%M:%S %p', '%H:%M', "\t", '%H:%M:%S');

            if (strpos($format, '%e') !== false) {
                $_win_from[] = '%e';
                $_win_to[] = sprintf('%\' 2d', date('j', $timestamp));
            }

            if (strpos($format, '%l') !== false) {
                $_win_from[] = '%l';
                $_win_to[] = sprintf('%\' 2d', date('h', $timestamp));
            }

            $format = str_replace($_win_from, $_win_to, $format);
        }

        return gmstrftime($format, $timestamp);

    } else {
        return gmdate($format, $timestamp);
    }
}