<?php


class Tx_Smarty_Utility_Path
{
    /**
     * Resolves paths to absolute locations, e.g. EXT:my_ext/foo/bar is
     * expaned to it's absolute location.
     *
     * @param array|string $dirs Path(s) to resolve
     * @return array
     */
    public static function resolvePaths($dirs)
    {
        $paths = null;
        if (is_array($dirs)) {
            while($dir = array_shift($dirs)) {
                $path = self::resolvePath($dir);
                $paths[] = (is_dir($path) && substr($path, -1) !== DS) ? $path . DS : $path;
            }
        } elseif (is_scalar($dirs)) {
            $paths  = self::resolvePath($dirs);
            $paths .= (is_dir($paths) && substr($paths, -1) !== DS) ? DS : '';
        }

        // NOTE: No attempt is made to validate file path(s)
        return $paths;
    }

    /**
     * Gets the absolute path of a given directory or file. If the directory or
     * file name starts with a directory seperator it's already assumed to be relative.
     *
     * @param $dir
     * @return string
     */
    private static function resolvePath($dir)
    {
        $dir = trim($dir);
        if(substr($dir, 0, 1) !== DS) {
            $dir = t3lib_div::getFileAbsFileName($dir, false);
        }
        return $dir;
    }
}