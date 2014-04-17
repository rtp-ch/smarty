<?php

class tx_smarty_cache {

	function clearSmartyCache($params, $ref)
	{
		if (isset($TYPO3_CONF_VARS['SYS']['compat_version'])
			&& t3lib_div::int_from_ver($TYPO3_CONF_VARS['SYS']['compat_version']) < 6000000
		) {
			$deletePid = t3lib_div::intval_positive($params['cacheCmd']);
		} else {
			$deletePid = \TYPO3\CMS\Core\Utility\MathUtility::convertToPositiveInteger($params['cacheCmd']);
		}

		$cacheFiles = t3lib_div::getFilesInDir(PATH_site . 'typo3temp/smarty_cache/');
		if(!empty($cacheFiles)) {
			if($deletePid || $params['cacheCmd'] == 'all' || $params['cacheCmd'] == 'pages') {
		    	foreach($cacheFiles as $cacheFile) {				
					if($deletePid) {
						if(strpos($cacheFile, $deletePid . '|') === 0) {
							@unlink(PATH_site . 'typo3temp/smarty_cache/' . $cacheFile);
						}
					} else {
						if(strpos(strtolower($cacheFile), 'index') !== 0) {
							@unlink(PATH_site . 'typo3temp/smarty_cache/' . $cacheFile);
						}
					}			
				}
			}
		}
		$compileFiles = t3lib_div::getFilesInDir(PATH_site . 'typo3temp/smarty_compile/');
		if(!empty($compileFiles)) {
			if($deletePid || $params['cacheCmd'] == 'all' || $params['cacheCmd'] == 'pages') {
		    	foreach($compileFiles as $compileFile) {	
		    		// Clear all compiled smarty files			
					if(strpos(strtolower($compileFile), 'index') !== 0) {
						@unlink(PATH_site . 'typo3temp/smarty_compile/' . $compileFile);
					}
				}
			}
		}		
	}
}