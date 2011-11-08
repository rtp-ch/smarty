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
 * Smarty plugin "format"
 * -------------------------------------------------------------
 * File:    modifier.format.php
 * Type:    modifier
 * Name:    Format
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Formats a variable according to lib.parseFunc_RTE
 * Example: {$assignedPHPvariable|format}
 * Note:	For more details on lib.parseFunc_RTE & parseFunc in general see:
 *			http://typo3.org/documentation/document-library/references/doc_core_tsref/4.1.0/view/5/14/
 * Note:	To define an alternate parseFunc configuration set the paramater "parsefunc"
 *			in the tag e.g. {$assignedPHPvariable|format:"lib.myParseFunc"}
 * -------------------------------------------------------------
 *
 **/


	function smarty_modifier_format($text, $setup=false) {
			
		// Check for a valid FE instance (this plugin cannot be run in the backend)
		if(!tx_smarty_div::validateTypo3Instance('FE')) {
			return 'The smarty plugin you are using is only available in the frontend';
		}
		
		// Get an instance of tslib_cobj
		$cObj = t3lib_div::makeInstance('tslib_cobj');

		if ($setup) {
			// Process the content with the defined parseFunc configuration
			return $cObj->parseFunc($text,'','<'.$setup);
		} else {
			// Process the content with default RTE parseFunc configuration
			return $cObj->parseFunc($text,$GLOBALS['TSFE']->tmpl->setup['lib.']['parseFunc_RTE.']);
		}
	}

?>
