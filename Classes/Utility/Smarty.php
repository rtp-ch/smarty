<?php

class Tx_Smarty_Utility_Smarty
{
    /**
     * @param Smarty_Internal_Template $template
     * @param $pluginName
     * @throws Tx_Smarty_Exception_PluginException
     * @throws Tx_Smarty_Exception_CoreException
     */
    public static function loadPlugin(Smarty_Internal_Template $template, $pluginName)
    {
        // Checks for a valid instance of Smarty_Internal_Template
        if (!($template instanceof Smarty_Internal_Template)) {
            $msg = 'Method "loadPlugin" requires a valid instance of Smarty_Internal_Template!';
            throw new Tx_Smarty_Exception_CoreException($msg, 1322296914);
        }

        // Attempts to load the function corresponding to the plugin,
        // throws an exception if the plugin can't be found.
        if (!function_exists($pluginName) && !$template->loadPlugin($pluginName)) {
            $msg = 'Couldn\'t find and load smarty plugin "' . $pluginName . '"!';
            throw new Tx_Smarty_Exception_CoreException($msg, 1322296921);
        }
    }

    /**
     * Checks if a given smarty setting/property is a path. Typically this is when the
     * name of the parameter ends in "dir", "file" or "template".
     *
     * @param $setting
     * @return bool
     */
    public static function isPathSetting($setting)
    {
        $setting = strtolower($setting);
        return substr($setting, -4) === 'file'
            || substr($setting, -3) === 'dir'
            || substr($setting, -8) === 'template';
    }
}