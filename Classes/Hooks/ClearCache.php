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
        $chDir = Tx_Smarty_Service_Compatibility::getFileAbsFileName(Tx_Smarty_Core_Configuration::DEFAULT_CACHE_DIR);

        if ($deletePid || $params['cacheCmd'] === 'all' || $params['cacheCmd'] === 'pages') {
            self::clearDir($chDir);
        }
    }

    /**
     * Recursively remove all contents (files & directories) of the given directory
     *
     * @param $dir
     */
    private static function clearDir($dir)
    {
        Tx_Smarty_Service_Compatibility::flushDirectory($dir);
    }
}
