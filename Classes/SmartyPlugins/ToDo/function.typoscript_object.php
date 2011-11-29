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
 * Smarty plugin "typoscript_object"
 * -------------------------------------------------------------
 * File:	function.typoscript_object.php
 * Type:	function
 * Name:	TypoScript Object
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose:	Gets and displays an object from global TyposScript template scope
 * Example:	{object setup="lib.myImage" type="IMAGE"}
 * Example:	{object setup="lib.myMenu" type="HMENU" 1.NO.wrap="<li class='innermenu'>|</li>"}
 * Note:	typoscript_object is an alias for object
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


	function smarty_function_typoscript_object($params, &$smarty) {
		if($funcName = $smarty->getAndLoadPlugin('function','object')) { // typoscript_object is an alias for object
			return $funcName($params, $smarty);
		}
	}

?>