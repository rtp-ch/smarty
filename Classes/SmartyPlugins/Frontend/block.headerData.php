<?php

/**
 * Smarty plugin "headerData"
 * -------------------------------------------------------------
 * File:    block.headerData.php
 * Type:    block
 * Name:    Insert header data
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Inject a block of text (e.g. javascript) into the page header
 * Example: {header}<script type="text/javascript">document.write("Hello World!")</script>{/header}
 * Note:    header and headerData are identical (i.e. {header}[...]{/header}
 *          and {headerData}[...]{/headerData} are interchangeable )
 * -------------------------------------------------------------
 *
 * @param array $params
 * @param string $content
 * @param Smarty_Internal_Template $template
 * @param $repeat
 * @return void
 */
function smarty_block_headerData($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    Tx_Smarty_Service_Smarty::loadPlugin($template, 'smarty_block_header');
    smarty_block_header($params, $content, $template, $repeat);
}