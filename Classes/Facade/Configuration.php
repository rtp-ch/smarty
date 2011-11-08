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


class Tx_Smarty_Facade_Configuration
{

    /**
     * @var null
     */
    private $smartyClass            = null;

    /**
     * @var null
     */
    private $smartyInstance        = null;

    /**
     * @var array
     */
    private static $getters         = array('get');

    /**
     * @var array
     */
    private static $setters         = array('set', 'add');

    /**
     * @param Tx_Smarty_Facade_Wrapper $smartyInstance
     */
    public function __construct(Tx_Smarty_Facade_Wrapper $smartyInstance)
    {
        if($smartyInstance instanceof Tx_Smarty_Facade_Wrapper) {
            $this->smartyInstance = $smartyInstance;
            $this->smartyClass = new ReflectionClass($smartyInstance);
        } else {
            throw new InvalidArgumentException('Configuration manager requires a valid instance of smarty!', 1320597938);
        }

    }

    /**
     * @throws BadMethodCallException|InvalidArgumentException
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public final function __call($method, array $args)
    {
        // Gets the action from the method call and throws
        // an exception for any unrecognized actions.
        $action = self::getActionFromMethod($method);
        if(!$this->hasAction($action)) {
            throw new BadMethodCallException('Unknown action "' . $action . '" in method "' . $method .'"!', 1320595094);
        }

        // Gets the property from the method call and formats
        // it correctly, i.e. templateDir --> template_dir
        // Throws an exception if the smarty class doesn't have
        // a corresponding property.
        $property = self::formatPropertyName(self::getPropertyFromMethod($method));
        if(!$this->smartyClass->hasMethod($method) && $this->smartyClass->hasProperty($property)) {
            throw new InvalidArgumentException('Unknown property "' . $property . '" in method "' . $method .'"!', 1320600186);
        }

        if(self::isSetter($action)) {

            // Resolves directories or files to absolute paths
            if(!empty($args) && self::isPath($args[0])) {
                $args[0] = self::getPath($args[0]);
            }
            
            // Use smarty's setter if available
            if($this->smartyClass->hasMethod($method)) {
                call_user_func(array($this->smartyInstance, $method), $args);

            // Set the smarty property directly
            } else {
                $this->smartyInstance->{$property} = $args[0];
                
            }
        } else {

            // Use smarty's getter if available
            if($this->smartyClass->hasMethod($method)) {
                return call_user_func(array($this->smartyInstance, $method));

            // Get the smarty property directly
            } elseif($this->smartyClass->hasProperty($property)) {
                return $this->smartyInstance->{$property};

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
     * @param $dirs
     * @return array
     */
    private static function getPath($dirs)
    {
        $paths = $dirs;
        if(is_array($dirs)) {
            while($dir = array_shift($dirs)) {
                $path = t3lib_div::getFileAbsFileName($dir);
                $paths[] = (is_dir($path) && substr($path, -1) !== DS) ? $path . DS : $path;
            }
        } elseif(is_scalar($dirs)) {
            $paths  = t3lib_div::getFileAbsFileName($dirs);
            $paths .= (is_dir($paths) && substr($paths, -1) !== DS) ? DS : '';
        }
        return $paths;
    }

    /**
     * @static
     * @throws BadMethodCallException
     * @param $method
     * @return string
     */
    private static function getPropertyFromMethod($method)
    {
        return substr($method, 4, strlen($method) - 3);
    }

    /**
     * @static
     * @param $property
     * @return string
     */
    private static function formatPropertyName($property)
    {
        return strtolower(preg_replace('/([A-Z])/', '_\1', $property));
    }
}