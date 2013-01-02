<?php

/***************************************************************
 *  Copyright notice
 *
 *
 *    Created by Simon Tuck <stu@rtpartner.ch>
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
 *    @copyright     2006, 2007 Rueegg Tuck Partner GmbH
 *    @author     Simon Tuck <stu@rtpartner.ch>
 *    @link         http://www.rtpartner.ch/
 *    @package     Smarty (smarty)
 *
 ***************************************************************/


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