<?php

/**
 * Smarty plugin "ref"
 * -------------------------------------------------------------
 * File:    modifier.ref.php
 * Type:    modifier
 * Name:    ref
 * Version: 1.0
 * Author:    Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: REF, or r() is a nicer alternative to PHP's print_r / var_dump functions!
 * link: https://github.com/digitalnature/php-ref
 * Example: {$var|ref:2:"html"}
 * -------------------------------------------------------------
 *
 * @param null $var
 * @param int $expandDepth
 * @param string $format
 * @return string
 */
//@codingStandardsIgnoreStart
function smarty_modifier_ref($var, $expandDepth = 1, $format = 'html')
{
//@codingStandardsIgnoreEnd
    $format = $format === 'text' ? 'text' : 'html';
    $ref = new ref($format, $expandDepth);

    return $ref->query($var, $var);
}
