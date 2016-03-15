
**PLEASE NOTE:** This project is no longer maintained. If you are interested in continuing the maintenance of this extension, please get in touch with us or create a fork.

#Smarty Templating Engine for TYPO3

## Basic Usage

        $smarty = \RTP\smarty\Factory::get();
        $smarty->addTemplateDir('path/to/my/templates');
        $smarty->addLanguageFile('path/to/my/language/file');
        $smarty->addPluginsDir('path/to/my/plugins');
        $smarty->assign('data', $myData);

        return $smarty->display('myTemplate.tpl');

