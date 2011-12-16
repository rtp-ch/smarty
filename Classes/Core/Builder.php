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

class Tx_Smarty_Core_Builder
{
    private static $pluginDirs = array(
        'EXT:smarty/Classes/SmartyPlugins/Filters',
        'EXT:smarty/Classes/SmartyPlugins/Frontend'
    );

    public function &Get(array $options = array())
    {
        // Creates an instance of smarty
        $smartyInstance = t3lib_div::makeInstance('Tx_Smarty_Core_Wrapper', $options);

        //
        $smartyInstance->addPluginsDir(self::$pluginDirs);

        // Cache and compile dirs in typo3temp
        $smartyInstance->setCacheDir('typo3temp/smarty_cache/');
        $smartyInstance->setCompileDir('typo3temp/smarty_compile/');

        // Register the TypoScript Filter which allows creating parameters using the
        // dot notation, e.g. {plugin filter.this.notation="bla"}
        $smartyInstance->registerFilter('pre', array('Tx_Smarty_SmartyPlugins_Core_DotNotationFilter', 'pre'));
        $smartyInstance->registerFilter('post', array('Tx_Smarty_SmartyPlugins_Core_DotNotationFilter', 'post'));

        // Registers "EXT" as a custom smarty resource so that template files can be
        // referenced as EXT:path/to/my/template.html
        $smartyInstance->registerResource('EXT', new Tx_Smarty_SmartyPlugins_Core_ExtResource());

        // Register "path" as a resource, mainly for backwards compatibility. Can retrieve a file
        // from the resource-list. @see t3lib_TStemplate::getFileName()
        $smartyInstance->registerResource('path', new Tx_Smarty_SmartyPlugins_Core_PathResource());

        // Registers a reference to the calling class. Apparently "$this" is
        // accessible when referenced statically in a non-static context...
        $pObj = is_object($this) ? $this : new stdClass();
        $smartyInstance->setParentObject($pObj);

        // Gets and parses the smarty configuration from TypoScript
        $setup = array();
        if(isset($smartyInstance->getParentObject()->prefixId)) {
            $prefixId = $smartyInstance->getParentObject()->prefixId;
            list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromTypo3('plugin.' . $prefixId . '.smarty');
        }
        $setup = t3lib_div::array_merge_recursive_overrule($setup, $options);
        $setup = Tx_Smarty_Utility_TypoScript::arrayStdWrap($setup);

        // Applies the smarty configuration to the instance
        foreach($setup as $key => $value) {
            $smartyInstance->set($key, $value);
        }

        return $smartyInstance;
    }
}
