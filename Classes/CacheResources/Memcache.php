<?php

/**
 * Memcache CacheResource
 *
 * CacheResource Implementation based on the KeyValueStore API to use
 * memcache as the storage resource for Smarty's output caching.
 *
 * Note that memcache has a limitation of 256 characters per cache-key.
 * To avoid complications all cache-keys are translated to a sha1 hash.
 *
 * @package CacheResource-examples
 * @author Rodney Rehm
 */
class Tx_Smarty_CacheResources_Memcache extends Smarty_CacheResource_Custom
{
    /**
     * @var Name of the cache to use
     */
    const CACHE_NAME = 'cache_memcache_smarty';

    /**
     * @var t3lib_cache_frontend_PhpFrontend
     */
    private static $cacheMngr;

    /**
     *
     */
    public function __construct()
    {

    }

    /**
     * fetch cached content and its modification time from data source
     *
     * @param string $id unique cache content identifier
     * @param string $name template name
     * @param string $cache_id cache id
     * @param string $compile_id compile id
     * @param string $content cached content
     * @param integer $mtime cache modification timestamp (epoch)
     *
     * @return void
     * @throws Tx_Smarty_Exception_CacheException
     */
    protected function fetch($id, $name, $cache_id, $compile_id, &$content, &$mtime)
    {
        if (!is_null($id)) {
            $id = Tx_Smarty_Caching_Tags::convertToValidString($id);
            $content = self::getCacheMngr()->get($id);

        } else {
            $tags = array_merge(
                Tx_Smarty_Caching_Tags::getFromName($name),
                Tx_Smarty_Caching_Tags::getFromCacheId($cache_id),
                Tx_Smarty_Caching_Tags::getFromCompileId($compile_id)
            );

            $contents = self::getCacheMngr()->getBackend()->findIdentifiersByTags($tags);
            if (is_array($contents) && !empty($contents)) {
                $content = array_shift($contents);

            } /*else {
                $msg = 'Unable to retrieve cached smarty template from "' . self::CACHE_NAME . '"!';
                $code = 1395875399;
                throw new Tx_Smarty_Exception_CacheException($msg, $code);
            }*/
        }
    }

    /**
     * Save content to cache
     *
     * @param string $id unique cache content identifier
     * @param string $name template name
     * @param string $cache_id cache id
     * @param string $compile_id compile id
     * @param integer|null $exp_time seconds till expiration time in seconds or null
     * @param string $content content to cache
     *
     * @return void
     */
    protected function save($id, $name, $cache_id, $compile_id, $exp_time, $content)
    {
        $id = Tx_Smarty_Caching_Tags::convertToValidString($id);

        $tags = array_merge(
            Tx_Smarty_Caching_Tags::getFromName($name),
            Tx_Smarty_Caching_Tags::getFromCacheId($cache_id),
            Tx_Smarty_Caching_Tags::getFromCompileId($compile_id)
        );

        if (intval($exp_time) <= 0) {
            $lifetime  = self::getDefaultLifetime();

        } else {
            $lifetime = $GLOBALS['EXEC_TIME'] + intval($exp_time);
        }

        self::getCacheMngr()->set($id, $content, $tags, $lifetime);
    }

    /**
     * Delete content from cache
     *
     * @param string $name template name
     * @param string $cache_id cache id
     * @param string $compile_id compile id
     * @param integer|null $exp_time seconds till expiration or null
     *
     * @return void
     */
    protected function delete($name, $cache_id, $compile_id, $exp_time)
    {
        $tags = array_merge(
            Tx_Smarty_Caching_Tags::getFromName($name),
            Tx_Smarty_Caching_Tags::getFromCacheId($cache_id),
            Tx_Smarty_Caching_Tags::getFromCompileId($compile_id)
        );

        self::getCacheMngr()->flushByTags($tags);
    }

    private static function getDefaultLifetime()
    {
        static $defaultLifetime;

        if (is_null($defaultLifetime)) {
            $defaultLifetime = self::getDefaultExpirationTime() - $GLOBALS['EXEC_TIME'];
            $defaultLifetime = $GLOBALS['EXEC_TIME'];
        }

        return $defaultLifetime;
    }

    private static function getDefaultExpirationTime()
    {
        static $expirationTime;

        if (is_null($expirationTime)) {
            $frontend = Tx_Smarty_Service_Compatibility::makeInstance('Tx_Smarty_Core_FrontendProxy');
            $expirationTime = $frontend->cacheExpires;
        }


        return $expirationTime;
    }

    private static function getCacheMngr()
    {
        if(is_null(self::$cacheMngr)) {
            try {

                $GLOBALS['typo3CacheFactory']->create(
                    self::CACHE_NAME,
                    't3lib_cache_frontend_VariableFrontend',
                    't3lib_cache_backend_MemcachedBackend',
                    array(
                        'defaultLifetime' => self::getDefaultLifetime(),
                        'servers' => array('localhost:11211'),
                    )
                );

            } catch (t3lib_cache_exception_DuplicateIdentifier $e) {
                throw new RuntimeException($e->getMessage(), $e->getCode());
            }

            try {
                self::$cacheMngr = $GLOBALS['typo3CacheManager']->getCache(self::CACHE_NAME);

            } catch (t3lib_cache_exception_NoSuchCache $e) {
                throw new RuntimeException($e->getMessage(), $e->getCode());
            }
        }

        return self::$cacheMngr;
    }
}
