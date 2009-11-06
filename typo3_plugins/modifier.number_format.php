<?php

/***************************************************************
 *  Copyright notice
 *
 *
 *	Created by Simon Tuck <stu@rtpartner.ch>
 *	Copyright (c) 2006-2007, Rueegg Tuck Partner GmbH (wwww.rtpartner.ch)
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
 *	@copyright 	2006, 2007 Rueegg Tuck Partner GmbH
 *	@author 	Simon Tuck <stu@rtpartner.ch>
 *	@link 		http://www.rtpartner.ch/
 *	@package 	Smarty (smarty)
 *
 ***************************************************************/

/**
 *
 * Smarty plugin "number_format"
 * -------------------------------------------------------------
 * File:    modifier.number_format.php
 * Type:    modifier
 * Name:    Format
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Format a string as a number using "number_format"
 * Example: {$number|number_format:2:".":"'"}
 * -------------------------------------------------------------
 *
 **/


function smarty_modifier_number_format($string, $decimals = 2, $dec_point = '.', $thousands_sep = '')
{
    return number_format($string, $decimals, $dec_point, $thousands_sep);
}

?>
