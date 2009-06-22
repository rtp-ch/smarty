<?php

/***************************************************************
 *  Copyright notice
 *
 *
 *	Created by Simon Tuck <stu@rtpartner.ch>
 *	Copyright (c) 2006-2009, Rueegg Tuck Partner GmbH (wwww.rtpartner.ch)
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
 *	@copyright 	Rueegg Tuck Partner GmbH
 *	@author 	R. Alessandri <ral@rtpartner.ch>
 *	@link 		http://www.rtpartner.ch/
 *	@package 	Smarty (smarty)
 *
 ***************************************************************/

/**
 *
 * Smarty plugin "multimedia"
 * -------------------------------------------------------------
 * File:    function.multimedia.php
 * Type:    function
 * Name:    Multimedia
 * Version: 1.0
 * Author:  R. Alessandri <ral@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Displays any object from global TS (such as IMAGE, COA, TEXT, etc.)
 * Example:	{multimedia file="fileadmin/anim.swf" params.width="150" }
 * Example:	{multimedia setup="lib.myMultimedia" params.width="150" params.height="180c"}
 * Note:	You can add any property valid for the TypoScript MULTIMEDIA object,
 *			For example, file="fileadmin/anim.swf" or params.width="150" etc.
 *			For details of available parameters check the MULTIMEDIA documentation at:
 * 			http://typo3.org/documentation/document-library/core-documentation/doc_core_tsref/4.2.0/view/1/8/#id4302297
 * Note:	The parameter "setup" will reference the global template scope, so you can pass a typoscript
 *			object which defines your link configuratiopn.
 *			For example, if your TypoScript setup contains an element lib.myMultimedia, adding
 *			setup="lib.myMultimedia" will use the TypoScript configuration from lib.myMultimeda to create the multimedia object
 * Note:	Any parameters inside the multimedia tag will override the corresponding parameters in the TypoScript
 *			object from setup. For example, {multimedia setup="lib.myMultimedia" params.width="150"}
 *			will use the TypoScript configuration from lib.myMultimedia, but set the property 'params.width' to 150
 * -------------------------------------------------------------
 *
 **/


	function smarty_function_multimedia($params, &$smarty) {
			
		// Check for a valid FE instance (this plugin cannot be run in the backend)
		if(!tx_smarty_div::validateTypo3Instance('FE')) {
			$smarty->trigger_error($smarty->fePluginError);
			return false;
		}
		
		// Make sure there is a valid instance of tslib_cObj
		if (!method_exists($smarty->cObj,'MULTIMEDIA')) {
		    $smarty->trigger_error('TYPO3 Method MULTIMEDIA unavailable in smarty_function_multimedia');
		    return;
		}

		// Get TypoScript from $params
		$setup = tx_smarty_div::getTypoScriptFromParams($params);

		// return the multimedia object
		return $smarty->cObj->MULTIMEDIA($setup[1]);

	}

?>