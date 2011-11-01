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
 * Smarty plugin "substr"
 * -------------------------------------------------------------
 * File:    block.substr.php
 * Type:    block
 * Name:    Substring
 * Version: 1.0
 * Author:	Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Apply PHP substr to a block of text
 * Example:	{substr start="-1" length="5"}Some text{/substr}
 * -------------------------------------------------------------
 *
 **/


	function smarty_block_substr($params, $content, &$smarty) {
	    if (is_null($content)) return;
		$params = array_change_key_case($params);
		$params['start'] = (intval($params['start']))?intval($params['start']):0;
		$params['length'] = (intval($params['length']))?intval($params['length']):null;
		if($params['length']) {
			return substr($content,$params['start'],$params['length']);
		}
		return substr($content,$params['start']);
	}

?>
