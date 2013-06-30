<?php
namespace RTP\smarty;

use t3lib_div;
use Tx_Smarty_SysPlugins_ExtResource;
use Tx_Smarty_SysPlugins_PathResource;
use Tx_Smarty_Utility_Array;
use Tx_Smarty_Utility_Environment;
use Tx_Smarty_Utility_ExtConf;
use Tx_Smarty_Utility_TypoScript;

/**
 * Gets and configures a new instance of smarty.
 *
 * @example $smarty = \RTP\smarty\Factory::get(array('templates_dir' => 'path/to/templates'), 'lib.my_smarty_config');
 * => Returns an instance of smarty with templates in path/to/templates and settings applied from lib.my_smarty_config
 *
 * @example $smarty = \RTP\smarty\Factory::get('tx_myextension_pi1');
 * => Returns an instance of smarty with settings applied from plugin.tx_myextension_pi1.smarty
 *
 * Class Factory
 * @package RTP\smarty
 */
class Factory
{
    private static $pluginDirs = array(
        'EXT:smarty/Classes/SmartyPlugins/Common',
        'EXT:smarty/Classes/SmartyPlugins/Frontend',
        'EXT:smarty/Classes/SmartyPlugins/Backend'
    );

    /**
     * Creates, configures and returns an instance of smarty.
     *
     * @return object Tx_Smarty_Core_Wrapper
     */
    public static function get()
    {
        /**
         * [0.] Get the arguments passed to the factory. Arguments can be any a string which is used to fetch
         * configuration options form typoscript setup and any number of arrays which are interpreted as
         * configuration options, e.g. array(plugins_dir => my/plugins/dir, templates_dir => my/templates/dir)
         */
        list($options, $typoscriptKeys) = self::getArguments(func_get_args());

        /**
         * [1.] Initializes smarty and applies core settings
         */

        // Creates an instance of smarty
        $smartyInstance = t3lib_div::makeInstance('Tx_Smarty_Core_Wrapper');

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

        /**
         * [2.] Gets and merges the smarty configuration in reverse order of priority ("c" being the
         * lowest, "a" being the highest) from the following sources:
         *
         * [c] The global smarty TypoScript configuration
         * [b] TypoScript settings for the current extension key (if supplied)
         * [a] Configuration options passed directly to this builder
         */

        // [c] The global smarty configuration
        list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromTypo3('plugin.smarty');
        $setup = Tx_Smarty_Utility_Array::optionExplode($setup, array('plugins_dir'));

        // [b] The smarty configuration for the current extension key
        if (!Tx_Smarty_Utility_Array::notEmpty($typoscriptKeys)) {

            foreach ($typoscriptKeys as $typoscriptKey) {
                if (strpos($typoscriptKey, '.') !== false) {
                    $typoscript = 'plugin.' . $typoscriptKey . '.smarty';

                } else {
                    $typoscript = $typoscriptKey;
                }

                list($extensionSetup) = Tx_Smarty_Utility_TypoScript::getSetupFromTypo3($typoscript);
                $extensionSetup = Tx_Smarty_Utility_Array::optionExplode($extensionSetup, array('plugins_dir'));
                $setup = t3lib_div::array_merge_recursive_overrule((array) $setup, (array) $extensionSetup);
            }
        }

        // [a] Configuration options passed directly to this builder
        $setup = t3lib_div::array_merge_recursive_overrule((array) $setup, (array) $options);

        /**
         * [3.] Applies alternate development configuration settings to the configuration array
         * when a development context is available
         */

        // Applies any development settings
        if (isset($setup['development.'])
            && Tx_Smarty_Utility_Array::notEmpty($setup['development.'])
            && Tx_Smarty_Utility_Environment::hasDevelopmentMode()) {

            // Overrides standard configuration settings
            $developmentSetup = Tx_Smarty_Utility_Array::optionExplode($setup['development.'], array('plugins_dir'));
            $setup = t3lib_div::array_merge_recursive_overrule($setup, $developmentSetup);
        }

        // Unsets development properties
        if (isset($setup['development.'])) {
            unset($setup['development.']);
        }

        /**
         * [4.] Apply the configuration to the smarty instance and return it
         */

        foreach ($setup as $key => $value) {
            $smartyInstance->set($key, $value);
        }

        return $smartyInstance;
    }

    /**
     * @param array $arguments
     * @return array
     */
    private static function getArguments($arguments = array())
    {
        $typoscriptKeys = array();
        $options = array();

        while ($argument = array_shift($arguments)) {
            if (is_array($argument)) {
                foreach ($argument as $key => $value) {
                    $options[$key] = $value;
                }

            } elseif (is_string($argument)) {
                $typoscriptKeys[] = $argument;
            }
        }

        return array($options, $typoscriptKeys);
    }
}
