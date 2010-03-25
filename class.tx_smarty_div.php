<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2007 Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
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
 * @copyright 	2007 Rueegg Tuck Partner GmbH
 * @author 		Simon Tuck <stu@rtpartner.ch>
 * @link 		http://www.rtpartner.ch/
 * @package 	Smarty (smarty)
 **/

// Include TypoScript parser class
require_once(PATH_t3lib.'class.t3lib_tsparser.php');

class tx_smarty_div {

    private static $_tsParser        = null;

    private function _getTsParser()
    {
        if(is_null(self::$_tsParser)) {
            self::$_tsParser = t3lib_div::makeInstance('t3lib_tsparser');
        }
        return self::$_tsParser;
    }

	// Turns yes/no, true/false, on/off into booleans. !IMPORANT
	function booleanize($value)  
	{
		if(is_scalar($value)) {
		    if (preg_match("/^(on|true|yes)$/i", trim($value))) {
	            $value = true;
	        } elseif (preg_match("/^(off|false|no)$/i", trim($value))) {
	            $value = false;
	        }			
		}
        return $value;
	}

	// Checks against valid TYPO3 instance
	function validateTypo3Instance($instances = null)
	{
		if(empty($instances) || !defined('TYPO3_MODE')) return false;
		$instances = t3lib_div::trimExplode(',', strtoupper($instances), 1);
		if(in_array(TYPO3_MODE, $instances)) return true;
		return false;
	}

	// Retrieves a TypoScript object from the global setup scope ($GLOBALS['TSFE']->tmpl->setup)
	function getTypoScriptFromTMPL($key)
	{
		if(!$key) return false;
		if ($setup = self::_getTsParser()->getVal($key, $GLOBALS['TSFE']->tmpl->setup)) return $setup;
		return false;
	}

	// Turns an array (assumed to be TypoScript Parameters) into
	// text. Any occurences of _DOT_ (see prefilter dots) are replaced with a dot (.)
	function makeTypoScriptFromArray($params)
	{
	    $return = null;
		foreach($params as $param => $value) {
			$return .= str_replace('_DOT_','.',$param) . ' = ' . $value . chr(10);
		}
		return $return;
	}

	// Parses a block of text (assumed to be TypoScript) and, if successful,
	// returns an array:
	// $setup[0]	The TypoScript object, e.g. IMAGE or TEXT etc.
	// $setup[1]	The configuration array of the object
	function parseTypoScript($typoscript)
	{
		if(!$typoscript) return false;
		if (is_array($typoscript)) $typoscript = tx_smarty_div::makeTypoScriptFromArray($typoscript);
		if(!is_null($typoscript)) {
    		self::_getTsParser()->parse($typoscript);
    		if($setup = self::_getTsParser()->setup) return $setup;
		}
		return false;
	}

	// General function to return TypoScript from plugin params
	// The special param 'setup' is assumed to reference a TypoScript object from the global scope
	function getTypoScriptFromParams($params) {
	    unset(self::_getTsParser()->setup); // Unset previous TS
		if($params['setup']) {
			$setup = tx_smarty_div::getTypoScriptFromTMPL($params['setup']);
			unset($params['setup']);
		}
		if($params) $params = tx_smarty_div::parseTypoScript($params); // Create a TypoScript array from $params
		if($params && $setup) $setup[1] = t3lib_div::array_merge_recursive_overrule($setup[1], $params, false, true); // Merge $setup & $params
		return $setup ? $setup : array(1 => $params);
	}

	// Get an absolute file/dir reference (trailing slashes are stripped)
	function getFileAbsName($filename) {
		$location = t3lib_div::getFileAbsFileName($filename,0);
		if(@is_readable($location)) {
			return substr($location, -1) == DIRECTORY_SEPARATOR ? substr($location, 0, -1) : $location;
		}
		return $filename;
	}

	/**
	 * Note: This function is required but not available in earlier TYPO3 versions
	 * Removes dots "." from end of a key identifier of TypoScript styled array.
	 * array('key.' => array('property.' => 'value')) --> array('key' => array('property' => 'value'))
	 *
	 * @param	array	$ts: TypoScript configuration array
	 * @return	array	TypoScript configuration array without dots at the end of all keys
	 */
	function removeDotsFromTS($ts) {
		$out = array();
		if (is_array($ts)) {
			foreach ($ts as $key => $value) {
				if (is_array($value)) {
					$key = rtrim($key, '.');
					$out[$key] = tx_smarty_div::removeDotsFromTS($value);
				} else {
					$out[$key] = $value;
				}
			}
		}
		return $out;
	}
}

?>