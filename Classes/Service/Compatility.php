<?php

class Tx_Smarty_Service_Compatibility
{
    /**
     * Abstraction method which returns System Environment Variables regardless of server OS, CGI/MODULE version etc.
     * Basically this is SERVER variables for most of them.
     * This should be used instead of getEnv() and $_SERVER/ENV_VARS to get reliable values for all situations.
     *
     * @param string $getEnvName Name of the "environment variable"/"server variable" you wish to use.
     *        Valid values are SCRIPT_NAME, SCRIPT_FILENAME, REQUEST_URI, PATH_INFO, REMOTE_ADDR, REMOTE_HOST,
     *        HTTP_REFERER, HTTP_HOST, HTTP_USER_AGENT, HTTP_ACCEPT_LANGUAGE, QUERY_STRING, TYPO3_DOCUMENT_ROOT,
     *        TYPO3_HOST_ONLY, TYPO3_HOST_ONLY, TYPO3_REQUEST_HOST, TYPO3_REQUEST_URL, TYPO3_REQUEST_SCRIPT,
     *        TYPO3_REQUEST_DIR, TYPO3_SITE_URL, _ARRAY
     * @return string Value based on the input key, independent of server/os environment.
     */
    public static function getIndpEnv($getEnvName)
    {
        if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility')) {
            return call_user_func(array('\TYPO3\CMS\Core\Utility\GeneralUtility', 'getIndpEnv'), $getEnvName);

        } else {
            return call_user_func(array('t3lib_div', 'getIndpEnv'), $getEnvName);
        }
    }

    /**
     * Logs a call to a deprecated function.
     * The log message will be taken from the annotation.
     * @return	void
     */
    public static function logDeprecatedFunction()
    {
        if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility')) {
            call_user_func(array('\TYPO3\CMS\Core\Utility\GeneralUtility', 'logDeprecatedFunction'));

        } else {
            call_user_func(array('t3lib_div', 'logDeprecatedFunction'));
        }
    }

    /**
     * Returns the absolute filename of a relative reference, resolves the "EXT:" prefix (way of referring to files
     * inside extensions) and checks that the file is inside the PATH_site of the TYPO3 installation and implies a
     * check with \TYPO3\CMS\Core\Utility\GeneralUtility::validPathStr(). Returns FALSE if checks failed.
     * Does not check if the file exists.
     *
     * @param string  $filename     The input filename/filepath to evaluate
     * @param boolean $onlyRelative If $onlyRelative is set (which it is by default), then only return values relative
     *        to the current PATH_site is accepted.
     * @param boolean $relToTypo3MainDir If $relToTYPO3_mainDir is set, then relative paths are relative to PATH_typo3
     *        constant - otherwise (default) they are relative to PATH_site
     * @return string Returns the absolute filename of $filename IF valid, otherwise blank string.
     */
    public static function getFileAbsFileName($filename, $onlyRelative = true, $relToTypo3MainDir = false)
    {
        if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility')) {
            return call_user_func(
                array('\TYPO3\CMS\Core\Utility\GeneralUtility', 'getFileAbsFileName'),
                $filename,
                $onlyRelative,
                $relToTypo3MainDir
            );

        } else {
            return call_user_func(
                array('t3lib_div', 'getFileAbsFileName'),
                $filename,
                $onlyRelative,
                $relToTypo3MainDir
            );
        }
    }

    /**
     * Reads the file or url $url and returns the content
     * If you are having trouble with proxys when reading URLs you can configure your way out of that with settings
     * like $GLOBALS['TYPO3_CONF_VARS']['SYS']['curlUse'] etc.
     *
     * @param string  $url           File/URL to read
     * @param integer $includeHeader Whether the HTTP header should be fetched or not. 0=disable, 1=fetch
     * header+content, 2=fetch header only
     * @param array|bool $requestHeaders HTTP headers to be used in the request
     * @param array      $report         Error code/message and, if $includeHeader is 1, response meta data
     * (HTTP status and content type)
     * @return mixed The content from the resource given as input. FALSE if an error has occured.
     */
    public static function getUrl($url, $includeHeader = 0, $requestHeaders = false, &$report = null)
    {
        if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility')) {
            return \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($url, $includeHeader, $requestHeaders, $report);

        } else {
            return \t3lib_div::getUrl($url, $includeHeader, $requestHeaders, $report);
        }
    }

    /**
     * Merges two arrays recursively and "binary safe" (integer keys are
     * overridden as well), overruling similar values in the first array
     * ($arr0) with the values of the second array ($arr1)
     * In case of identical keys, ie. keeping the values of the second.
     *
     * @param array   $arr0       First array
     * @param array   $arr1       Second array, overruling the first array
     * @param boolean $notAddKeys If set, keys that are NOT found in $arr0 (first array) will not be set.
     * Thus only existing value can/will be overruled from second array.
     * @param boolean $includeEmptyValues If set, values from $arr1 will overrule if they are
     * empty or zero. Default: TRUE
     * @param boolean $enableUnsetFeature If set, special values "__UNSET" can be used in the second array
     * in order to unset array keys in the resulting array.
     * @return array Resulting array where $arr1 values has overruled $arr0 values
     */
    public static function arrayMergeRecursiveOverrule(
        array $arr0,
        array $arr1,
        $notAddKeys = false,
        $includeEmptyValues = true,
        $enableUnsetFeature = true
    ) {
        if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility')) {
            return call_user_func(
                array('\TYPO3\CMS\Core\Utility\GeneralUtility', 'array_merge_recursive_overrule'),
                $arr0,
                $arr1,
                $notAddKeys,
                $includeEmptyValues,
                $enableUnsetFeature
            );

        } else {
            return call_user_func(
                array('t3lib_div', 'array_merge_recursive_overrule'),
                $arr0,
                $arr1,
                $notAddKeys,
                $includeEmptyValues,
                $enableUnsetFeature
            );
        }
    }

    /**
     * Creates an instance of a class taking into account the class-extensions
     * API of TYPO3. USE THIS method instead of the PHP "new" keyword.
     *
     * E.g. "$obj = new myclass;" should be:
     * "$obj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("myclass")"
     *
     * You can also pass arguments for a constructor:
     * \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('myClass', $arg1, $arg2, ..., $argN)
     *
     * @throws \InvalidArgumentException if classname is an empty string
     * @param  string                    $class name of the class to instantiate, must not be empty
     * @return object                    the created instance
     */
    public static function makeInstance($class)
    {
        $arguments = func_get_args();
        array_shift($arguments);
        array_unshift($arguments, $class);

        if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility')) {
            return call_user_func_array(array('\TYPO3\CMS\Core\Utility\GeneralUtility', 'makeInstance'), $arguments);

        } else {
            return call_user_func_array(array('t3lib_div', 'makeInstance'), $arguments);
        }
    }

    /**
     * Returns the absolute path to the extension with extension key $key
     * If the extension is not loaded the function will die with an error message
     * Useful for internal fileoperations
     *
     * @param $key string Extension key
     * @param $script string $script is appended to the output if set.
     * @throws \BadFunctionCallException
     * @return string
     */
    public static function extPath($key, $script = '')
    {
        if (class_exists('\TYPO3\CMS\Core\Utility\ExtensionManagementUtility')) {
            return call_user_func(
                array('\TYPO3\CMS\Core\Utility\ExtensionManagementUtility', 'extPath'),
                $key,
                $script
            );

        } else {
            return call_user_func(array('t3lib_extMgm', 'extPath'), $key, $script);
        }
    }

    /**
     * Returns an array with the names of files in a specific path
     *
     * @param string $path Is the path to the file
     * @param string $extList is the comma list of extensions to read only (blank = all)
     * @param int $prefix If set, then the path is prepended the filenames. Otherwise only the filenames
     * are returned in the array
     * @param string $order is sorting: 1= sort alphabetically, 'mtime' = sort by modification time.
     * @param string $exclPattern A comma seperated list of filenames to exclude, no wildcards
     * @return array Array of the files found
     */
    public static function getFilesInDir($path, $extList = '', $prefix = 0, $order = '', $exclPattern = '')
    {
        if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility')) {
            return call_user_func(
                array('\TYPO3\CMS\Core\Utility\GeneralUtility', 'getFilesInDir'),
                $path,
                $extList,
                $prefix,
                $order,
                $exclPattern
            );

        } else {
            return call_user_func(
                array('t3lib_div', 'getFilesInDir'),
                $path,
                $extList,
                $prefix,
                $order,
                $exclPattern
            );
        }
    }

    /**
     * Returns an array with the names of folders in a specific path
     * Will return 'error' (string) if there were an error with reading directory content.
     *
     * @param string $path Path to list directories from
     * @return array Returns an array with the directory entries as values. If no path, the return value is nothing.
     */
    public static function getDirs($path)
    {
        if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility')) {
            return call_user_func(array('\TYPO3\CMS\Core\Utility\GeneralUtility', 'get_dirs'), $path);

        } else {
            return call_user_func(array('t3lib_div', 'get_dirs'), $path);
        }
    }

    /**
     * Wrapper function for rmdir, allowing recursive deletion of folders and files
     *
     * @param string $path Absolute path to folder, see PHP rmdir() function. Removes trailing slash internally.
     * @param boolean $removeNonEmpty Allow deletion of non-empty directories
     * @return boolean true if @rmdir went well!
     */
    public static function rmDir($path, $removeNonEmpty = false)
    {
        if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility')) {
            return call_user_func(array('\TYPO3\CMS\Core\Utility\GeneralUtility', 'rmdir'), $path, $removeNonEmpty);

        } else {
            return call_user_func(array('t3lib_div', 'rmdir'), $path, $removeNonEmpty);
        }
    }

    /**
     * Returns a given string with underscores as UpperCamelCase.
     * Example: Converts blog_example to BlogExample
     *
     * @param string $str String to be converted to camel case
     * @return string UpperCamelCasedWord
     */
    public static function underscoredToUpperCamelCase($str)
    {
        if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility')) {
            return call_user_func(array('\TYPO3\CMS\Core\Utility\GeneralUtility', 'underscoredToUpperCamelCase'), $str);

        } else {
            return call_user_func(array('t3lib_div', 'underscoredToUpperCamelCase'), $str);
        }
    }

    /**
     * Loads the $GLOBALS['TCA'] (Table Configuration Array) for the $table
     *
     * Requirements:
     * 1) must be configured table (the ctrl-section configured),
     * 2) columns must not be an array (which it is always if whole table loaded), and
     * 3) there is a value for dynamicConfigFile (filename in typo3conf)
     *
     * Note: For the frontend this loads only 'ctrl' and 'feInterface' parts.
     * For complete TCA use $GLOBALS['TSFE']->includeTCA() instead.
     *
     * @param string $table Table name for which to load the full TCA array part into $GLOBALS['TCA']
     * @return mixed
     */
    public static function loadTca($table)
    {
        if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility')) {
            return call_user_func(array('\TYPO3\CMS\Core\Utility\GeneralUtility', 'loadTCA'), $table);

        } else {
            return call_user_func(array('t3lib_div', 'loadTCA'), $table);
        }
    }

    /**
     * Checks if the $path is absolute or relative (detecting either '/' or 'x:/' as first part of string) and returns TRUE if so.
     *
     * @param string $path File path to evaluate
     * @return boolean
     */
    public static function isAbsPath($path)
    {
        if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility')) {
            return call_user_func(array('\TYPO3\CMS\Core\Utility\GeneralUtility', 'isAbsPath'), $path);

        } else {
            return call_user_func(array('t3lib_div', 'isAbsPath'), $path);
        }
    }
}
