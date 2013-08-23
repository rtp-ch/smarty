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
 * @param $content
 * @return mixed
 */
//@codingStandardsIgnoreStart
function smarty_modifier_nl2space($content)
{
//@codingStandardsIgnoreEnd
    $content = preg_replace('/(\s{0,}[\r\n|\r|\n|\t])/m', ' ', $content); // strip newlines, tabs etc.
    return preg_replace('/(\s{2,})/m', ' ', $content);  // Turn multiple spaces into single spaces
}
