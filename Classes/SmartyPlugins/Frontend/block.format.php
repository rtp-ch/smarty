<?php

    /***************************************************************
     *  Copyright notice
     *
     *
     *    Created by Simon Tuck
     *    Copyright (c) 2006-2007, Rueegg Tuck Partner GmbH (wwww.rtpartner.ch)
     *  All rights reserved
     *
     *  This script is part of the TYPO3 project. The TYPO3 project is
     *  free software; you can redistribute it and/or modify
     *  it under the terms of the GNU General Public License as published by
     *  the Free Software Foundation; either version 2 of the License, or
     *  (at your option) any later version.
     *
     *  The GNU General Public License can be found at
     *  http://www.gnu.org/copyleft/gpl.html.
     *
     *  This script is distributed in the hope that it will be useful,
     *  but WITHOUT ANY WARRANTY; without even the implied warranty of
     *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *  GNU General Public License for more details.
     *
     *  This copyright notice MUST APPEAR in all copies of the script!
     *
     *    @copyright     2011 Simon Tuck
     *    @author     Simon Tuck <stu@rtp.ch>
     *    @link         http://www.rtp.ch/
     *    @package     Smarty (smarty)
     *
     ***************************************************************/

/**
 *
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
            list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromParameters($params);
            $cObj = t3lib_div::makeInstance('Tx_Smarty_Core_CobjectProxy');
            return $cObj->parseFunc($content, $setup);
        }
    }