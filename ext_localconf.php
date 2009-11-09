<?php

	if (!defined ('TYPO3_MODE')) die ('Access denied.');

	// Get default vars from extension configuration
	$_EXTCONF = unserialize($_EXTCONF);

	// Set global extension configuration vars
	$TYPO3_CONF_VARS['EXTCONF'][$_EXTKEY]['smarty_dir'] = preg_replace('%[\\\\|/]$%m', '', $_EXTCONF['smarty_dir']).'/';
	$TYPO3_CONF_VARS['EXTCONF'][$_EXTKEY]['template_dir'] = t3lib_div::getFileAbsFileName(preg_replace('%[\\\\|/]$%m', '', $_EXTCONF['template_dir']));

	// autoinclude the main extension class
	require_once(t3lib_extMgm::extPath($_EXTKEY).'class.tx_smarty.php');

	// autoinclude the smarty pagination class
	// http://www.phpinsider.com/php/code/SmartyPaginate/
	require_once(t3lib_extMgm::extPath($_EXTKEY).'lib/SmartyPaginate.class.php');

	// XCLASS for smartyView (still references obsolete rtp_smarty)
	if(t3lib_extMgm::isLoaded('lib') && t3lib_extMgm::isLoaded('div')) {
		$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_smartyView.php'] = t3lib_extMgm::extPath($_EXTKEY).'lib/class.ux_tx_lib_smartyView.php';
		require_once(t3lib_extMgm::extPath('smarty').'lib/class.ux_tx_lib_smartyView.php');
	}

	// Hook for clearing smarty cache
	$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = t3lib_extMgm::extPath($_EXTKEY).'hook/class.tx_smarty_cache.php:&tx_smarty_cache->clearSmartyCache';

?>