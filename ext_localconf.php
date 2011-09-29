<?php

	if (!defined ('TYPO3_MODE')) die ('Access denied.');

	// Get default vars from extension configuration
	$_EXTCONF = unserialize($_EXTCONF);

	// Set global extension configuration vars
	$TYPO3_CONF_VARS['EXTCONF'][$_EXTKEY]['smarty_dir'] =
            substr($_EXTCONF['smarty_dir'], -1) === DIRECTORY_SEPARATOR
                ? $_EXTCONF['smarty_dir'] : $_EXTCONF['smarty_dir'] . DIRECTORY_SEPARATOR;

	$TYPO3_CONF_VARS['EXTCONF'][$_EXTKEY]['template_dir'] =
            substr($_EXTCONF['template_dir'], -1) === DIRECTORY_SEPARATOR
                ? $_EXTCONF['template_dir'] : $_EXTCONF['smarty_dir'] . DIRECTORY_SEPARATOR;

	// Include the main extension class
	require_once(t3lib_extMgm::extPath($_EXTKEY) . 'Vendors/Rtp/Wrapper/class.tx_smarty.php');

	// Hook for clearing smarty cache
	$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = t3lib_extMgm::extPath($_EXTKEY).'hook/class.tx_smarty_cache.php:&tx_smarty_cache->clearSmartyCache';