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
 * @copyright 	2011 Rueegg Tuck Partner GmbH
 * @author 		Simon Tuck <stu@rtp.ch>
 * @link 		http://www.rtpartner.ch/
 * @package 	Smarty (smarty)
 **/


class Tx_Smarty_Wrapper_Configuration
{

    /**
     * @var null
     */
    private $reflection             = null;

    /**
     * @var array
     */
    private static $getters         = array('get');

    /**
     * @var array
     */
    private static $setters         = array('set', 'add');

    /**
     * @api
     * @throws InvalidArgumentException
     * @param $method
     * @param $args
     * @return mixed
     */
    public final function __call($method, $args)
    {
        // Gets the action from the method call an throws
        // an exception for any unrecognized action.
        $action     = self::getActionFromMethod($method);
        if(!$this->hasAction($action)) {
            throw new BadMethodCallException('Unknown action "' . $action . '" in method "' . $method .'"!', 1320595094);
        }

        // Gets the current smarty instance from the arguments
        // and throws an exception if no smarty instance can be retrieved
        $smarty     = self::getSmartyFromArguments($args); // TODO: Static or not?
        $reflection = $this->getReflection($smarty);

        // Gets the property from the method call and formats
        // it correctly, i.e. templateDir --> template_dir
        $property   = self::getPropertyFromMethod($method);
        $property   = self::getPropertyName($property);


        if(self::isSetter($action)) {

            // Gets the value that will be set, if it's
            // a directory resolve the path
            $value = self::getValueFromArguments($args);
            if(!empty($value) && self::isPath($value)) {
                $value = self::getPath($value);
            }

            // Use smarty's setter if available
            if($reflection->hasMethod($method)) {
                call_user_func(array($smarty, $method), array($value));

            // Set the smarty property directly
            } elseif($reflection->hasProperty($property)) {
                $smarty->{$property} = $value;

            // Throws an exception when trying to set an unknown property
            } else {
                throw new InvalidArgumentException('Setter called for unknown property "' . $property . '"!', 1320600186);
            }

        } else {

            // Use smarty's getter if available
            if($reflection->hasMethod($method)) {
                return call_user_func(array($smarty, $method));

            // Set the smarty property directly
            } elseif($reflection->hasProperty($property)) {
                return $smarty->{$property};

            // Throws an exception when trying to get an unknown property
            } else {
                throw new InvalidArgumentException('Getter called for unknown property "' . $property . '"!', 1320600271);
            }
        }
    }

    /**
     * @static
     * @param $method
     * @return string
     */
    private static function getActionFromMethod($method)
    {
        return strtolower(substr($method, 0, 3));
    }

    /**
     * @static
     * @param $action
     * @return bool
     */
    private static function hasAction($action)
    {
        return (boolean) (self::isSetter($action) || self::isGetter($action));
    }

    /**
     * @static
     * @param $action
     * @return bool
     */
    private static function isGetter($action)
    {
        return (boolean) (in_array($action, self::$getters));
    }

    /**
     * @static
     * @param $action
     * @return bool
     */
    private static function isSetter($action)
    {
        return (boolean) (in_array($action, self::$setters));
    }

    /**
     * @static
     * @param $setting
     * @return bool
     */
    private static function isPath($setting)
    {
        return (boolean) (strtolower(substr($setting, -3)) === 'dir');
    }

    /**
     * @static
     * @param $setting
     * @return string
     */
    private static function getPath($setting)
    {
        $path = t3lib_div::getFileAbsFileName($setting);
        if(is_dir($path) && substr($path, -1) !== DIRECTORY_SEPARATOR) {
            $path .= DIRECTORY_SEPARATOR;
        }
        return $path;
    }

    /**
     * @static
     * @throws InvalidArgumentException
     * @param $args
     * @return Tx_Smarty_Wrapper_Wrapper
     */
    private static function getSmartyFromArguments($args)
    {
        $smarty = array_shift($args);
        if($smarty instanceof Tx_Smarty_Wrapper_Wrapper) {
            return $smarty;
        } else {
            throw new InvalidArgumentException('No valid smarty instance found in method call!', 1320597938);
        }
    }

    /**
     * @static
     * @param $args
     * @return array
     */
    private static function getValueFromArguments($args)
    {
        return array_slice($args, 2, 1);
    }

    /**
     * @static
     * @throws BadMethodCallException
     * @param $method
     * @return string
     */
    private static function getPropertyFromMethod($method)
    {
        $property = substr($method, 4, strlen($method) - 3);
        if($property) {
            return $property;
        } else {
            throw new BadMethodCallException('No property available in method "' . $method .'"!', 1320595479);
        }
    }

    /**
     * @static
     * @param $property
     * @return string
     */
    private static function getPropertyName($property)
    {
        return strtolower(preg_replace('/([A-Z])/', '_\1', $property));
    }

    /**
     * @param $class
     * @return ReflectionClass
     */
    private function getReflection($class)
    {
        if(is_null($this->reflection)) {
            $this->reflection = new ReflectionClass($class);
        }
        return $this->reflection;
    }
}