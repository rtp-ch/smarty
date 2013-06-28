<?php

class Tx_Smarty_Utility_Path
{
    /**
     * Resolves paths to absolute locations, e.g. EXT:my_ext/foo/bar is
     * expanded to it's absolute location.
     *
     * @param array|string $dirs Path(s) to resolve
     * @return array
     */
    public static function resolvePaths($dirs)
    {
        $paths = null;
        if (is_array($dirs)) {
            while ($dir = array_shift($dirs)) {
                $paths[] =  self::resolvePath($dir);
            }

        } elseif (is_scalar($dirs)) {
            $paths  = self::resolvePath($dirs);
        }

        // NOTE: No attempt is made to validate file path(s)
        return $paths;
    }

    /**
     * Gets the absolute path of a given directory or file. If the directory or
     * file name starts with a directory separator it's already assumed to be relative.
     *
     * @param $path
     * @return string
     */
    public static function resolvePath($path)
    {
        $path = trim($path);

        // Resolves the path in relation to the TYPO3 directory if
        // the path is not absolute (e.g. /absolute/path/to/somewehere)
        if (substr($path, 0, 1) !== DIRECTORY_SEPARATOR) {
            $path = t3lib_div::getFileAbsFileName($path, false);
        }

        // Ensures path has ending directory separator
        if ((is_dir($path) && substr($path, -1) !== DIRECTORY_SEPARATOR)) {
            $path .= DIRECTORY_SEPARATOR;
        }

        return $path;
    }
}
