<?php

class Tx_Smarty_SysPlugins_PathResource extends Smarty_Resource_Custom
{
    /**
     * Resolves TYPO3 style resources path datatypes,
     * such as path:EXT:ie7/js/ie7-standard.js
     *
     *
     * @see the corresponsing documentation in tsref "Datatype reference"
     * @param string  $name    template name
     * @param string  &$source template source
     * @param integer &$mtime  template modification timestamp (epoch)
     */
    protected function fetch($name, &$source, &$mtime)
    {
        $cObj = Tx_Smarty_Service_Compatibility::makeInstance('Tx_Smarty_Core_CobjectProxy');
        $file = $cObj->getData('path:' . $name, null);

        if (is_file($file) && is_readable($file)) {
            $mtime  = filemtime($file);
            $source = file_get_contents($file);
        }
    }
}
