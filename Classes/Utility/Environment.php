<?php

class Tx_Smarty_Utility_Environment
{
    /**
     * @var
     */
    private static $hasValid;

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