<?php

class Tx_Smarty_Utility_ExtConf
{
    /**
     * The system wide extension configuration is implemented as a singleton
     * 
     * @var array
     */
    private static $extConf;

    /**
     * Gets the system wide extension configuration
     * 
     * @return array
     */
    public static function getExtConf()
    {
        if (is_null(self::$extConf)) {
            self::$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['smarty']);
        }

        return self::$extConf;
    }

    /**
     * Retrieves a setting for a given key from the system wide extension configuration.
     *
     * @param string $key The configuration setting to retrieve
     * @return string
     */
    public static function getExtConfValue($key)
    {
        static $extConf;
        if (is_null($extConf)) {
            $extConf = self::getExtConf();
        }

        return isset($extConf[$key]) ? $extConf[$key] : null;
    }
}