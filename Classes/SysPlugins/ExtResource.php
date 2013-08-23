<?php

class Tx_Smarty_SysPlugins_ExtResource extends Smarty_Resource_Custom
{
    /**
     * Resolves a file relative to the TYPO3 siteroot placed in an extension.
     *
     * @see t3lib_div::getFileAbsFileName
     * @param string  $name    template name
     * @param string  &$source template source
     * @param integer &$mtime  template modification timestamp (epoch)
     */
    protected function fetch($name, &$source, &$mtime)
    {
        $file = Tx_Smarty_Service_Compatibility::getFileAbsFileName('EXT' . $name);

        if (is_file($file) && is_readable($file)) {
            $mtime  = filemtime($file);
            $source = file_get_contents($file);
        }
    }
}
