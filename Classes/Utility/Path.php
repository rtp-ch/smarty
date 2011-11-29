<?php


class Tx_Smarty_Utility_Path
{
    /**
     * @static
     * @param $dirs
     * @return array
     */
    public static function resolvePaths($dirs)
    {
        $paths = null;
        if (is_array($dirs)) {
            while($dir = array_shift($dirs)) {
                $path = t3lib_div::getFileAbsFileName($dir);
                $paths[] = (is_dir($path) && substr($path, -1) !== DS) ? $path . DS : $path;
            }
        } elseif (is_scalar($dirs)) {
            $paths  = t3lib_div::getFileAbsFileName($dirs);
            $paths .= (is_dir($paths) && substr($paths, -1) !== DS) ? DS : '';
        }

        // NOTE: No attempt is made to validate file path(s)
        return $paths;
    }



}