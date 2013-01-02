<?php

class Tx_Smarty_Core_Builder
{
    private static $pluginDirs = array(
        'EXT:smarty/Classes/SmartyPlugins/Common',
        'EXT:smarty/Classes/SmartyPlugins/Frontend',
        'EXT:smarty/Classes/SmartyPlugins/Backend'
    );

    /**
     * Creates, configures and returns an instance of smarty.
     *
     * @param array $options
     * @param null $extensionKey
     * @return Tx_Smarty_Core_Wrapper
     */
    public static function get($options = array(), $extensionKey = null)
    {
        /**
         * Initializes the smarty instance and apply core settings
         * - Sets the
         * -
         */

        // Creates an instance of smarty
        $smartyInstance = t3lib_div::makeInstance('Tx_Smarty_Core_Wrapper');

        // Cache and compile dirs in typo3temp
        $smartyInstance->setCacheDir('typo3temp/smarty_cache/');
        $smartyInstance->setCompileDir('typo3temp/smarty_compile/');

        // Sets plugin dirs
        $smartyInstance->addPluginsDir(self::$pluginDirs);

        // Register the TypoScript Filter which allows creating parameters using the
        // dot notation, e.g. {plugin filter.this.notation="bla"}
        $smartyInstance->registerFilter('pre', array('Tx_Smarty_SysPlugins_DotNotationFilter', 'pre'));
        $smartyInstance->registerFilter('post', array('Tx_Smarty_SysPlugins_DotNotationFilter', 'post'));

        // Registers "EXT" as a custom smarty resource so that template files can be
        // referenced as EXT:path/to/my/template.html
        $smartyInstance->registerResource('EXT', new Tx_Smarty_SysPlugins_ExtResource());

        // Register "path" as a resource, mainly for backwards compatibility. Can retrieve a file
        // from the resource-list. @see t3lib_TStemplate::getFileName()
        $smartyInstance->registerResource('path', new Tx_Smarty_SysPlugins_PathResource());

        // Gets and merges the smarty configuration in order of priority from the following sources:
        // [A] Configuration options passed directly to this builder
        // [B] TypoScript settings for the current extension key (if supplied)
        // [C] The global smarty TypoScript configuration

        // [C] The global smarty configuration
        list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromTypo3('plugin.smarty');

        // [B] The smarty configuration for the current extension key
        if (!is_null($extensionKey)) {
            $typoscriptString = 'plugin.' . $extensionKey . '.smarty';
            list($extensionSetup) = Tx_Smarty_Utility_TypoScript::getSetupFromTypo3($typoscriptString);
            $setup = t3lib_div::array_merge_recursive_overrule((array) $setup, (array) $extensionSetup);
        }

        // [A] Configuration options passed directly to this builder
        $setup = t3lib_div::array_merge_recursive_overrule((array) $setup, (array) $options);

        if (self::hasDevelopmentMode()
            && isset($setup['development.'])
            && Tx_Smarty_Utility_Array::notEmpty($setup['development.'])) {

            $setup = t3lib_div::array_merge_recursive_overrule($setup, $setup['development.']);
        }

        // Checks if caching has been disabled in the system wide configuration and globally disables it if so.
        if ((boolean) Tx_Smarty_Utility_ExtConf::getExtConfValue('disable_caching')) {
            $setup['caching'] = false;
        }

        if ($GLOBALS['TSFE']->no_cache) {
            // TODO: respect no cache?
        }

        // Unset
        unset($setup['development.']);

        // Configures the smarty instance with the final configuration array
        foreach ($setup as $key => $value) {
            $smartyInstance->set($key, $value);
        }

        return $smartyInstance;
    }

    private static function hasDevelopmentMode()
    {
        if ((boolean) Tx_Smarty_Utility_ExtConf::getExtConfValue('enable_development_mode')) {
            return true;
        }

        $devEnvDefnitions = trim(Tx_Smarty_Utility_ExtConf::getExtConfValue('development_environment_definitions'));
        if ($devEnvDefnitions && Tx_Smarty_Utility_Environment::anyValid($devEnvDefnitions)) {
            return true;
        }

        return false;
    }
}
