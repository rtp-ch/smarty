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
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function clearSmartyCache($params, $ref)
    {
        $deletePid = intval($params['cacheCmd']) > 0 ? intval($params['cacheCmd']) : 0;
        $cachePath = PATH_SITE . 'typo3temp/smarty_cache/';
        $compilePath = PATH_SITE . 'typo3temp/smarty_compile/';

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
        $filesInPath = Tx_Smarty_Service_Compatibility::getFilesInDir($dir);
        while ($fileInPath = array_shift($filesInPath)) {
            @unlink($dir . $fileInPath);
        }

        $dirsInPath = Tx_Smarty_Service_Compatibility::getDirs($dir);
        while ($dirInPath = array_shift($dirsInPath)) {
            Tx_Smarty_Service_Compatibility::rmdir($dir . $dirInPath, true);
        }
    }
}
