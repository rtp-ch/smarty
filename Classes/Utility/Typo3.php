<?php


class Tx_Smarty_Utility_Typo3   
{
    /**
     *
     *
     * @return bool
     */
    public static function isFeInstance()
    {
        return (TYPO3_MODE === 'FE' && $GLOBALS['TSFE'] instanceof tslib_fe);
    }

    /**
     *
     *
     * @return bool
     */
    public static function isBeInstance()
    {
        return (TYPO3_MODE === 'BE' && $GLOBALS['BE_USER'] instanceof t3lib_tsfeBeUserAuth);
    }

    /**
     *
     *
     * @return bool
     */
    public static function isCliMode()
    {
        return (defined('TYPO3_cliMode') && TYPO3_cliMode) ? true : false;
    }
}