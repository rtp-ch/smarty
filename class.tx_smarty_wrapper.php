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

// Include main smarty class
require_once(SMARTY_DIR.'Smarty.class.php');

// Include smarty plugin helper functions
require_once(t3lib_extMgm::extPath('smarty').'/class.tx_smarty_div.php');

// Create a wrapper class extending Smarty
class tx_smarty_wrapper extends Smarty {

	var $cObj; // Instance of tslib_cobj
	var $pObj; // Instance of parent class

	var $t3_confVars; // Collection of configuration arrays (Settings for Smarty class vars)
	var $t3_conf; // Final configuration array, applied to Smarty
	var $t3_extVars; // Extension settings, e.g. extension key, extension path
	var $t3_languageFile; // Name & location of the TYPO3 language file
	var $_debug_resource; // Name and location of current template (used for debugging)

	// Array of Smarty class variables
	// For details check http://smarty.php.net/manual/en/api.variables.php
	// Variables set to 1 are directories/files and will return an absolute directory/filename
	var $t3_smartyVars = array(
		'autoload_filters' => 0,				// Array: Filters that load on every template invocation. The variable is an associative array where keys are filter types (pre,post,output) and values are arrays of the filter names.
		'cache_dir' => 1,						// String: Name of the directory where template caches are stored (must be either a relative or absolute path)
		'cache_handler_func' => 0,				// callback function: You can supply a custom function to handle cache files instead of using the built-in method
		'cache_lifetime' => 0,					// Int: This is the length of time in seconds that a template cache is valid (default 3600)
		'cache_modified_check' => 0,			// Boolean: If set to true, Smarty will respect the If-Modified-Since header sent from the client.
		'caching' => 0,							// Boolean: This tells Smarty whether or not to cache the output of the templates to the $cache_dir. (FALSE, default)
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

	// Creates a new instance of Smarty with references to the parent class and the current instance of tslib_cobj
	function startSmarty(&$pObj) {
		// Run Smarty's constructor
		$this->Smarty();
		// Register reference to the calling class
		$this->pObj = $pObj;
		// Register reference to tslib_cobj
		$this->cObj = &$GLOBALS['TSFE']->cObj;
	}

	// Generic function to set Smarty class vars
	function setSmartyVar($smartyVar,$smartyValue) {
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

	// Modifies smarty display function to always use fetch (display=false)
	// and to attach the debug console in fetch
	function display($resource_name, $cache_id = null, $compile_id = null) {
		$this->_getResourceInfo($resource_name); // Saves resource info to a Smarty class var for debugging
		$_t3_fetch_result = $this->fetch($resource_name, tx_smarty_div::getCacheID($cache_id), $compile_id);
        if ($this->debugging) { // Debugging will have been evaluated in fetch
            require_once(SMARTY_CORE_DIR . 'core.display_debug_console.php');
            $_t3_fetch_result .= smarty_core_display_debug_console(array(), $this);
        }
		return $_t3_fetch_result;
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
		} elseif($langFile = t3lib_div::getFileAbsFileName($param) && @is_file($langFile)) {
			$this->t3_languageFile = $langFile;
		}
	}

	// Check for availability of a plugin function and load
	// the corresponding plugin if the function is not yet available
	function getAndLoadPlugin($type,$name) {
		$funcName = 'smarty_'.strtolower($type).'_'.$name;
		if(!function_exists($funcName)) {
			$plugin = $this->_get_plugin_filepath($type, $name);
			if(!@is_readable($plugin)) {
				$this->trigger_error('Smarty plugin "'.$name.'" unavailable');
				return false;
			}
			include_once($plugin);
		}
		return $funcName;
	}


	// Saves resource info to a Smarty class var for debugging
	function _getResourceInfo($resource_name) {
		$this->_debug_resource['dirname'] = $this->template_dir;
		$this->_debug_resource['basename'] = $this->_smarty_debug_info[0]['filename'];
		$this->_debug_resource['resourcename'] = $resource_name;
		$this->_debug_resource['smartyClassVars'] = array();
		foreach ($this->t3_smartyVars as $var => $value) {
		   $this->_debug_resource['smartyClassVars'][$var] = $this->{$var};
		}
		ksort($this->_debug_resource['smartyClassVars']);
	}

    /**
	 * get a concrete filename for automagically created content
	 * Modifies the function _get_auto_filename to enable using strings as
	 * smarty resources (http://smarty.incutio.com/?page=resource_string)
	 *
	 * @param	string		$auto_base
	 * @param	string		$auto_source
	 * @param	string		$auto_id
	 * @return	string
	 * @staticvar string|null
	 * @staticvar string|null
	 */
    function _get_auto_filename($auto_base, $auto_source = null, $auto_id = null) {
        $_compile_dir_sep =  $this->use_sub_dirs ? DIRECTORY_SEPARATOR : '^';
        $_return = $auto_base . DIRECTORY_SEPARATOR;

        if(isset($auto_id)) {
            // make auto_id safe for directory names
            $auto_id = str_replace('%7C',$_compile_dir_sep,(urlencode($auto_id)));
            // split into separate directories
            $_return .= $auto_id . $_compile_dir_sep;
        }

        if(isset($auto_source)) {
            // make source name safe for filename
            $_filename = urlencode(basename($auto_source));
            $_crc32 = sprintf('%08X', crc32($auto_source));
            // prepend %% to avoid name conflicts with
            // with $params['auto_id'] names
            $_crc32 = substr($_crc32, 0, 2) . $_compile_dir_sep .
                      substr($_crc32, 0, 3) . $_compile_dir_sep . $_crc32;
// XXX: Changed from $_filename to md5($_filename)
            $_return .= '%%' . $_crc32 . '%%' . md5($_filename);
        }
        return $_return;
    }
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/smarty/class.tx_smarty_wrapper.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/smarty/class.tx_smarty_wrapper.php']);
}

?>