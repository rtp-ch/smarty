<?php

	if(!defined ('TYPO3_MODE')) die ('Access denied.');

    // Defines shorthand directory separator constant
    if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

    // Sets some relevant paths
    $extPath    = t3lib_extMgm::extPath(dirname(__FILE__)) . DS;
    $classPath  = $extPath . 'Classes' . DS;
    $vendorPath = $extPath . 'Vendor' . DS;
    $smartyPath = $vendorPath . 'Smarty' . DS;

    // Sets SMARTY_DIR to absolute path to Smarty library files.
    if (!defined('SMARTY_DIR')) define('SMARTY_DIR', $smartyPath);

    // List of autoload classes
    return array(
        'Smarty' => $vendorPath . 'Smarty.class.php',
    );
