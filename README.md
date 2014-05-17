
#Smarty Templating Engine for TYPO3

## Basic Usage

        $smarty = \RTP\smarty\Factory::get();
        $smarty->addTemplateDir('path/to/my/templates');
        $smarty->addLanguageFile('path/to/my/language/file');
        $smarty->addPluginsDir('path/to/my/plugins');
        $smarty->assign('data', $myData);

        return $smarty->display('myTemplate.tpl');

