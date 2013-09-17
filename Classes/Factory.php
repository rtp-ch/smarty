<?php
namespace RTP\smarty;

use Tx_Smarty_Service_Compatibility;
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
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    public static function get()
    {
        // Creates an instance of smarty
        $smartyInstance = self::initializeWithDefaults();

        // Get and evaluate the passed arguments
        list($options, $typoscriptKeys) = self::getArguments(func_get_args());

        // Get and evaluate the smarty configuration
        $setup = self::getConfiguration($options, $typoscriptKeys);

        // Applies alternate development settings to the configuration when a development context is available
        if (isset($setup['development.'])
            && Tx_Smarty_Utility_Array::notEmpty($setup['development.'])
            && Tx_Smarty_Utility_Environment::hasDevelopmentMode()) {

            // Overrides standard configuration settings
            $developmentSetup = Tx_Smarty_Utility_Array::optionExplode($setup['development.'], array('plugins_dir'));
            $setup = Tx_Smarty_Service_Compatibility::arrayMergeRecursiveOverrule($setup, $developmentSetup);
        }

        // Unsets development properties
        if (isset($setup['development.'])) {
            unset($setup['development.']);
        }

        // Apply the merged configuration options to the smarty instance
        foreach ($setup as $key => $value) {
            $smartyInstance->set($key, $value);
        }

        // Makes the typoscript array accessible from within smarty templates
        // TODO: A better (more robust) way to handle this
        if (isset($GLOBALS['TSFE']->tmpl->setup)) {
            $smartyInstance->assign('typoscript', $GLOBALS['TSFE']->tmpl->setup);
        }

        // Return the configured smarty instance
        return $smartyInstance;
    }

    /**
     * 3. Configuration
     * ================
     *
     * Gets and merges the smarty configuration in reverse order of priority ("c" being the
     * lowest, "a" being the highest) from the following sources:
     *
     * [c] The global smarty TypoScript configuration
     * [b] TypoScript settings for the current extension key (e.g. "lib.my_smarty_config")
     * [a] Configuration options passed directly to the factory
     *
     * @param array $options
     * @param array $typoscriptKeys
     * @return array
     */
    private static function getConfiguration($options = array(), $typoscriptKeys = array())
    {
        // protects plugins_dir in options and converts it into an array
        $options = Tx_Smarty_Utility_Array::optionExplode($options, array('plugins_dir'));

        // First, Get any global smarty configuration options
        list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromTypo3('plugin.smarty');

        // protects plugins_dir in global settings and converts it into an array
        $setup = Tx_Smarty_Utility_Array::optionExplode($setup, array('plugins_dir'));

        // Second, apply the smarty configuration for any given typoscript keys
        if (!Tx_Smarty_Utility_Array::notEmpty($typoscriptKeys)) {

            foreach ($typoscriptKeys as $typoscriptKey) {
                if (strpos($typoscriptKey, '.') !== false) {
                    $typoscript = 'plugin.' . $typoscriptKey . '.smarty';

                } else {
                    $typoscript = $typoscriptKey;
                }

                list($extensionSetup) = Tx_Smarty_Utility_TypoScript::getSetupFromTypo3($typoscript);
                $extensionSetup = Tx_Smarty_Utility_Array::optionExplode($extensionSetup, array('plugins_dir'));
                $pluginsDir = array_merge((array) $setup['plugins_dir'], (array) $extensionSetup['plugins_dir']);
                $setup = Tx_Smarty_Service_Compatibility::arrayMergeRecursiveOverrule(
                    (array) $setup,
                    (array) $extensionSetup
                );
                $setup['plugins_dir'] = $pluginsDir;
            }
        }

        // Lastly, merge in any configuration options passed directly to the factory taking care not to override any
        // configured plugin_dirs
        $pluginsDir = array_merge((array) $setup['plugins_dir'], (array) $options['plugins_dir']);
        $setup = Tx_Smarty_Service_Compatibility::arrayMergeRecursiveOverrule((array) $setup, (array) $options, false);
        $setup['plugins_dir'] = $pluginsDir;

        return $setup;
    }

    /**
     * Initializes smarty and applies core settings:
     * - Default plugin dirs
     * - Required system filters (pre & post dot notation filter)
     * - Custom resources for TYPO3 (EXT and getData:path)
     *
     * @return object Tx_Smarty_Core_Wrapper
     */
    private static function initializeWithDefaults()
    {
        // Creates an instance of smarty
        $smartyInstance = Tx_Smarty_Service_Compatibility::makeInstance('Tx_Smarty_Core_Wrapper');

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

        return $smartyInstance;
    }

    /**
     * Evaluate the arguments passed to the factory. Arguments can be any a string which is used to fetch
     * configuration options from typoscript setup (e.g. lib.my_smarty_settings) and any number of arrays
     * which will be interpreted as configuration options, e.g. array(plugins_dir => my/plugins/dir,
     * templates_dir => my/templates/dir)
     *
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
