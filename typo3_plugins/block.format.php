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
 * File:    block.format.php
 * Type:    block
 * Name:    Format
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Formats a block of text according to lib.parseFunc_RTE
 * Example: {format}
 *				These lines of text will
 *				will be formatted according to the
 *				rules defined in lib.parseFunc_RTE
 *				for example, individual lines will be wrapped in p tags.
 *			{/format}
 * Note:	For more details on lib.parseFunc_RTE & parseFunc in general see:
 *			http://typo3.org/documentation/document-library/references/doc_core_tsref/4.1.0/view/5/14/
 * Note:	To define an alternate parseFunc configuration set the paramater "parsefunc"
 *			in the tag e.g. {format parsefunc="lib.myParseFunc"}Hello World{/rte}
 * -------------------------------------------------------------
 *
 **/


	function smarty_block_rte($params, $content, &$smarty) {

		// Make sure there is a valid instance of tslib_cObj
		if (!method_exists($smarty->cObj,'parseFunc')) {
		    $smarty->trigger_error('TYPO3 Method parseFunc unavailable in smarty_block_rte');
		    return $content;
		}

		// Get the default parseFun configuration
		$params['setup'] = ($params['setup'])?$params['setup']:'lib.parseFunc_RTE';

		// Get TypoScript from $params
		$setup = tx_smarty_div::getTypoScriptFromParams($params);

		// Process the content with parseFunc configuration
		return $smarty->cObj->parseFunc($content,$setup);

	}

?>