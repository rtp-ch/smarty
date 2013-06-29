<?php

/**
 * TODO: Implement more fine grained control over cache clearing via cache ids
 * TODO: Register alternate caching mechanisms with smarty
 */
class Tx_Smarty_Hooks_ClearCache
{
    /**
     * @param $params
     * @param $ref
     * @return void
     */
    public function clearSmartyCache($params, $ref)
    {
        $deletePid  = t3lib_div::intval_positive($params['cacheCmd']);
        $cachePath = PATH_site . 'typo3temp/smarty_cache/';
        $compilePath = PATH_site . 'typo3temp/smarty_compile/';

        if ($deletePid || $params['cacheCmd'] === 'all' || $params['cacheCmd'] === 'pages') {
            self::clearDir($cachePath);
            self::clearDir($compilePath);
        }
    }

    /**
     * Recursively remove all contents (files & directories) of the given directory
     *
     * @param $dir
     */
    private static function clearDir($dir)
    {
        $filesInPath = t3lib_div::getFilesInDir($dir);
        while ($fileInPath = array_shift($filesInPath)) {
            @unlink($dir . $fileInPath);
        }

        $dirsInPath = t3lib_div::get_dirs($dir);
        while ($dirInPath = array_shift($dirsInPath)) {
            t3lib_div::rmdir($dir . $dirInPath, true);
        }
    }
}