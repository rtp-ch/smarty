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
 * Smarty plugin "LLL"
 * -------------------------------------------------------------
 * File:    block.LLL.php
 * Type:    block
 * Name:    Translate Text
 * Version: 1.1
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Translate a block of text from the current TYPO3 language library (e.g. locallang.xml)
 * Example: {LLL alt="Please enter your name" label="enter_name"}Your name{/LLL}
 * Note:	The parameter 'label' refers to the label in the xml file. If you do not provide a label
 * 			the content between the tags will be used as the label.
 * Note:	The 'alt' parameter enables you to provide an alternative text if no translation was found.
 * Note:	If the translated text contains Smarty variables it will be cycled through Smarty again!
 *			That means you can include Smarty tags in your language library
 * -------------------------------------------------------------
 *
 **/


	function smarty_block_LLL($params, $content, &$smarty) {
		
		// Check for a valid FE instance (this plugin cannot be run in the backend)
		if(!tx_smarty_div::validateTypo3Instance('FE')) {
			$smarty->trigger_error($smarty->fePluginError);
			return false;
		}	

		// Make sure params are lowercase
		$params = array_change_key_case($params,CASE_LOWER);

		// Key for looking up the translation in the language file
		$key = ($params['label'])?$params['label']:$content;

		// Exit if no key was provided
		if(!$key) return;

		// Get the language file and/or label information from the key
		if(!strcmp(strtoupper(substr($key, 0, 4)),'LLL:')) {
		    $key = substr($key, 4);
		}
	
		if($parts = t3lib_div::trimExplode(':', $key, 1)) {
			$key = array_pop($parts);
			$language_file = implode(':',$parts);
		}
		$language_file = ($language_file)?$language_file:$smarty->t3_languageFile;
		// FIXED: For windows - only use relative path for readLLfile
		$language_file = str_replace(PATH_site, '', $language_file);
		// Call the sL method from tslib_fe to translate the label
		$translation = $GLOBALS['TSFE']->sL('LLL:'.$language_file.':'.$key);

		// Exit if no translation was found
		if(!$translation) {
			if(!empty($params['alt'])) return $params['alt'];
			// Trigger an error if no alternate was available
			$smarty->trigger_error('Translation unavailable for key "'.$key.'" in language "'.$GLOBALS['TSFE']->lang.'"');
			return $content;
		}

		// If the result contains Smarty template vars run it through Smarty again
		if (preg_match('/['.quotemeta($smarty->left_delimiter).'[^'.quotemeta($smarty->right_delimiter).']*'.quotemeta($smarty->right_delimiter).'/m', $translation)) {
			return ($params['hsc'])?htmlspecialchars($smarty->display('string:'.$translation)):$smarty->display('string:'.$translation);
		} else {
			return ($params['hsc'])?htmlspecialchars($translation):$translation;
		}
	}

?>