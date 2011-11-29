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


abstract class Tx_Smarty_Facade_Configuration_AbstractManager
{
    /**
     * @var null|ReflectionClass
     */
    private $smartyClass            = null;

    /**
     * @var null|Tx_Smarty_Facade_Wrapper
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
     * @param Tx_Smarty_Facade_Wrapper $smartyInstance
     */
    public function __construct(Tx_Smarty_Facade_Wrapper $smartyInstance)
    {
        if($smartyInstance instanceof Tx_Smarty_Facade_Wrapper) {
            $this->smartyInstance = $smartyInstance;
            $this->smartyClass = new ReflectionClass($smartyInstance);
        } else {
            $message = 'Configuration manager requires a valid instance of smarty!';
            throw new Tx_Smarty_Exception_InvalidArgumentException($message, 1320785449);
        }
    }

    /**
     * Handles accessors (get, set, add)
     *
     * @magic
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
        if(!self::hasAction($action)) {
            $message = 'Unknown action "' . $action . '" in method "' . $method .'"!';
            throw new Tx_Smarty_Exception_BadMethodCallException($message, 1320785456);
        }

        // Catches adders without a corresponding method in smarty
        if(self::isAdder($action) && !$this->smartyClass->hasMethod($method)) {
            $message = 'Method "' . $method . '" is not a valid smarty setter!';
            throw new Tx_Smarty_Exception_BadMethodCallException($message, 1320785472);
        }

        // Gets the property from the method call (the first three characters of the
        // method are the action, the remaining characters the property) and formats
        // it correctly, i.e. "template_dir" is extracted from "getTemplateDir"
        $property = t3lib_div::camelCaseToLowerCaseUnderscored(substr($method, 3));

        // Catches unknown smarty properties
        if(!$this->smartyClass->hasProperty($property)) {
            throw new InvalidArgumentException('Unknown property "' . $property . '" in method "' . $method .'"!', 1320785462);
        }

        // Sets or adds smarty configuration setting
        if(self::isSetter($action) || self::isAdder($action)) {

            // Resolves directories or files to absolute paths
            if(!empty($args) && (self::isDir($args[0]) || self::isFile($args[0]))) {
                $args[0] = self::getPath($args[0]);
            }

            // Use smarty's setter or adder if available
            if($this->smartyClass->hasMethod($method)) {
                call_user_func(array($this->smartyInstance, $method), $args);

            // Set the smarty property directly
            } elseif($this->smartyClass->hasProperty($property)) {
                $this->smartyInstance->{$property} = $args[0];

            }

            // Return current Smarty instance for chaining
            return $this->smartyInstance;

        // Gets smarty configuration setting
        } else {

            // Use smarty's adder if available
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
        return (boolean) (self::isSetter($action) || self::isGetter($action) || self::isAdder($action));
    }

    /**
     * @static
     * @param $action
     * @return bool
     */
    private static function isGetter($action)
    {
        return (boolean) ((string) $action === self::GETTER_ACTION);
    }

    /**
     * @static
     * @param $action
     * @return bool
     */
    private static function isSetter($action)
    {
        return (boolean) ((string) $action === self::SETTER_ACTION);
    }
}