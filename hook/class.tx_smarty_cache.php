<?php

class tx_smarty_cache {

	function clearSmartyCache($params, $ref)
	{
        $deletePid = t3lib_div::intval_positive($params['cacheCmd']);
		$cacheFiles = t3lib_div::getFilesInDir(PATH_site . 'typo3temp/smarty_cache/');
		if(!empty($cacheFiles)) {
		    foreach($cacheFiles as $cacheFile) {
		        if($deletePid) {
		            if(strpos($cacheFile, $deletePid . '-') === 0) {
		                @unlink(PATH_site . 'typo3temp/smarty_cache/' . $cacheFile);
		            }
		        } elseif(strpos(strtolower($cacheFile), 'index') !== 0) {
		            @unlink(PATH_site . 'typo3temp/smarty_cache/' . $cacheFile);
		        }
		    }
		}
	}
}