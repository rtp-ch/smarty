<?php

class Tx_Smarty_Utility_TypoScript
{

    /**
     * Returns TypoScript Setup array for a given extension from current Environment. Returns the
     * global TypoScript setup array if $extensionName is undefined
     *
     * @param null $extensionName
     * @return array the raw TypoScript setup
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    public static function getTypoScriptSetup($extensionName = null)
    {
        $setup = array();

        if (!is_null($extensionName)) {
            $key = 'tx_' . strtolower($extensionName) . '.';
            if (isset($GLOBALS['TSFE']->tmpl->setup['plugin.'][$key])) {
                $setup = $GLOBALS['TSFE']->tmpl->setup['plugin.'][$key];
            }

        } else {
            $setup = $GLOBALS['TSFE']->tmpl->setup;
        }

        return $setup;
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getSetupFromParameters(array $parameters = array())
    {
        $setup = array();
        $type  = null;

        // "setup" is a special parameter which can point to a value in the
        // current global TypoScript scope. Retrieves the matching value from
        // the current global TypoScript scope if "setup" is defined.
        if (isset($parameters['setup'])) {
            list($setup, $type) = self::getSetupFromTypo3($parameters['setup']);
            unset($parameters['setup']);
        }

        // Converts the remaining parameters to a TypoScript array.
        if (!empty($parameters)) {

            // Parameters will recursively override any setup from the "setup" parameter.
            if (!empty($setup)) {
                $tmpSetup = Tx_Smarty_Utility_TypoScript::getTypoScriptFromParameters($parameters);
                $setup = Tx_Smarty_Service_Compatibility::arrayMergeRecursiveOverrule($setup, $tmpSetup);

            } else {
                $setup = Tx_Smarty_Utility_TypoScript::getTypoScriptFromParameters($parameters);
            }
        }

        return array($setup, $type);
    }

    /**
     *
     * Gets TypoScript from the current global TypoScript setup array
     *
     * @see t3lib_TSparser::getVal($string, $setup)
     * @param string $string Object path for which to get the value
     * @throws Exception
     * @return array
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    public static function getSetupFromTypo3($string)
    {

        // Cast the object path to a string
        $objPath = trim((string) $string);

        // Break the object path down by periods (.) excluding the last part
        // which could also point to the object type. So that, for example, if
        // the typoscript path is "lib.foo.bar" both the OBJECT_TYPE and it's
        // configuration are picked up:
        // lib.foo.bar = OBJECT_TYPE
        // lib.foo.bar.file = /path/to/file
        $objPathParts = Tx_Smarty_Utility_Array::trimExplode($objPath, '.');
        $lastObjPathPart = array_pop($objPathParts);

        // The current global TypoScript setup array
        // @TODO: What happens when setup is unavailable
        $setup = $GLOBALS['TSFE']->tmpl->setup;

        // Iterate through the global TypoScript scope
        while ($objPathPart = array_shift($objPathParts)) {
            if (isset($setup[$objPathPart . '.'])) {
                $setup = $setup[$objPathPart . '.'];

            } else {
                // Exit if no configuration is available
                return array(array(), null);
            }
        }

        // Get the type from the last part of the object path if available
        if (isset($setup[$lastObjPathPart])) {
            $type = $setup[$lastObjPathPart];

        } else {
            $type = null;
        }

        // The last part of the object path should get the configuration
        if (isset($setup[$lastObjPathPart . '.'])) {
            $setup = $setup[$lastObjPathPart . '.'];

        } else {
            // Exit if no configuration is available
            return array(array(), null);
        }

        // Return the object configuration and type
        return array($setup, $type);
    }

    /**
     * @param array $parameters
     * @return array
     */
    private static function getTypoScriptFromParameters(array $parameters = array())
    {
        $typoscript = array();

        foreach ($parameters as $parameter => $value) {
            $properties = Tx_Smarty_Utility_Array::trimExplode($parameter, '.');
            $setting    = self::convertParameterToTypoScript($value, $properties);
            $typoscript = Tx_Smarty_Service_Compatibility::arrayMergeRecursiveOverrule($typoscript, $setting);
        }

        return $typoscript;
    }

    /**
     * @param $value
     * @param array $settings
     * @param array $setting
     * @return array
     */
    private static function convertParameterToTypoScript($value, array $settings = array(), array $setting = array())
    {
        $property = array_shift($settings);

        if (count($settings) > 0) {
            $setting[$property . '.'] = self::convertParameterToTypoScript($value, $settings, $setting);

        } else {
            $setting[$property] = $value;
        }

        return $setting;
    }
}
