<?php

/**
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
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
//@codingStandardsIgnoreStart
function smarty_block_typoscript($params, $content, Smarty_Internal_Template $template, &$repeat)
{
//@codingStandardsIgnoreEnd
    if (!$repeat) {

        $tsParser = Tx_Smarty_Service_Compatibility::makeInstance('t3lib_TSparser');
        $tsParser->parse($content);

        $frontend = Tx_Smarty_Service_Compatibility::makeInstance('Tx_Smarty_Core_FrontendProxy');
        $tsObject = $frontend->cObj->cObjGet($tsParser->setup);

        // Returns or assigns the result
        if (isset($params['assign'])) {
            $template->assign($params['assign'], $tsObject);

        } else {
            return $tsObject;
        }
    }
}
