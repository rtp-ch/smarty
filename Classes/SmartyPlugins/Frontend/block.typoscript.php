<?php

/**
 *
 * Smarty plugin "typoscript"
 * -------------------------------------------------------------
 * File:    block.typoscript.php
 * Type:    block
 * Name:    TypoScript
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Interprets the text between the tags as TypoScript, parses it and returns the result.
 * Example:    {typoscript}
 *                 10 = TEXT
 *                 10.value = hello world
 *             {/typoscript}
 * -------------------------------------------------------------
 *
 * @param $params
 * @param $content
 * @param Smarty_Internal_Template $template
 * @param $repeat
 * @return mixed
 */
function smarty_block_typoscript($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    if (!$repeat) {
        $ts = t3lib_div::makeInstance('t3lib_TSparser');
        $ts->parse($content);
        $cObj = t3lib_div::makeInstance('Tx_Smarty_Core_CobjectProxy');
        return $cObj->cObjGet($ts->setup);
    }
}