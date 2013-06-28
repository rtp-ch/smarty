<?php

class Tx_Smarty_Utility_Environment
{
    /**
     * @var
     */
    private static $hasValid;

    /**
     * Checks if development mode is currently enabled
     *
     * @return bool
     */
    public static function hasDevelopmentMode()
    {
        if ((boolean) Tx_Smarty_Utility_ExtConf::getExtConfValue('enable_development_mode')) {
            return true;
        }

        $devEnvDefnitions = trim(Tx_Smarty_Utility_ExtConf::getExtConfValue('development_environment_definitions'));
        if ($devEnvDefnitions && self::anyValid($devEnvDefnitions)) {
            return true;
        }

        return false;
    }

    /**
     * Checks a number of contexts (comma separated list) and returns true if any one of these is valid
     *
     * @see isValid
     * @param $contexts
     * @return bool
     */
    public static function anyValid($contexts)
    {
        if (is_null(self::$hasValid)) {

            self::$hasValid = false;
            $contexts = Tx_Smarty_Utility_Array::trimExplode($contexts, ',');

            if (Tx_Smarty_Utility_Array::notEmpty($contexts)) {
                while ($context = array_shift($contexts)) {
                    if (self::isValid($context)) {
                        self::$hasValid = true;
                        // Exits on the first available valid environment context
                        break;
                    }
                }
            }
        }

        return self::$hasValid;
    }

    /**
     * Checks if:
     * - An environment variable is available
     *   and active in the current environment
     * - An environment variable matches a given
     *   value.
     *
     * Examples:
     * =========
     *
     * $context = "APP_ENVIRONMENT = development"
     * matches:
     * SetEnv APP_ENVIRONMENT development
     *
     * $context = "APP_ENVIRONMENT"
     * matches:
     * SetEnv APP_ENVIRONMENT true
     * but does not match:
     * SetEnv APP_ENVIRONMENT false
     *
     * @param string $context
     *
     * @return boolean
     */
    private static function isValid($context)
    {
        // Validates an environment variable
        if (strstr($context, '=') !== false) {

            // Validates the value of an environment variable
            $contextParts = Tx_Smarty_Utility_Array::trimExplode($context, '=', true, 2);
            $envSetting   = getenv($contextParts[0]);
            $isValid      = strtolower($envSetting) === strtolower($contextParts[1]);

        } else {
            // Validates that an environment variable exists and is "true"
            $isValid = (boolean) Tx_Smarty_Utility_Scalar::booleanize(getenv($context));
        }

        return $isValid;
    }
}