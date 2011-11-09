<?php

	if(!defined ('TYPO3_MODE')) die ('Access denied.');

    // Defines shorthand directory separator constant
    if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

    // Sets some relevant paths
    $extPath     = t3lib_extMgm::extPath('smarty');
    $extPath    .= (substr($extPath, -1) === DS) ? '' : DS;
    $classPath   = $extPath . 'Classes' . DS;
    $vendorPath  = $extPath . 'Vendor' . DS;
    $smartyPath  = $vendorPath . 'Smarty' . DS;

    // Sets SMARTY_DIR to absolute path of smarty library files.
    if (!defined('SMARTY_DIR')) define('SMARTY_DIR', $smartyPath);

    //require_once $smartyPath . 'SmartyBC.class.php';

    // List of autoload classes
    return array(
        //'smarty'                            => $smartyPath . 'Smarty.class.php',
        'smartybc'                          => $smartyPath . 'SmartyBC.class.php',
        'tx_smarty_facade_configuration'    => $classPath  . 'Facade'  . DS . 'Configuration.php',
        'tx_smarty_facade_wrapper'          => $classPath  . 'Facade'  . DS . 'Wrapper.php',
        'tx_smarty_facade_Factory'          => $classPath  . 'Facade'  . DS . 'Factory.php',
        'tx_smarty_utility_typoscript'      => $classPath  . 'Utility' . DS . 'Factory.php',
    );




