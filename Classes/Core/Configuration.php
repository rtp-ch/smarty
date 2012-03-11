<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006-2007 Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
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
 * @copyright     2011 Rueegg Tuck Partner GmbH
 * @author         Simon Tuck <stu@rtp.ch>
 * @link         http://www.rtpartner.ch/
 * @package     Smarty (smarty)
 **/


class Tx_Smarty_Core_Configuration
{
    /**
     * @var null|ReflectionClass
     */
    private $smartyClass            = null;

    /**
     * @var null|Tx_Smarty_Core_Wrapper
     */
    private $smartyInstance         = null;

    /**
     * @var string
     */
    const GETTER_ACTION             = 'get';

    /**
     * @var string
     */
    const SETTER_ACTION             = 'set';

    /**
     * @var string
     */
    const ADDER_ACTION              = 'add';

    /**
     * @param Tx_Smarty_Core_Wrapper $smartyInstance
     * @throws Tx_Smarty_Exception_InvalidArgumentException
     */
    public function __construct(Tx_Smarty_Core_Wrapper $smartyInstance)
    {
        if($smartyInstance instanceof Tx_Smarty_Core_Wrapper) {
            $this->smartyInstance = $smartyInstance;
            $this->smartyClass = new ReflectionClass($smartyInstance);
        } else {
            $message = 'Configuration manager requires a valid instance of smarty!';
            throw new Tx_Smarty_Exception_InvalidArgumentException($message, 1320785449);
        }
    }

    /**
     * Manages smarty configuration settings by handling accessors (get, set and add). Adders are limited to
     * corresponding smarty methods (i.e. there are a limited number of adders), but setter/getters can be used for all
     * smarty properties. For example, $smarty->setCacheLifetime(12000) is equivalent to $smarty->cache_lifetime = 12000,
     * similarly $smarty->getCacheLifetime() will return $smarty->cache_lifetime. In the same vein the methods
     * $smarty->set('cache_lifetime', 12000) and $smarty->get('cache_lifetime') can be used to set/get smarty properties.
     *
     * @magic
     *
     * @param string $method
     * @param array $args
     * @throws Tx_Smarty_Exception_BadMethodCallException
     * @throws InvalidArgumentException
     * @return mixed
     */
    public final function __call($method, array $args = array())
    {
        // Gets the accessor from the method name and throws an execption
        // if the method call is not a valid accessor.
        $action = self::getActionFromMethod($method);
        if(!self::hasAction($action)) {
            $message = 'Unknown action "' . $action . '" in method "' . $method .'"!';
            throw new Tx_Smarty_Exception_BadMethodCallException($message, 1320785456);
        }

        // Gets the property from the method call (the first three characters of the
        // method are the action, the remaining characters the property) and formats
        // it correctly, i.e. "template_dir" is extracted from "getTemplateDir"
        if(strlen($method) > 3) {
            $property = t3lib_div::camelCaseToLowerCaseUnderscored(substr($method, 3));

        // Alternatively if the method is just the accessor, e.g. set('template_dir', 'some/path')
        // then the property is the first argument. And the method is constructed from the action
        // and the property.
        } else {
            $property = array_shift($args);
            $method = $action . t3lib_div::underscoredToUpperCamelCase($property);
        }

        // Catches unknown smarty properties
        if(!$this->smartyClass->hasProperty($property) && !$this->smartyClass->hasMethod($method)) {
            throw new InvalidArgumentException('Unknown property "' . $property . '" in method "' . $method .'"!', 1320785462);
        }

        // Catches adders without a corresponding method in smarty.
        if(self::isAdder($action) && !$this->smartyClass->hasMethod($method)) {
            $message = 'Method "' . $method . '" is not a valid smarty setter!';
            throw new Tx_Smarty_Exception_BadMethodCallException($message, 1320785472);
        }

        // Sepcial case: never overwrite plugins_dir!
        if ($property === 'plugins_dir') {
            $action = 'add';
            $method = $action . t3lib_div::underscoredToUpperCamelCase($property);
        }

        // Sets or adds smarty configuration setting
        if(self::isSetter($action) || self::isAdder($action)) {

            // Resolves directories or files to absolute paths
            if(!empty($args) && (Tx_Smarty_Utility_Smarty::isPathSetting($args[0]))) {
                $args[0] = Tx_Smarty_Utility_Path::resolvePaths($args[0]);
            }

            // Use smarty's setter or adder if available
            if($this->smartyClass->hasMethod($method)) {
                call_user_func(array($this->smartyInstance, $method), $args[0]);

            // Set the smarty property directly
            } else {
                $this->smartyInstance->{$property} = $args[0];

            }

            // Return current Smarty instance for chaining
            return $this->smartyInstance;

        // Gets smarty configuration setting
        } else {

            // Use smarty's getter if available
            if($this->smartyClass->hasMethod($method)) {
                return call_user_func(array($this->smartyInstance, $method));

            // Get the smarty property directly
            } else {
                return $this->smartyInstance->{$property};

            }
        }
    }

    /**
     * Determines the kind of accessor from the method name, e.g. addTemplateDir is
     * an adder, setCacheDir is a setter etc.
     *
     * @param $method
     * @return string
     */
    private static function getActionFromMethod($method)
    {
        return strtolower(substr($method, 0, 3));
    }

    /**
     * Checks if the method is a valid accessor
     *
     * @param $action
     * @return bool
     */
    private static function hasAction($action)
    {
        return (boolean) (self::isSetter($action) || self::isGetter($action) || self::isAdder($action));
    }

    /**
     * Checks if the method is a getter
     *
     * @param $action
     * @return bool
     */
    private static function isGetter($action)
    {
        return (boolean) ((string) $action === self::GETTER_ACTION);
    }

    /**
     * Checks if the method is a setter
     *
     * @param $action
     * @return bool
     */
    private static function isSetter($action)
    {
        return (boolean) ((string) $action === self::SETTER_ACTION);
    }

    /**
     * Checks if the method is a adder
     *
     * @param $action
     * @return bool
     */
    private static function isAdder($action)
    {
        return (boolean) ((string) $action === self::ADDER_ACTION);
    }
}