<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006 Rueegg Tuck Partner (t3@rtpartner.ch)
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
***************************************************************/

/**
 *
 * Smarty plugin "object"
 * -------------------------------------------------------------
 * File:	function.object.php
 * Type:	function
 * Name:	TypoScript Object
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose:	Gets and displays an object from global TyposScript template scope
 * Example:	{object setup="lib.myImage" type="IMAGE"}
 * Example:	{object setup="lib.myMenu" type="HMENU" 1.NO.wrap="<li class='innermenu'>|</li>"}
 * Note:	The parameter "setup" references the typoscript object from the global TypoScript
 *			template scope. For example, if your TypoScript setup contains an element myImage
 *			setup="lib.myImage" will insert the content object defined in lib.myImage.
 * Note:	Any parameters inside the object tag will override the corresponding parameters in the TypoScript
 *			object. For example, {object setup="lib.myMenu" type="HMENU" entryLevel="2"}
 *			will insert the HMENU object defined in lib.myMenu and set the entryLevel of the HMENU to 2
 * Note:	You can manually define the object type with the paramter "type", e.g.
 * 			{object setup="lib.myImage" type="IMAGE"}
 * -------------------------------------------------------------
 *
 **/


	function smarty_function_object($params, &$smarty) {
			
		// Check for a valid FE instance (this plugin cannot be run in the backend)
		if(!tx_smarty_div::validateTypo3Instance('FE')) {
			$smarty->trigger_error($smarty->fePluginError);
			return false;
		}
		
		// Make sure there is a valid instance of tslib_cObj
		if (!method_exists($smarty->cObj,'cObjGetSingle')) {
		    $smarty->trigger_error('TYPO3 Method cObjGetSingle unavailable in smarty_function_object');
		    return;
		}

		// Get type from params
		if ($params['type']) {
			$type = $params['type'];
			unset($params['type']);
		}

		// Get TypoScript from $params
		$setup = tx_smarty_div::getTypoScriptFromParams($params);

		// if available use $type to define TypoScript object type (e.g. COA, IMAGE, SELECT etc. )
		if ($type) $setup[0] = $type;

		// return the content object
		if($setup[0]) return $smarty->cObj->cObjGetSingle($setup[0],$setup[1]);

	}

?>