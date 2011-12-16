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
        'tx_smarty_core_configuration'      => $classPath  . 'Core'  . DS . 'Configuration.php',
        'tx_smarty_core_wrapper'            => $classPath  . 'Core'  . DS . 'Wrapper.php',
        'tx_smarty_core_builder'            => $classPath  . 'Core'  . DS . 'Builder.php',
        'tx_smarty_core_cobjectproxy'       => $classPath  . 'Core'  . DS . 'CobjectProxy.php',
        'tx_smarty'                         => $classPath  . 'Backport'  . DS . 'class.tx_smarty.php',
        'tx_smarty_exception_exception'     => $classPath  . 'Exception'  . DS . 'Exception.php',
        'tx_smarty_exception_badmethodcallexception' => $classPath  . 'Exception'  . DS . 'BadMethodCallException.php',
        'tx_smarty_exception_invalidargumentexception' => $classPath  . 'Exception'  . DS . 'InvalidArgumentException.php',
        'tx_smarty_exception_domainexception' => $classPath  . 'Exception'  . DS . 'DomainException.php',
        'tx_smarty_exception_unexpectedvalueexception' => $classPath  . 'Exception'  . DS . 'UnexpectedValueException.php',
        'tx_smarty_utility_typoscript'      => $classPath  . 'Utility' . DS . 'TypoScript.php',
        'tx_smarty_utility_array'           => $classPath  . 'Utility' . DS . 'Array.php',
        'tx_smarty_utility_typo3'           => $classPath  . 'Utility' . DS . 'Typo3.php',
        'tx_smarty_utility_smarty'          => $classPath  . 'Utility' . DS . 'Smarty.php',
        'tx_smarty_utility_path'            => $classPath  . 'Utility' . DS . 'Path.php',
        'tx_smarty_utility_scalar'          => $classPath  . 'Utility' . DS . 'Scalar.php',
        'tx_smarty_smartyplugins_core_dotnotationfilter' => $classPath  . 'SmartyPlugins' . DS . 'Core' . DS . 'DotNotationFilter.php',
        'tx_smarty_smartyplugins_core_extresource'       => $classPath  . 'SmartyPlugins' . DS . 'Core' . DS . 'ExtResource.php',
        'tx_smarty_smartyplugins_core_pathresource'      => $classPath  . 'SmartyPlugins' . DS . 'Core' . DS . 'PathResource.php',
        'ux_html2text'                      => $vendorPath . DS . 'Html2Text' . DS . 'class.ux_html2text.php',
        'html2text'                         => $vendorPath . DS . 'Html2Text' . DS . 'class.html2text.php',
        'krumo'                             => $vendorPath . DS . 'Krumo' . DS . 'class.krumo.php',
    );




