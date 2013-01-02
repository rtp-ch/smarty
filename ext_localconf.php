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

// Include the main extension class
// require_once(t3lib_extMgm::extPath($_EXTKEY) . 'Vendors/Rtp/Wrapper/class.tx_smarty.php');

// Hook for clearing smarty cache
// $TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = t3lib_extMgm::extPath($_EXTKEY).'hook/ClearCache.php:&tx_smarty_cache->clearSmartyCache';