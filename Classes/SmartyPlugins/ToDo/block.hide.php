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
 * Smarty plugin "hide"
 * -------------------------------------------------------------
 * File:    block.hide.php
 * Type:    block
 * Name:    Hide
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Hide (do not render) anything between the hide tags
 * Example: {hide}This won't show up in the rendered html{/hide}
 * -------------------------------------------------------------
 *
 **/


	function smarty_block_hide($params, $content, &$smarty) {
		return;
	}

?>