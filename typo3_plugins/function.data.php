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
 * Smarty plugin "data"
 * -------------------------------------------------------------
 * File:    function.data.php
 * Type:    function
 * Name:    Data
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Implements the TypoScript data type "getText". For details check
 * 			http://typo3.org/documentation/document-library/references/doc_core_tsref/current/view/2/2/
 * Example: {data source="page:title"} Gets the current page title
 * Example: {data source="DB:tt_content:234:header"} Gets the header for content id 234
 * Example: {data source="DB:TSFE:lang"} Gets the current language key
 * Note:	Use the parameter "source" to define the type & pointer for the getText function
 * -------------------------------------------------------------
 *
 **/


	function smarty_function_data($params, &$smarty) {
	
		// Check for a valid FE instance (this plugin cannot be run in the backend)
		if(!tx_smarty_div::validateTypo3Instance('FE')) {
			$smarty->trigger_error($smarty->fePluginError);
			return false;
		}		

		// Make sure there is a valid instance of tslib_cObj
		if (!method_exists($smarty->cObj,'getData')) {
		    $smarty->trigger_error('TYPO3 Method getData unavailable in smarty_function_data');
		    return;
		}

		// Make sure params are lowercase
		$params = array_change_key_case($params,CASE_LOWER);

		if ($params['source']){
			// Return result from getData
			return $smarty->cObj->getData($params['source'], null);
		}
	}

?>