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
 * Smarty plugin "get_debug_info"
 * -------------------------------------------------------------
 * File:    function.function_get_debug_info.php
 * Type:    function
 * Name:    Get debug info
 * Version: 1.1
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Gets debug info for the smarty debug template
 * Example: {get_debug_info}
 * -------------------------------------------------------------
 *
 **/


	function smarty_function_get_debug_info($params, &$smarty) {

		// Template vars (data assigned to Smarty)
		$assigned_vars = $smarty->get_template_vars();
		unset($assigned_vars['SCRIPT_NAME']);
		ksort($assigned_vars);
		if($assigned_vars) {
			$smarty->assign('_assigned_vars', $assigned_vars);
		}
		// Config file variables
		if (@count($smarty->_config[0]['vars']) > 0 || @count($smarty->_config[0]['files']) > 0) {
		    $config_vars = $smarty->_config[0];
		    ksort($config_vars);
		    $smarty->assign('_debug_config_vars', $config_vars);
		}
		// Misc. Smarty vars
		$smarty->assign('_debug_t3_ext_vars', $smarty->t3_extVars);
		$smarty->assign('_debug_resource', $smarty->_debug_resource);
		$smarty->assign('_window_name', str_replace ('.', '_', $smarty->_debug_resource['basename']));

		// Included templates and config files
		// FIXME: Cannot get all includes and avoid recursion in the debug template!
		$smarty->assign('_debug_tpls', $smarty->_smarty_debug_info);

	}

?>
