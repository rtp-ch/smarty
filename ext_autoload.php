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

    // List of autoload classes
    return array(
        'smartybc'                          => $smartyPath . 'SmartyBC.class.php',
        'tx_smarty_facade_configuration'    => $classPath  . 'Facade'  . DS . 'Configuration.php',
        'tx_smarty_facade_wrapper'          => $classPath  . 'Facade'  . DS . 'Wrapper.php',
        'tx_smarty_facade_builder'          => $classPath  . 'Facade'  . DS . 'Builder.php',
        'tx_smarty_exception_exception'     => $classPath  . 'Exception'  . DS . 'Exception.php',
        'tx_smarty_exception_badmethodcallexception' => $classPath  . 'Exception'  . DS . 'BadMethodCallException.php',
        'tx_smarty_exception_invalidargumentexception' => $classPath  . 'Exception'  . DS . 'InvalidArgumentException.php',
        'tx_smarty_exception_domainexception' => $classPath  . 'Exception'  . DS . 'DomainException.php',
        'tx_smarty_exception_unexpectedvalueexception' => $classPath  . 'Exception'  . DS . 'UnexpectedValueException.php',
        'tx_smarty_utility_typoscript'      => $classPath  . 'Utility' . DS . 'TypoScript.php',
        'tx_smarty_utility_array'           => $classPath  . 'Utility' . DS . 'Array.php',
        'tx_smarty_utility_typo3'           => $classPath  . 'Utility' . DS . 'Typo3.php',
        'tx_smarty_utility_smarty'          => $classPath  . 'Utility' . DS . 'Smarty.php',
        't3lib_tsparser'                    => PATH_t3lib  . 'class.t3lib_tsparser.php',
        'tx_smarty_filters_dotnotation'     => $classPath  . 'Filters' . DS . 'DotNotation.php',
    );




