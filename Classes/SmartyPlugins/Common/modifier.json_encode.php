<?php

/**
 *
 * Smarty plugin "json_encode"
 * -------------------------------------------------------------
 * File:    modifier.json_encode.php
 * Type:    modifier
 * Name:    json_encode
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Converts any object, array or value to json
 * Example: {$someVar|json_encode}
 * -------------------------------------------------------------
 *
 * @param $content
 * @return mixed
 * @see smarty_modifier_json
 */
function smarty_modifier_json_encode($content)
{
    return json_encode($content, JSON_NUMERIC_CHECK);
}
