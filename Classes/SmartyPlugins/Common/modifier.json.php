<?php

/**
 *
 * Smarty plugin "json"
 * -------------------------------------------------------------
 * File:    modifier.json.php
 * Type:    modifier
 * Name:    json
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Converts any object, array or value to json
 * Example: {$someVar|json}
 * -------------------------------------------------------------
 *
 * @param $content
 * @return mixed
 * @see smarty_modifier_json_encode
 */
function smarty_modifier_json($content)
{
    return json_encode($content, JSON_NUMERIC_CHECK);
}
