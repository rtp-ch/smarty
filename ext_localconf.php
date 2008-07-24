<?php

	if (!defined ('TYPO3_MODE')) die ('Access denied.');

	// Get default vars from extension configuration
	$_EXTCONF = unserialize($_EXTCONF);

	// Set global extension configuration vars
	$TYPO3_CONF_VARS['EXTCONF'][$_EXTKEY]['smarty_dir'] = preg_replace('%[\\\\|/]$%m', '', $_EXTCONF['smarty_dir']).'/';
	$TYPO3_CONF_VARS['EXTCONF'][$_EXTKEY]['template_dir'] = t3lib_div::getFileAbsFileName(preg_replace('%[\\\\|/]$%m', '', $_EXTCONF['template_dir']));
	
	// XCLASS for smartyView (still references obsolete rtp_smarty)
	$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_smartyView.php'] = t3lib_extMgm::extPath($_EXTKEY).'lib/class.ux_tx_lib_smartyView.php';
	
	// autoinclude the main extension class
	require_once(t3lib_extMgm::extPath($_EXTKEY).'class.tx_smarty.php');

?>