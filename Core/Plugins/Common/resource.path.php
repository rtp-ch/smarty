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
 * Smarty resource "path"
 * -------------------------------------------------------------
 * File:    resource.path.php
 * Type:    resource
 * Name:    TYPO3 Resources
 * Version:	2.1
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Gets path to file relative to siteroot possibly placed in an extension:
 * Example:	{include file="path:EXT:my_extension/my_file.tpl"}
 * Example:	$smarty->display('path:EXT:my_extension/my_template.tpl');
 * -------------------------------------------------------------
 *
 **/

	function smarty_resource_path_source($tpl_name, &$tpl_source, &$smarty) {
			
		// Check for a valid FE instance (this plugin cannot be run in the backend)
		if(!tx_smarty_div::validateTypo3Instance('FE')) {
			$smarty->trigger_error($smarty->fePluginError);
			return false;
		}
				
		// Make sure there is a valid instance of tslib_cObj
		if (!method_exists($smarty->cObj,'getData')) {
			$smarty->trigger_error('TYPO3 Method getData unavailable in smarty_resource_path_source');
			return false;
		}
		$file = $smarty->cObj->getData('path:'.$tpl_name, null);
		if (is_file($file)) {
			$tpl_source = $smarty->_read_file($file);
			return true;
		}
		return false;
	}

	function smarty_resource_path_timestamp($tpl_name, &$tpl_timestamp, &$smarty) {
		
		// Check for a valid FE instance (this plugin cannot be run in the backend)
		if(!tx_smarty_div::validateTypo3Instance('FE')) {
			$smarty->trigger_error($smarty->fePluginError);
			return false;
		}
				
		// Make sure there is a valid instance of tslib_cObj
		if (!method_exists($smarty->cObj,'getData')) {
			$smarty->trigger_error('TYPO3 Method getData unavailable in smarty_resource_path_source');
			return false;
		}
		$file = $smarty->cObj->getData('path:'.$tpl_name, null);
		if (is_file($file)) {
			$tpl_timestamp = filemtime($file);
			return true;
		}
		return false;
	}

	function smarty_resource_path_secure($tpl_name, &$smarty) {
		return false;
	}

	function smarty_resource_path_trusted($tpl_name, &$smarty) {
		return true;
	}

	// register the resource name 'path'
	$smarty->register_resource('path', array('smarty_resource_path_source','smarty_resource_path_timestamp','smarty_resource_path_secure','smarty_resource_path_trusted'));

?>