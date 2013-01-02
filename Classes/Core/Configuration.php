<?php

class Tx_Smarty_Core_Configuration
{
    /**
     * @var null|ReflectionClass
     */
    private $smartyClass;

    /**
     * @var null|Tx_Smarty_Core_Wrapper
     */
    private $smartyInstance;

    /**
     * @var string
     */
    const GETTER_PREFIX = 'get';

    /**
     * @var string
     */
    const SETTER_PREFIX = 'set';

    /**
     * @var string
     */
    const ADDER_PREFIX  = 'add';

    /**
     *
     * @param Tx_Smarty_Core_Wrapper $smartyInstance
     * @throws Tx_Smarty_Exception_CoreException
     */
    public function __construct(Tx_Smarty_Core_Wrapper $smartyInstance)
    {
        if ($smartyInstance instanceof Tx_Smarty_Core_Wrapper) {
            $this->smartyInstance = $smartyInstance;
            $this->smartyClass = new ReflectionClass($smartyInstance);

        } else {
            $msg = 'Configuration manager requires a valid instance of smarty!';
            throw new Tx_Smarty_Exception_CoreException($msg, 1320785449);
        }
    }

    /**
     * Manages smarty configuration settings by handling accessors (get, set and add). Adders are limited to
     * corresponding smarty methods (i.e. there are a limited number of adders), but setter/getters can be
     * used for all smarty properties which are publicly accessible.
     *
     * For example, $smarty->setCacheLifetime(12000) is equivalent to $smarty->cache_lifetime = 12000,
     * similarly $smarty->getCacheLifetime() will return $smarty->cache_lifetime. In the same vein the methods
     * $smarty->set('cache_lifetime', 12000) and $smarty->get('cache_lifetime') can be used to set/get properties.
     *
     * @param string $method
     * @param array $args
     * @throws Tx_Smarty_Exception_CoreException
     * @return mixed
     */
    final public function __call($method, array $args = array())
    {
        // Gets the accessor from the method name and throws an exception
        // if the method call is not a valid accessor.
        $accessor = self::getAccessorFromMethod($method);
        if (!self::hasAccessor($accessor)) {
            $msg = 'Method "' . $method .'" is not a valid accessor!';
            throw new Tx_Smarty_Exception_CoreException($msg, 1320785456);
        }

        // Constructs the proper method name and, if available, property from the
        // accessor, the method and the arguments
        if (strlen($method) > 3) {

            // Gets the property from the method call (the first three characters of the
            // method are the action, the remaining characters the property) and formats
            // it correctly, i.e. "template_dir" is extracted from "getTemplateDir"
            $property = t3lib_div::camelCaseToLowerCaseUnderscored(substr($method, 3));

        } else {
            // Alternatively if the method is just the accessor, e.g. set('template_dir', 'some/path')
            // then the property is the first argument. And the method is constructed from the action
            // and the property.
            $property = array_shift($args);
            $method = $accessor . t3lib_div::underscoredToUpperCamelCase($property);
        }

        // Halts execution with an exception if neither the method nor the property are available in smarty
        if (!$this->smartyClass->hasProperty($property) && !$this->smartyClass->hasMethod($method)) {
            $msg = 'Unknown property "' . $property . '" in method "' . $method .'"!';
            throw new Tx_Smarty_Exception_CoreException($msg, 1320785462);
        }

        // Special case: Halts execution with an exception if the accessor is an adder but there is no corresponding
        // method in smarty. This is necessary because there are only a few properties which have adders (for example,
        // plugins_dir is one of these).
        if (self::isAdder($accessor) && !$this->smartyClass->hasMethod($method)) {
            $msg = 'Method "' . $method . '" is not a valid smarty method!';
            throw new Tx_Smarty_Exception_CoreException($msg, 1320785472);
        }

        // Executes the accessor on the smarty property
        if (self::isSetter($accessor) || self::isAdder($accessor)) {

            // Gets the value to add or set from the arguments
            if (is_array($args) && !empty($args)) {

                $value = array_shift($args);

                if (strpos($value, ',')) {
                    $values = Tx_Smarty_Utility_Array::trimExplode(',', $value);
                    foreach ($values as $v) {
                        $value = self::parseValue($v);
                    }

                } else {
                    $value = self::parseValue($value);
                }

            } else {
                // If undefined the value is null and the action is equivalent to unsetting
                $value = null;
            }

            // Sets, adds or gets the value of the smarty property
            if ($this->smartyClass->hasMethod($method)) {

                // Uses smarty's setter or adder if available
                call_user_func(array($this->smartyInstance, $method), $value);

            } else {
                // Sets the smarty property directly
                $this->smartyInstance->{$property} = $value;
            }

            // Returns the current Smarty instance for chaining
            return $this->smartyInstance;

        } else {
            if ($this->smartyClass->hasMethod($method)) {
                // Uses smarty's getter if available
                return call_user_func(array($this->smartyInstance, $method));

            } else {
                // Accesses the smarty property directly
                return $this->smartyInstance->{$property};
            }
        }
    }

    /**
     * Handles additional parsing of the value
     *
     * @param $value
     * @throws Tx_Smarty_Exception_CoreException
     * @return array|mixed
     */
    private static function parseValue($value)
    {
        // Casts boolean from corresponding strings or returns the string unchanged
        $value = Tx_Smarty_Utility_Scalar::booleanize($value);

        if (Tx_Smarty_Utility_Smarty::isPathSetting($value)) {

            // Translates directories or files to absolute paths
            $value = Tx_Smarty_Utility_Path::resolvePaths($value);

        } elseif(strpos($value, '::')) {

            $staticPropertyParts = Tx_Smarty_Utility_Array::trimExplode('::', $value, true, 2);
            $class = $staticPropertyParts[0];
            $property = $staticPropertyParts[1];
            if (class_exists($class)) {
                $reflection = new ReflectionClass($class);
                if ($reflection->hasProperty($property)) {
                    $value = $reflection->getStaticPropertyValue($property);

                } else {
                    $msg = 'Class "' . $class . '" has no static property "' . $property . '"!';
                    throw new Tx_Smarty_Exception_CoreException($msg, 1356914788);
                }
            } else {
                $msg = 'Unable to locate class "' . $class . '" with static property "' . $property . '"!';
                throw new Tx_Smarty_Exception_CoreException($msg, 1356914936);
            }
        }

        return $value;
    }

    /**
     * Determines the kind of accessor from the method name, e.g. addTemplateDir is
     * an adder, setCacheDir is a setter etc.
     *
     * @param $method
     * @return string
     */
    private static function getAccessorFromMethod($method)
    {
        return strtolower(substr($method, 0, 3));
    }

    /**
     * Checks if a method prefix is an accessor (i.e. a getter, setter or an adder)
     *
     * @param $prefix
     * @return bool
     */
    private static function hasAccessor($prefix)
    {
        return self::isGetter($prefix)
            || self::isSetter($prefix)
            || self::isAdder($prefix);
    }

    /**
     * Checks if the method prefix is a getter
     *
     * @param $prefix
     * @return bool
     */
    private static function isGetter($prefix)
    {
        return $prefix === self::GETTER_PREFIX;
    }

    /**
     * Checks if the method prefix is a setter
     *
     * @param $prefix
     * @return bool
     */
    private static function isSetter($prefix)
    {
        return $prefix === self::SETTER_PREFIX;
    }

    /**
     * Checks if the method prefix is an adder
     *
     * @param $prefix
     * @return bool
     */
    private static function isAdder($prefix)
    {
        return $prefix === self::ADDER_PREFIX;
    }
}