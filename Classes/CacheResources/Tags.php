<?php

class Tx_Smarty_Caching_Tags
{
    /**
     * @var string Prefix for tags which relate to compile_ids
     */
    const COMPILE_ID_TYPE = 'compile_id';

    /**
     * @var string Prefix for tags which relate to cache_ids
     */
    const CACHE_ID_TYPE = 'cache_id';

    /**
     * @var string Prefix for tags which relate to cached filepaths
     */
    const CACHE_FILEPATH_TYPE = 'filepath';

    /**
     * @var string Prefix for tags which relate to cached templates
     */
    const CACHE_TEMPLATE_TYPE = 'template';

    /**
     * @var string Wildcard tag (matches all tags, i.e. is attached to every cache entry)
     */
    const KEYWORD_ALL = 'all';

    /**
     * @var string The character which is used to split a cache tag into two parts (i.e. type and tag)
     */
    const GLUE_CHAR = '&';

    const PAGE_PREFIX = 'page_';

    const TYPE_PREFIX = 'type_';

    const LANG_PREFIX = 'lang_';

    const PATTERN_TAG = '/^[^a-zA-Z0-9_%\-]$/';

    /**
     * @var array The list of valid tag prefix types
     */
    private static $types = array(
        self::COMPILE_ID_TYPE,
        self::CACHE_ID_TYPE
    );

    /**
     * Removes any invalid characters from the tag string and converts to lowercase
     *
     * @param string $string The string to convert
     *
     * @return mixed
     * @see Tx_Smarty_Caching_Tags::REPLACE_PATTERN
     */
    public static function convertToValidString($string)
    {
        return sha1($string);
    }

    /**
     * Same as convertToValidString only accepts a list (comma separated or as an array) and converts each entry
     * to a valid string.
     *
     * @param array|string $strings The list of strings to convert
     *
     * @return array
     */
    public static function convertToValidStrings($strings)
    {
        if (!is_array($strings)) {
            $strings = Tx_Smarty_Utility_Array::trimExplode($strings, '|', true);
        }

        return array_map(array('self', 'convertToValidString'), $strings);
    }

    /**
     * Returns a tag in the format "prefix&tag" from the given smarty cache type (compile or cache) and string.
     * If no string is defined prefix&all will be returned.
     *
     * @param null|string $tag  The actual tag string
     * @param string      $type The tag type (@see Tx_Smarty_Caching_Tags::$types)
     *
     * @return bool|string
     */
    public static function get($tag = null, $type = null)
    {
        if (!strlen($tag)) {
            $tag = self::KEYWORD_ALL;

        } else {
            $tag = self::convertToValidString($tag);
        }

        if (is_string($type)) {
            $type = strtolower(trim($type));
        }

        if (is_null($type) || !self::isValidType($type)) {
            $type = self::CACHE_ID_TYPE;
        }

        return $type . self::GLUE_CHAR . $tag;
    }

    /**
     * @param $cacheId
     * @return array
     */
    public static function getFromCacheId($cacheId)
    {
        $tags = array();

        $cacheIds = self::convertToValidStrings($cacheId);
        while ($tag = array_shift($cacheIds)) {
            $tags[] = Tx_Smarty_Caching_Tags::get($tag, self::CACHE_ID_TYPE);
        }

        return $tags;
    }

    /**
     * @param $compileId
     * @return array
     */
    public static function getFromCompileId($compileId)
    {
        $tags = array();

        $compileIds = self::convertToValidStrings($compileId);
        while ($tag = array_shift($compileIds)) {
            $tags[] = Tx_Smarty_Caching_Tags::get($tag, self::COMPILE_ID_TYPE);
        }

        return $tags;
    }

    /**
     * @param $name
     * @return array
     */
    public static function getFromName($name)
    {
        $tags = array();

        $names = self::convertToValidStrings($name);
        while ($tag = array_shift($names)) {
            $tags[] = Tx_Smarty_Caching_Tags::get($tag, self::CACHE_FILEPATH_TYPE);
        }

        return $tags;
    }

    /**
     * Checks if the given tag type matches one of those defined in Tx_Smarty_Caching_Tags::$types
     *
     * @param string $type The type to check
     *
     * @return bool
     */
    private static function isValidType($type)
    {
        return in_array($type, self::$types);
    }
}
