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
 * Smarty plugin "img_resource"
 * -------------------------------------------------------------
 * File:    function.img_resource.php
 * Type:    function
 * Name:    Image Resource
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Renders IMG_RESOURCE cObjects
 * Example:	{img_resource file="fileadmin/pic.jpg" file.width="150" }
 * Note:	You can add any property valid for the TypoScript IMG_RESOURCE object,
 *			For example, file="fileadmin/pic.jpg" or width="150" or file.height="180c" etc.
 *			For details of available parameters check the IMAGE, imgResource and GIFBUILDER documentation at:
 * 			http://typo3.org/documentation/document-library/references/doc_core_tsref/4.1.0/view/8/6/
 *			http://typo3.org/documentation/document-library/references/doc_core_tsref/4.1.0/view/5/2/
 *			http://typo3.org/documentation/document-library/references/doc_core_tsref/4.1.0/view/8/6/
 * Note:	The parameter "setup" will reference the global template scope, so you can pass a typoscript
 *			object which defines your link configuratiopn.
 *			For example, if your TypoScript setup contains an element lib.myImage, adding
 *			setup="lib.myImage" will use the TypoScript configuration from lib.myImage to create the image
 * Note:	Any parameters inside the image tag will override the corresponding parameters in the TypoScript
 *			object from setup. For example, {image setup="lib.myImage" file.width="150c"}
 *			will use the TypoScript configuration from lib.myImage, but set the property 'file.width' to 150c
 * -------------------------------------------------------------
 *
 **/


	function smarty_function_img_resource($params, &$smarty) {

		// Make sure there is a valid instance of tslib_cObj
		if (!method_exists($smarty->cObj,'IMG_RESOURCE')) {
		    $smarty->trigger_error('TYPO3 Method IMG_RESOURCE unavailable in smarty_function_img_resource');
		    return;
		}

		// Get TypoScript from $params
		$setup = tx_smarty_div::getTypoScriptFromParams($params);

		// return the typolink
		return $smarty->cObj->IMG_RESOURCE($setup[1]);

	}

?>
