<?php

class Tx_Smarty_Service_Smarty
{
    /**
     * Loads a plugin (e.g. if it's functionality is needed by another plugin.)
     *
     * @param Smarty_Internal_Template $template
     * @param $pluginName
     * @throws Tx_Smarty_Exception_PluginException
     * @throws Tx_Smarty_Exception_CoreException
     * @see http://www.smarty.net/docs/en/plugins.writing.tpl
     */
    public static function loadPlugin(Smarty_Internal_Template $template, $pluginName)
    {
        if (!function_exists($pluginName)) {

            // Checks for a valid instance of Smarty_Internal_Template
            if (!($template instanceof Smarty_Internal_Template)) {
                $msg = 'Method "loadPlugin" requires a valid instance of Smarty_Internal_Template!';
                throw new Tx_Smarty_Exception_CoreException($msg, 1322296914);
            }

            $loaded = $template->smarty->loadPlugin($pluginName);
            if (!$loaded) {
                $msg = 'Couldn\'t find and load smarty plugin "' . $pluginName . '"!';
                throw new Tx_Smarty_Exception_CoreException($msg, 1322296921);
            }
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
        $isPathSetting = false;

        if (is_scalar($setting)) {
            $setting = strtolower(trim($setting));
            $isPathSetting = substr($setting, -4) === 'file'
                || substr($setting, -3) === 'dir'
                || substr($setting, -8) === 'template';
        }

        return $isPathSetting;
    }
}