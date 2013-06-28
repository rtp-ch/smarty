<?php

/**
 * Smarty plugin "br2nl"
 * -------------------------------------------------------------
 * File:    modifier.br2nl.php
 * Type:    modifier
 * Name:    br2nl
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Replaces html br tags in a string with newlines
 * Example: {$someVar|br2nl}
 * -------------------------------------------------------------
 *
 * @param $str
 * @return mixed
 */
function smarty_modifier_br2nl($str)
{
    return preg_replace('/<br[^>]*>/i', PHP_EOL, $str);
}
