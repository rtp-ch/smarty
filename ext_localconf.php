<?php

if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

if (!defined('SMARTY_RESOURCE_CHAR_SET')) {
    if (!defined('SMARTY_MBSTRING')) {
        define('SMARTY_MBSTRING', function_exists('mb_split'));
    }
    // @TODO: Explore options and effects
    // UTF-8 can only be done properly when mbstring is available!
    define('SMARTY_RESOURCE_CHAR_SET', SMARTY_MBSTRING ? 'UTF-8' : 'ISO-8859-1');
}

// PSR-2 Compatibility
if (!defined('PATH_site') && !defined('PATH_SITE')) {
    define('PATH_SITE', PATH_site);
}

// PSR-2 Compatibility
if (defined('TYPO3_cliMode') && !defined('TYPO3_CLI_MODE')) {
    define('TYPO3_CLI_MODE', TYPO3_cliMode);
}

// Include the the smarty library if it hasn't already been loaded
if (!defined('SMARTY_DIR')) {
    require_once Tx_Smarty_Service_Compatibility::extPath('smarty') . 'vendor/autoload.php';
}

// Include the smarty extension's factory class
require_once Tx_Smarty_Service_Compatibility::extPath('smarty') . 'Classes/Factory.php';

// Hook for clearing smarty cache
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][]
    = 'EXT:smarty/Classes/Hooks/ClearCache.php:&Tx_Smarty_Hooks_ClearCache->clearSmartyCache';