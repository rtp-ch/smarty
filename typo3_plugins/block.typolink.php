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
 * Smarty plugin "typolink"
 * -------------------------------------------------------------
 * File:    block.typolink.php
 * Type:    block
 * Name:    Typolink
 * Version: 2.0
 * Author:	Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Return a linked text using the typolink function
 * Example:	{typolink setup="lib.link" parameter="10"}click here{/typolink}
 * Note:	You can add any property valid for the TypoScript typolink object,
 *			For example, parameter="1" or useCacheHash="1" or addQueryString.exclude="id,L" etc.
 *			For details of available parameters check the typolink documentation at:
 * 			http://typo3.org/documentation/document-library/references/doc_core_tsref/4.1.0/view/5/8/
 * Note:	In addition to the normal typolink parameters you can use parameter="_self" to link to the current
 * 			page. And you can define absRefPrefix="1" to prefix the link with the current base url or 
 * 			absRefPrefix="http://www.mysite.com/" to prefix the link with a different url.
 * Note:	The parameter "setup" will reference the global template scope, so you can pass a typoscript
 *			object which defines your link configuratiopn.
 *			For example, if your TypoScript setup contains an element lib.myLink, adding
 *			setup="lib.myLInk" will use the TypoScript configuration from lib.myLink to build the link
 * Note:	Any parameters inside the typolink tag will override the corresponding parameters in a TypoScript
 *			object. For example, {typolink setup="lib.link" parameter="10"}click here{/typolink} will use
 *			the TypoScript configuration from lib.link, but set the property 'parameter' to 10
 * Note:	If you haven't defined a title for the link the content between the tags will automatically be used
 * 			for the link title attribute.
 * -------------------------------------------------------------
 *
 **/


	function smarty_block_typolink($params, $content, &$smarty) {
	
		// Check for a valid FE instance (this plugin cannot be run in the backend)
		if(!tx_smarty_div::validateTypo3Instance('FE')) {
			$smarty->trigger_error($smarty->fePluginError);
			return false;
		}		

		// Make sure there is a valid instance of tslib_cObj
		if (!method_exists($smarty->cObj,'typolink')) {
		    $smarty->trigger_error('TYPO3 Method typolink unavailable in smarty_block_typolink');
		    return $content;
		}

		// Catch the keyword _self to create a link to the current page
		if($params['parameter']) $params['parameter'] = preg_replace('/^_self\b/im', $GLOBALS['TSFE']->id, $params['parameter']);

		// Get TypoScript from $params
		$setup = tx_smarty_div::getTypoScriptFromParams($params);
		
		// Prefix the url with the base url or a defined path
		// @TODO: Better/proper way to retrieve site url/ base url?
		if($params['absRefPrefix']) {
			$prefix = parse_url($params['absRefPrefix'], PHP_URL_SCHEME) ? trim($params['absRefPrefix']) : trim($GLOBALS['TSFE']->baseUrl);
			if(substr($prefix, -1, 1) !== '/')  $prefix .= '/';
			$tempAbsRefPrefix = $GLOBALS['TSFE']->absRefPrefix; // Save a copy of the current $GLOBALS['TSFE']->absRefPrefix setting
			$GLOBALS['TSFE']->absRefPrefix = $prefix;
		}		

		// Get the typolink
		$link = $smarty->cObj->typolink($content,$setup[1]);
		
		// Copy the original absRefPrefix back into $GLOBALS['TSFE']->absRefPrefix
		if($params['absRefPrefix']) {
			$GLOBALS['TSFE']->absRefPrefix = $tempAbsRefPrefix;
		}

		// Automatically set the "title" attribute from the content of the tag if undefined
		if (!preg_match('%<a[^>]*title=[^>]*>[^<]*</a>%i', $link)) {
			$content = str_replace('"','',$content);
			$link = preg_replace('%(<a[^>]*)(>)([^<]*</a>)%i', '\1 title="'.$content.'">\3', $link);
		}

		// return the typolink
		return $link;

	}

?>