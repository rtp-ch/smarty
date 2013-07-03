<?php

/**
 * Smarty plugin "format"
 * -------------------------------------------------------------
 * File: block.format.php
 * Type: block
 * Name: Format
 * Version: 2.0
 * Author: Simon Tuck <stu@rtp.ch>
 * Purpose: Formats a block of text according to lib.parseFunc_RTE
 * Example: {format}
 *              These lines of text will
 *              will be formatted according to the
 *              rules defined in lib.parseFunc_RTE
 *              for example, individual lines will be wrapped in p tags.
 *           {/format}
 * Note: For more details on lib.parseFunc_RTE & parseFunc in general see:
 *       http://typo3.org/documentation/document-library/references/doc_core_tsref/current/view/5/14/
 * Note: To define an alternate parseFunc configuration set the paramater "parsefunc"
 *       in the tag e.g. {format setup="lib.myParseFunc"}Hello World{/format}
 * -------------------------------------------------------------
 *
 * @param array $params
 * @param string $content
 * @param Smarty_Internal_Template $template
 * @param $repeat
 * @return string
 */
function smarty_block_format($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    if (!$repeat) {
        Tx_Smarty_Service_Smarty::loadPlugin($template, 'smarty_modifier_format');
        return smarty_modifier_format($content, $params['setup']);
    }
}