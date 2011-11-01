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
 * Smarty plugin "nl2space"
 * -------------------------------------------------------------
 * File:    block.nl2space.php
 * Type:    block
 * Name:    Newlines to spaces
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Regex all linebreaks to spaces in a block of text
 * Example: {nl2space}
 *				This is a line of text
 *				This is another line of text
 *				But this will all end up on 1 line...
 *			{/nl2space}
 * -------------------------------------------------------------
 *
 **/


	function smarty_block_nl2space($params, $content, &$smarty) {
		$content = preg_replace('/(\s{0,}[\r\n|\r|\n|\t])/m', ' ', $content); // strip newlines, tabs etc.
		$content = $result = preg_replace('/(\s{2,})/m', ' ', $content);  // Turn multiple spaces into single spaces
		return $content;
	}

?>