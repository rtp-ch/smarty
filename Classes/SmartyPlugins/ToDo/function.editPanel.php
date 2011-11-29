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
 * Smarty plugin "editPanel"
 * -------------------------------------------------------------
 * 
 * THIS IS WORK IN PROGRESS...
 * 
 * -------------------------------------------------------------
 *
 **/


	function smarty_function_editPanel($params, &$smarty) {
		
		// Check for a valid FE instance (this plugin cannot be run in the backend)
		if(!tx_smarty_div::validateTypo3Instance('FE')) {
			$smarty->trigger_error($smarty->fePluginError);
			return false;
		}
		
		// Make sure there is a valid instance of tslib_cObj
		if (!method_exists($smarty->cObj,'editPanel')) {
		    $smarty->trigger_error('TYPO3 Method editPanel unavailable in smarty_function_editPanel');
		    return;
		}
		
		$content = '';
		if($params['content']) {
			$content = $params['content'];
			unset($params['content']);
		}
		
		if($params['currentRecord']) {
			$currentRecord = $params['currentRecord'];
			unset($params['currentRecord']);
		} else {
			$currentRecord = $GLOBALS['TSFE']->currentRecord;
		}
		
		$data = '';
		if($params['data']) {
			$data = $params['data'];
			unset($params['data']);
		}
		
		// Get TypoScript from $params
		$setup = tx_smarty_div::getTypoScriptFromParams($params);

		// return the 
		return $smarty->cObj->editPanel($content, $setup[1], $GLOBALS['TSFE']->currentRecord, $currentRecord, $data);
	}
?>