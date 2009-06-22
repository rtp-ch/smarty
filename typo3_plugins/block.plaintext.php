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
 * Smarty plugin "plaintext"
 * -------------------------------------------------------------
 * File:    block.plaintext.php
 * Type:    block
 * Name:    Plaintext
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Turns HTML into plaintext using the html2text class
 * Example: {plaintext}
 *				This is a line of text
 *				This is another line of text
 *				But this will all end up on 1 line...
 *			{/plaintext}
 * Note:	By default multiple linebreaks are collapsed. To preserve linebreaks
 * 			set the parameter 'newlines' to 'keep' (newlines="keep")
 * Note:	By default links are printed in plaintext. To append a list of links
 * 			in the text to the end of the text block set the paramter 'links' to 'append' (links="append").
 * 			To remove links from the text entirely set the parameter 'links' to 'strip' (links="strip")
 * -------------------------------------------------------------
 *
 **/


 	// Include extended version of html2text class
 	require_once(t3lib_extMgm::extPath('smarty').'lib/class.ux_html2text.php');

	function smarty_block_plaintext($params, $content, &$smarty) {
		
		// Check for a valid FE instance (this plugin cannot be run in the backend)
		if(!tx_smarty_div::validateTypo3Instance('FE')) {
			$smarty->trigger_error($smarty->fePluginError);
			return false;
		}
				
		$params = array_change_key_case($params);
		$textConversion = new ux_html2text($content); // New instance of html2text

		// Set the absolute site path
		$baseUrl = preg_replace('%([\\\\|/]*$)%', '', $GLOBALS['TSFE']->baseUrl).'/';
		$textConversion->set_base_url($baseUrl);

		// Eval plugin parameters
		switch(strtolower($params['newlines'])) {
			case 'keep':
				$textConversion->stripLines = false;
				break;
			default:
				$textConversion->stripLines = true;
				break;
		}
		switch(strtolower($params['links'])) {
			case 'strip':
				$n = array_search('$this->_build_link_list("\\1", "\\2")', $textConversion->replace);
				if($n) $textConversion->replace[$n] = '';
				$textConversion->stripLinks = true;
				break;
			case 'append':
				$textConversion->appendLinks = true;
				break;
			default:
				$textConversion->appendLinks = false;
				break;
		}

		// Return plaintext
		return $textConversion->get_text();
	}

?>
