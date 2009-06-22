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
 * Smarty plugin "lookup"
 * -------------------------------------------------------------
 * File:    function.lookup.php
 * Type:    function
 * Name:    Data
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Returns DB result for a given table and value, usually from a get or post var
 * Example: {lookup GPvar="email" field="email" table="fe_users" alias="name"} Returns the name corresponding to
 * 			the email address supplied in Post/Get
 * Example: {lookup data="GPvar:tx_myext|uid" field="uid" table="ty_mext" alias="title"} Returns the title corresponding to
 * 			the uid supplied in Post/Get. For details on the "data" function check "getText" at:
 * 			http://typo3.org/documentation/document-library/references/doc_core_tsref/current/view/2/2/
 * -------------------------------------------------------------
 *
 **/


	function smarty_function_lookup($params, &$smarty) {
			
		// Check for a valid FE instance (this plugin cannot be run in the backend)
		if(!tx_smarty_div::validateTypo3Instance('FE')) {
			$smarty->trigger_error($smarty->fePluginError);
			return false;
		}		

		// Make sure there is a valid instance of tslib_cObj
		if (!method_exists($smarty->cObj,'getData') || !method_exists($GLOBALS['TSFE']->sys_page, 'getRecordsByField')) {
		    $smarty->trigger_error('TYPO3 Method getData and/or getRecordsByField unavailable in smarty_function_lookup');
		    return;
		}

		// Make sure params are lowercase
		$params = array_change_key_case($params,CASE_LOWER);
		
		// Get the table, exit if unknown table
		if(!$params['table']) {
			$params['table'] = 'pages';
		} elseif(!in_array($params['table'], $GLOBALS['TYPO3_DB']->admin_get_tables())) {
		    $smarty->trigger_error('Unknown table "'.$params['table'].'" in smarty_function_lookup');
		    return;	// Exit if unknown table		
		}
		
		// Get the lookup field, exit if unknown field		
		if(!$params['field']) {
			$params['field'] = 'uid'; 
		} elseif (!array_key_exists($params['field'], $GLOBALS['TYPO3_DB']->admin_get_fields($params['table']))) {
		    $smarty->trigger_error('Unknown field "'.$params['field'].'" in table "'.$params['table'].'" in smarty_function_lookup');
		    return;	// Exit if unknown field				
		}
	
		// Get the field value to return, exit if unknown field		
		if(!$params['alias']) {
			t3lib_div::loadTCA($params['table']);
			$params['alias'] = $GLOBALS['TCA'][$params['table']]['ctrl']['label']; // Default alias is the record label
		} elseif (!array_key_exists($params['alias'], $GLOBALS['TYPO3_DB']->admin_get_fields($params['table']))) {
			$smarty->trigger_error('Unknown alias "'.$params['alias'].'" in table "'.$params['table'].'" in smarty_function_lookup');
		    return;	// Exit if unknown field				
		}	
		
		// Get the value to lookup
		if($params['gpvar']) {
			$lookupValue = $smarty->cObj->getData('GPVar:'.$params['gpvar']);
		} elseif($params['data']) {
			$lookupValue = $smarty->cObj->getData($params['data']);
		}
		
		// Find and return the matching value
		if(is_scalar($lookupValue)) {
			$result = $GLOBALS['TSFE']->sys_page->getRecordsByField(
				$params['table'], 
				$params['field'], 
				$lookupValue, // NOTE: getRecordsByField cleans the lookup value
				$GLOBALS['TSFE']->sys_page->enableFields($params['table']),
				'', 
				'', 
				1
			);
			if($result[0][$params['alias']]) return $result[0][$params['alias']];
		}
	}

?>