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
 * Smarty plugin "l10n"
 * -------------------------------------------------------------
 * File:    function.l10n.php
 * Type:    function
 * Name:    Translate
 * Version: 1.0
 * Author:	Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Translate a block of text from the current TYPO3 language library (e.g. locallang.xml)
 * Example: {l10n label="enter_name"}
 * Note:	The parameter 'label' refers to the label xml file. If you do not provide a key
 * 			the content between the tags will be used as the key.
 * Note:	The 'alt' parameter enables you to provide an alternative text if no translation was found.
 * Note:	If the translated text contains Smarty variables it will be cycled through Smarty again!
 *			That means you can include Smarty tags in your language library
 * -------------------------------------------------------------
 *
 **/


	function smarty_function_l10n($params, &$smarty) {
		if($funcName = $smarty->getAndLoadPlugin('block','LLL')) {
			return $funcName($params, '', $smarty);
		} else {
			return ($params['alt'])?$params['alt']:'';
		}
	}

?>