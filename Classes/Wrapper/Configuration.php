<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006-2007 Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
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


class tx_smarty_settings
{

	// Array of Smarty class variables
	// For details check http://smarty.php.net/manual/en/api.variables.php
	// Variables set to 1 are directories/files and will return an absolute directory/filename
	private $smartySettings = array(
		'autoload_filters' => 0,				// Array: Filters that load on every template invocation. The variable is an associative array where keys are filter types (pre,post,output) and values are arrays of the filter names.
		'cache_dir' => 1,						// String: Name of the directory where template caches are stored (must be either a relative or absolute path)
		'cache_handler_func' => 0,				// callback function: You can supply a custom function to handle cache files instead of using the built-in method
		'cache_lifetime' => 0,					// Int: This is the length of time in seconds that a template cache is valid (default 3600)
		'cache_modified_check' => 0,			// Boolean: If set to true, Smarty will respect the If-Modified-Since header sent from the client.
		'caching' => 0,							// Boolean: This tells Smarty whether or not to cache the output of the templates to the $cache_dir. (FALSE, default)
		'respect_no_cache' => 0,				// Boolean: If enabled Smarty wil respect the TYPO3 no_cache parameter and disable caching (if enabled) whenever no_cache is invoked. 
		'compile_check' => 0,					// Boolean: Upon each invocation of the PHP application, Smarty tests to see if the current template has changed
		'compile_dir' => 1,						// String: Name of the directory where compiled templates are located (must be either a relative or absolute path)
		'compile_id' => 0,						// String: Persistant compile identifier.
		'compiler_class' => 0,					// Callback function: Specifies the name of the compiler class that Smarty will use to compile the templates
		'config_booleanize' => 0,				// Boolean: If set to true, config file values of on/true/yes and off/false/no get converted to boolean values automatically
		'config_dir' => 1,						// String: This is the directory used to store config files  used in the templates
		'config_fix_newlines' => 0,				// Boolean: If set to true, mac and dos newlines (\r and \r\n) in config files are converted to \n when they are parsed.
		'config_overwrite' => 0,				// Boolean: If set to true (by default), variables read in from config files will overwrite each other.
		'config_read_hidden' => 0,				// Boolean: If set to true, hidden sections (section names beginning with a period) in config files  can be read from templates.
		'debug_tpl' => 1,						// String: This is the (name and location) of the template file used for the debugging console
		'debugging_ctrl' => 0,					// Keyword: Alternate ways to enable debugging. NONE means no alternate methods are allowed. URL means when the keyword SMARTY_DEBUG is found in the QUERY_STRING
		'debugging' => 0,						// Boolean: This enables the debugging console
		'default_resource_type' => 0,			// Keyword: This tells smarty what resource type to use implicitly.
		'default_template_handler_func' => 0,	// Callback function: This function is called when a template cannot be obtained from its resource.
		'error_reporting' => 0,					// Int: When this value is set to a non-null-value it's value is used as php's error_reporting level inside of display() and fetch()
		'force_compile' => 0,					// Boolean: This forces Smarty to (re)compile templates on every invocation.
		'left_delimiter' => 0,					// String: This is the left delimiter used by the template language. Default is "{"
		'php_handling' => 0,					// Keyword: This tells Smarty how to handle PHP code embedded in the templates. (keywords SMARTY_PHP_PASSTHRU, SMARTY_PHP_QUOTE, SMARTY_PHP_REMOVE, SMARTY_PHP_ALLOW)
		'plugins_dir' => 1,						// Array: Locations where Smarty will look for the plugins that it needs
		'request_use_auto_globals' => 0,		// Boolean: Specifies if Smarty should use php's $HTTP_*_VARS[] (FALSE) or or $_*[] (TRUE, default)
		'request_vars_order' => 0,				// String: The order in which request variables are registered, similar to variables_order in php.ini
		'right_delimiter' => 0,					// String: This is the right delimiter used by the template language. Default is "}"
		'secure_dir' => 1,						// Array: Locations Smarty considers secure for include_php
		'security_settings' => 0,				// Array: These are used to override or specify the security settings when $security is enabled. For details check http://smarty.php.net/manual/en/variable.security.settings.php
		'security' => 0,						// Boolean: Enforces security rules
		'template_dir' => 1,					// String: This is the name of the default template directory
		'trusted_dir' => 1,						// Array: Locations Smarty considers secure for include and fetch
		'use_sub_dirs' => 0,					// Boolean: Smarty will create subdirectories under the templates_c and cache directories if $use_sub_dirs is set to true.
	);

	/**
     * @param $variable
     * @param $value
     * @return bool
     */
	public function set($variable, $value)
    {
		$smartyVar = preg_replace('/\.?$/m', '', trim(strtolower($smartyVar)));
		if (!in_array($smartyVar,array_keys($this->t3_smartyVars))) return false; // Exit if no corresponding Smarty class variable exists
		if(is_array($this->{$smartyVar}) || is_array($smartyValue)) {
			$smartyValue = (is_array($smartyValue))?tx_smarty_div::removeDotsFromTS($smartyValue):t3lib_div::trimExplode(',',$smartyValue,1);
			$smartyValue = array_map(array('tx_smarty_div','booleanize'),$smartyValue);
			if($this->t3_smartyVars[$smartyVar]) {
				$smartyValue = array_map(array('tx_smarty_div','getFileAbsName'),$smartyValue);
			}
			$this->{$smartyVar} = array_merge_recursive($this->{$smartyVar},$smartyValue);
		} else {
			if($this->t3_smartyVars[$smartyVar]) {
				$smartyValue = tx_smarty_div::getFileAbsName($smartyValue);
			}
			$this->{$smartyVar} = tx_smarty_div::booleanize($smartyValue);
		}
		return true;
	}

	// Get the language file for the FE translation plugin
	// NOTE: If param is an object, function will try to get the language file from the extension class (pi_base or lib/div)
	function setPathToLanguageFile($param) {
		if(is_object($param)) {
			if($langFile = t3lib_div::getFileAbsFileName($this->t3_conf['pathToLanguageFile']) && @is_file($langFile)) {
				// Explicit language file definition in Smarty TypoScript has 1st priority
				$this->t3_languageFile = $langFile;
			} elseif(is_subclass_of($param,'tslib_pibase')) { // Else check for pi_base scenario...
				$basePath = t3lib_extMgm::extPath($param->extKey).dirname($param->scriptRelPath).'/locallang';
				$file = t3lib_div::getFileAbsFileName($basePath);
				if (@is_file($file.'.xml')) { // Check for XML file
					$this->t3_languageFile = $file.'.xml';
				} elseif(@is_file($file.'.php')) { // or PHP file
					$this->t3_languageFile = $file.'.php';
				}
			} elseif(is_subclass_of($param,'tx_lib_object')) { // ...or lib/div mvc scenario
				$this->t3_languageFile = $param->controller->configurations->get('pathToLanguageFile');
			}
		} elseif($langFile = t3lib_div::getFileAbsFileName($param)) {
			if(@is_file($langFile))	{
				$this->t3_languageFile = $langFile;
			}
		}
	}
}