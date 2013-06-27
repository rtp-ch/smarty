<?php


class tx_smarty
{
    /**
     * @param array $options
     * @return Tx_Smarty_Core_Wrapper
     */
    public function smarty($options = array())
    {
        t3lib_div::logDeprecatedFunction();
        return self::backportSmarty((array) $options);
    }

    /**
     * @param array $options
     * @return Tx_Smarty_Core_Wrapper
     */
    public function newSmarty($options = array())
    {
        t3lib_div::logDeprecatedFunction();
        return self::backportSmarty((array) $options);
    }

    /**
     * @param array $options
     * @return Tx_Smarty_Core_Wrapper
     */
    public function newSmartyTemplate($options = array())
    {
        t3lib_div::logDeprecatedFunction();
        return self::backportSmarty((array) $options);
    }

    /**
     * @param array $options
     * @return Tx_Smarty_Core_Wrapper
     */
    private function backportSmarty($options = array())
    {
        $callingInstance = self::getCallingInstance();

        if (!isset($options['pathToLanguageFile'])) {
            $options['pathToLanguageFile'] = self::getLanguageFile($callingInstance);
        }

        $prefixId = self::getPrefixId($callingInstance);

        return \RTP\smarty\Factory::get((array) $options, $prefixId);
    }

    /**
     * Makes use of a little known quirk/wtf of PHP to get the instance of the calling class:
     * "$this" refers back to the instance of the calling class when a non-static method is
     * called statically.
     *
     * This "feature" was used in the previous version of this extension to automagically read
     * properties of the extension which was invoking smarty. Specifically it was used to identify
     * and load the proper locallang file.
     *
     * As this behaviour throws an error in E_STRICT and is "wrong" it has been deprecated and
     * is only employed here for the purpose of backwards compatibility.
     *
     * @return object|stdClass
     * @deprecated
     */
    private function getCallingInstance()
    {
        return is_object($this) ? $this : new stdClass();
    }

    /**
     * Get the extKey property of the calling class, i.e. the extension key.
     *
     * @param $callingInstance
     * @return null
     */
    private static function getExtKey($callingInstance)
    {
        return isset($callingInstance->extKey) ? $callingInstance->extKey : null;
    }

    /**
     * Get the prefixId property of the calling class. The prefixId property is
     * used for determining piVars in the traditional tslib_pibase scenario.
     *
     * @param $callingInstance
     * @return string|null
     */
    private static function getPrefixId($callingInstance)
    {
        return isset($callingInstance->prefixId) ? $callingInstance->prefixId : null;
    }

    /**
     * Get the scriptRelPath property of the calling class. The scriptRelPath property is
     * used for determining the location of the language file in the traditional tslib_pibase scenario.
     *
     * @param $callingInstance
     * @return string|null
     */
    private static function getScriptRelPath($callingInstance)
    {
        return isset($callingInstance->scriptRelPath) ? $callingInstance->scriptRelPath : null;
    }

    /**
     * Tries to get the localllang file from the extension cofiguration in the traditional tslib_pibase
     * scenario. Note: Support for the lib/div mvc scenario has been dropped.
     *
     * @param $callingInstance
     * @return string|false
     */
    private static function getLanguageFile($callingInstance)
    {
        $languageFile = false;

        $extKey = self::getExtKey($callingInstance);
        $scriptRelPath = self::getScriptRelPath($callingInstance);

        if (!is_null($scriptRelPath) && !is_null($extKey)) {
            $langFileBase = t3lib_extMgm::extPath($extKey, dirname($scriptRelPath)) . '/locallang';

            if (is_file($langFileBase . '.xml')) {
                $languageFile = $langFileBase . '.xml';

            } elseif (is_file($langFileBase . '.php')) {
                $languageFile = $langFileBase . '.php';
            }
        }

        return $languageFile;
    }
}
