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
     * Generic setter for smarty properties.
     *
     * @param $key
     * @param $value
     * @throws Tx_Smarty_Exception_CoreException
     */
    final public function set($key, $value = null)
    {
        //
        $method = 'set' . t3lib_div::underscoredToUpperCamelCase($key);

        // Halts execution with an exception if neither the method nor the property are available in smarty
        if (!$this->smartyClass->hasProperty($key) && !$this->smartyClass->hasMethod($method)) {
            $msg = 'Unknown or inaccessible smarty property "' . $key .'"!';
            throw new Tx_Smarty_Exception_CoreException($msg, 1359055103);
        }

        if (!is_null($value)) {
            if (strpos($value, ',')) {
                $values = Tx_Smarty_Utility_Array::trimExplode($value, ',');
                foreach ($values as $v) {
                    $value = self::parseValue($v);
                }

            } else {
                $value = self::parseValue($value);
            }
        }

        $this->smartyInstance->{$key} = $value;
    }

    /**
     * Adder for smarty properties. Only available for equivalent accessors
     * (e.g. addTemplateDir) in smarty.
     *
     * @param $key
     * @param $value
     * @throws Tx_Smarty_Exception_CoreException
     */
    final public function add($key, $value)
    {
        $method = 'add' . t3lib_div::underscoredToUpperCamelCase($key);

        if (!$this->smartyClass->hasMethod($method)) {
            $msg = 'Unknown smarty adder "' . $method .'" for property "' . $key .'"!';
            throw new Tx_Smarty_Exception_CoreException($msg, 1359054668);
        }

        if (!is_null($value)) {
            if (strpos($value, ',')) {
                $values = Tx_Smarty_Utility_Array::trimExplode($value, ',');
                foreach ($values as $v) {
                    $value = self::parseValue($v);
                }

            } else {
                $value = self::parseValue($value);
            }
        }

        // Adders are only available via inbuilt smarty methods
        call_user_func(array($this->smartyInstance, $method), $value);
    }

    /**
     * Generic getter for smarty properties.
     *
     * @param $key
     * @return array|mixed|null|string
     * @throws Tx_Smarty_Exception_CoreException
     */
    final public function get($key)
    {
        $method = 'get' . t3lib_div::underscoredToUpperCamelCase($key);

        if (!$this->smartyClass->hasProperty($key) && !$this->smartyClass->hasMethod($method)) {
            $msg = 'Unknown or inaccessible smarty property "' . $key .'"!';
            throw new Tx_Smarty_Exception_CoreException($msg, 1359055216);
        }

        return $this->smartyInstance->{$key};
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

        if (Tx_Smarty_Service_Smarty::isPathSetting($value)) {

            // Translates directories or files to absolute paths
            $value = Tx_Smarty_Utility_Path::resolvePaths($value);

        } elseif (strpos($value, '::')) {

            // Resolves constants or static properties in TypoScript settings, e.g. Smarty::PHP_PASSTHRU
            $propertyParts = Tx_Smarty_Utility_Array::trimExplode($value, '::', true, 2);
            $class = $propertyParts[0];
            $property = $propertyParts[1];

            if (class_exists($class)) {
                $reflection = new ReflectionClass($class);
                if ($reflection->hasProperty($property)) {
                    $value = $reflection->getStaticPropertyValue($property);

                } elseif ($reflection->hasConstant($property)) {
                    $value = $reflection->getConstant($property);

                } else {
                    $msg = 'Class "' . $class . '" has no static property or constant "' . $property . '"!';
                    throw new Tx_Smarty_Exception_CoreException($msg, 1356914788);
                }
            } else {
                $msg = 'Unable to locate class "' . $class . '" with static property "' . $property . '"!';
                throw new Tx_Smarty_Exception_CoreException($msg, 1356914936);
            }
        }

        return $value;
    }
}