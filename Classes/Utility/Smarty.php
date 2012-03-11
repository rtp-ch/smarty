<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2007 Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
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

/**
 * @copyright 	2007 Rueegg Tuck Partner GmbH
 * @author 		Simon Tuck <stu@rtpartner.ch>
 * @link 		http://www.rtpartner.ch/
 * @package 	Smarty (smarty)
 **/


class Tx_Smarty_Utility_Smarty
{
    /**
     * @static
     *
     * @param Smarty_Internal_Template $template
     * @param $pluginName
     * @throws Tx_Smarty_Exception_InvalidArgumentException
     * @throws Tx_Smarty_Exception_BadMethodCallException
     * @return void
     */
    public static function loadPlugin(Smarty_Internal_Template $template, $pluginName)
    {
        // Requires a valid instance of Smarty_Internal_Template
        if(!($template instanceof Smarty_Internal_Template)) {
            $message = 'Method "loadPlugin" requires a valid instance of Smarty_Internal_Template!';
            throw new Tx_Smarty_Exception_InvalidArgumentException($message, 1322296914);
        }

        // Uses Smarty::loadPlugin to load plugin, throws an exception if the plugin can't be found.
        if (!function_exists($pluginName)) {
            if (!$template->loadPlugin($pluginName)) {
                $message = 'Couldn\'t find and load smarty plugin "' . $pluginName . '"!';
                throw new Tx_Smarty_Exception_BadMethodCallException($message, 1322296921);
            }
        }
    }

    /**
     * @static
     * @param $setting
     * @return bool
     */
    public static function isPathSetting($setting)
    {
        return (self::isDirSetting($setting) || self::isFileSetting($setting) || self::isTemplateSetting($setting));
    }

    /**
     * @static
     * @param $setting
     * @return bool
     */
    public static function isDirSetting($setting)
    {
        return (boolean) (strtolower(substr($setting, -3)) === 'dir');
    }

    /**
     * @static
     * @param $setting
     * @return bool
     */
    public static function isFileSetting($setting)
    {
        return (boolean) (strtolower(substr($setting, -4)) === 'file');
    }

    /**
     * @static
     * @param $setting
     * @return bool
     */
    public static function isTemplateSetting($setting)
    {
        return (boolean) (strtolower(substr($setting, -8)) === 'template');
    }
}