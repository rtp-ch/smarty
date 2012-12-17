<?php

########################################################################
# Extension Manager/Repository config file for ext "smarty".
#
# Auto generated 06-11-2011 11:20
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Smarty Templating Engine',
	'description' => 'A library for developers who want to use the Smarty templating engine for frontend extension templating. Includes Smarty and some custom Smarty tags for common TYPO3 functions.',
	'category' => 'misc',
	'shy' => 0,
	'version' => '1.12.1',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => 'typo3temp/smarty_cache,typo3temp/smarty_compile',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Simon Tuck',
	'author_email' => 'stu@rtp.ch',
	'author_company' => 'www.rtp.ch',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:202:{s:16:"ext_autoload.php";s:4:"29d4";s:21:"ext_conf_template.txt";s:4:"4c93";s:12:"ext_icon.gif";s:4:"f477";s:17:"ext_localconf.php";s:4:"ae9a";s:27:"ext_typoscript_contants.txt";s:4:"7aa7";s:24:"ext_typoscript_setup.txt";s:4:"ab1e";s:30:"Classes/Debug/smarty_debug.tpl";s:4:"b2a1";s:32:"Classes/Debug/upgrade_notice.gif";s:4:"77cf";s:28:"Classes/Hooks/ClearCache.php";s:4:"0ed4";s:33:"Classes/Wrapper/Configuration.php";s:4:"e7f4";s:27:"Classes/Wrapper/Factory.php";s:4:"db3e";s:27:"Classes/Wrapper/Utility.php";s:4:"e529";s:27:"Classes/Wrapper/Wrapper.php";s:4:"98b2";s:38:"Configuration/TypoScript/Constants.txt";s:4:"d41d";s:34:"Configuration/TypoScript/Setup.txt";s:4:"8609";s:23:"Documentation/ChangeLog";s:4:"8f2e";s:20:"Documentation/README";s:4:"ee2d";s:24:"Documentation/manual.sxw";s:4:"e270";s:23:"Documentation/readme.md";s:4:"7652";s:22:"Documentation/todo.txt";s:4:"d41d";s:27:"Documentation/variables.ods";s:4:"a67b";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"51cc";s:51:"Resources/Private/Plugins/Common/function.krumo.php";s:4:"3a6d";s:55:"Resources/Private/Plugins/Common/modifier.debug_var.php";s:4:"906f";s:59:"Resources/Private/Plugins/Common/modifier.gmdate_format.php";s:4:"79f6";s:59:"Resources/Private/Plugins/Common/modifier.number_format.php";s:4:"76f5";s:57:"Resources/Private/Plugins/Common/prefilter.conditions.php";s:4:"46ab";s:51:"Resources/Private/Plugins/Common/prefilter.dots.php";s:4:"9f42";s:50:"Resources/Private/Plugins/Common/resource.path.php";s:4:"621b";s:52:"Resources/Private/Plugins/Common/resource.string.php";s:4:"48aa";s:48:"Resources/Private/Plugins/Frontend/block.LLL.php";s:4:"e9ea";s:51:"Resources/Private/Plugins/Frontend/block.format.php";s:4:"912a";s:50:"Resources/Private/Plugins/Frontend/block.getLL.php";s:4:"0579";s:51:"Resources/Private/Plugins/Frontend/block.header.php";s:4:"d0fc";s:55:"Resources/Private/Plugins/Frontend/block.headerData.php";s:4:"ae4a";s:49:"Resources/Private/Plugins/Frontend/block.hide.php";s:4:"4289";s:49:"Resources/Private/Plugins/Frontend/block.link.php";s:4:"80c1";s:53:"Resources/Private/Plugins/Frontend/block.nl2space.php";s:4:"778e";s:54:"Resources/Private/Plugins/Frontend/block.plaintext.php";s:4:"03de";s:51:"Resources/Private/Plugins/Frontend/block.substr.php";s:4:"0a58";s:54:"Resources/Private/Plugins/Frontend/block.translate.php";s:4:"5a36";s:53:"Resources/Private/Plugins/Frontend/block.typolink.php";s:4:"d115";s:55:"Resources/Private/Plugins/Frontend/block.typoscript.php";s:4:"8d49";s:52:"Resources/Private/Plugins/Frontend/function.data.php";s:4:"0d4a";s:56:"Resources/Private/Plugins/Frontend/function.date2cal.php";s:4:"f45d";s:57:"Resources/Private/Plugins/Frontend/function.editIcons.php";s:4:"60c3";s:57:"Resources/Private/Plugins/Frontend/function.editPanel.php";s:4:"7de0";s:52:"Resources/Private/Plugins/Frontend/function.file.php";s:4:"0791";s:62:"Resources/Private/Plugins/Frontend/function.get_debug_info.php";s:4:"6c31";s:53:"Resources/Private/Plugins/Frontend/function.image.php";s:4:"54ce";s:60:"Resources/Private/Plugins/Frontend/function.img_resource.php";s:4:"f7f1";s:52:"Resources/Private/Plugins/Frontend/function.l10n.php";s:4:"9380";s:54:"Resources/Private/Plugins/Frontend/function.lookup.php";s:4:"fef7";s:58:"Resources/Private/Plugins/Frontend/function.multimedia.php";s:4:"6f28";s:54:"Resources/Private/Plugins/Frontend/function.object.php";s:4:"f326";s:50:"Resources/Private/Plugins/Frontend/function.sl.php";s:4:"9683";s:59:"Resources/Private/Plugins/Frontend/function.typolinkURL.php";s:4:"f936";s:65:"Resources/Private/Plugins/Frontend/function.typoscript_object.php";s:4:"286d";s:51:"Resources/Private/Plugins/Frontend/function.url.php";s:4:"da8d";s:53:"Resources/Private/Plugins/Frontend/modifier.br2nl.php";s:4:"7836";s:54:"Resources/Private/Plugins/Frontend/modifier.format.php";s:4:"8f62";s:40:"Tests/Unit/Wrapper/ConfigurationTest.php";s:4:"c87d";s:37:"Vendor/Html2Text/_class.html2text.php";s:4:"4296";s:36:"Vendor/Html2Text/class.html2text.php";s:4:"dcd3";s:39:"Vendor/Html2Text/class.ux_html2text.php";s:4:"7d82";s:20:"Vendor/Krumo/INSTALL";s:4:"f412";s:20:"Vendor/Krumo/LICENSE";s:4:"ef93";s:19:"Vendor/Krumo/README";s:4:"81de";s:17:"Vendor/Krumo/TODO";s:4:"55f1";s:20:"Vendor/Krumo/VERSION";s:4:"f9b7";s:28:"Vendor/Krumo/class.krumo.php";s:4:"f011";s:22:"Vendor/Krumo/krumo.ini";s:4:"cbed";s:21:"Vendor/Krumo/krumo.js";s:4:"6a23";s:30:"Vendor/Krumo/skins/blue/bg.gif";s:4:"0571";s:32:"Vendor/Krumo/skins/blue/skin.css";s:4:"5bc3";s:33:"Vendor/Krumo/skins/default/bg.gif";s:4:"4b6d";s:35:"Vendor/Krumo/skins/default/skin.css";s:4:"8095";s:31:"Vendor/Krumo/skins/green/bg.gif";s:4:"3a4d";s:33:"Vendor/Krumo/skins/green/skin.css";s:4:"ce65";s:32:"Vendor/Krumo/skins/orange/bg.gif";s:4:"3f82";s:34:"Vendor/Krumo/skins/orange/skin.css";s:4:"2506";s:34:"Vendor/Krumo/skins/rtp.ch/skin.css";s:4:"00b2";s:30:"Vendor/Smarty/Smarty.class.php";s:4:"06cd";s:32:"Vendor/Smarty/SmartyBC.class.php";s:4:"5734";s:23:"Vendor/Smarty/debug.tpl";s:4:"98a9";s:42:"Vendor/Smarty/plugins/block.textformat.php";s:4:"f19d";s:42:"Vendor/Smarty/plugins/function.counter.php";s:4:"95d9";s:40:"Vendor/Smarty/plugins/function.cycle.php";s:4:"bf71";s:40:"Vendor/Smarty/plugins/function.fetch.php";s:4:"bfe9";s:50:"Vendor/Smarty/plugins/function.html_checkboxes.php";s:4:"1f56";s:45:"Vendor/Smarty/plugins/function.html_image.php";s:4:"e039";s:47:"Vendor/Smarty/plugins/function.html_options.php";s:4:"76b5";s:46:"Vendor/Smarty/plugins/function.html_radios.php";s:4:"2a7d";s:51:"Vendor/Smarty/plugins/function.html_select_date.php";s:4:"1bfb";s:51:"Vendor/Smarty/plugins/function.html_select_time.php";s:4:"f64c";s:45:"Vendor/Smarty/plugins/function.html_table.php";s:4:"1724";s:41:"Vendor/Smarty/plugins/function.mailto.php";s:4:"b200";s:39:"Vendor/Smarty/plugins/function.math.php";s:4:"0b89";s:45:"Vendor/Smarty/plugins/modifier.capitalize.php";s:4:"e814";s:46:"Vendor/Smarty/plugins/modifier.date_format.php";s:4:"ab5c";s:50:"Vendor/Smarty/plugins/modifier.debug_print_var.php";s:4:"dccc";s:41:"Vendor/Smarty/plugins/modifier.escape.php";s:4:"3eba";s:48:"Vendor/Smarty/plugins/modifier.regex_replace.php";s:4:"21bb";s:42:"Vendor/Smarty/plugins/modifier.replace.php";s:4:"7cb4";s:42:"Vendor/Smarty/plugins/modifier.spacify.php";s:4:"0f2e";s:43:"Vendor/Smarty/plugins/modifier.truncate.php";s:4:"759d";s:46:"Vendor/Smarty/plugins/modifiercompiler.cat.php";s:4:"ea24";s:59:"Vendor/Smarty/plugins/modifiercompiler.count_characters.php";s:4:"b8e2";s:59:"Vendor/Smarty/plugins/modifiercompiler.count_paragraphs.php";s:4:"bd26";s:58:"Vendor/Smarty/plugins/modifiercompiler.count_sentences.php";s:4:"cca8";s:54:"Vendor/Smarty/plugins/modifiercompiler.count_words.php";s:4:"73ad";s:50:"Vendor/Smarty/plugins/modifiercompiler.default.php";s:4:"d72b";s:49:"Vendor/Smarty/plugins/modifiercompiler.escape.php";s:4:"bc49";s:55:"Vendor/Smarty/plugins/modifiercompiler.from_charset.php";s:4:"219f";s:49:"Vendor/Smarty/plugins/modifiercompiler.indent.php";s:4:"f329";s:48:"Vendor/Smarty/plugins/modifiercompiler.lower.php";s:4:"b9e5";s:50:"Vendor/Smarty/plugins/modifiercompiler.noprint.php";s:4:"3345";s:56:"Vendor/Smarty/plugins/modifiercompiler.string_format.php";s:4:"f610";s:48:"Vendor/Smarty/plugins/modifiercompiler.strip.php";s:4:"fdb2";s:53:"Vendor/Smarty/plugins/modifiercompiler.strip_tags.php";s:4:"bdf3";s:53:"Vendor/Smarty/plugins/modifiercompiler.to_charset.php";s:4:"4583";s:51:"Vendor/Smarty/plugins/modifiercompiler.unescape.php";s:4:"b506";s:48:"Vendor/Smarty/plugins/modifiercompiler.upper.php";s:4:"8811";s:51:"Vendor/Smarty/plugins/modifiercompiler.wordwrap.php";s:4:"4866";s:53:"Vendor/Smarty/plugins/outputfilter.trimwhitespace.php";s:4:"09b7";s:53:"Vendor/Smarty/plugins/shared.escape_special_chars.php";s:4:"8724";s:55:"Vendor/Smarty/plugins/shared.literal_compiler_param.php";s:4:"5591";s:47:"Vendor/Smarty/plugins/shared.make_timestamp.php";s:4:"c340";s:47:"Vendor/Smarty/plugins/shared.mb_str_replace.php";s:4:"00ad";s:43:"Vendor/Smarty/plugins/shared.mb_unicode.php";s:4:"1b0c";s:44:"Vendor/Smarty/plugins/shared.mb_wordwrap.php";s:4:"243e";s:57:"Vendor/Smarty/plugins/variablefilter.htmlspecialchars.php";s:4:"2777";s:49:"Vendor/Smarty/sysplugins/smarty_cacheresource.php";s:4:"63d7";s:56:"Vendor/Smarty/sysplugins/smarty_cacheresource_custom.php";s:4:"6f3e";s:63:"Vendor/Smarty/sysplugins/smarty_cacheresource_keyvaluestore.php";s:4:"6037";s:49:"Vendor/Smarty/sysplugins/smarty_config_source.php";s:4:"ffab";s:63:"Vendor/Smarty/sysplugins/smarty_internal_cacheresource_file.php";s:4:"d64e";s:59:"Vendor/Smarty/sysplugins/smarty_internal_compile_append.php";s:4:"fd71";s:59:"Vendor/Smarty/sysplugins/smarty_internal_compile_assign.php";s:4:"9eb2";s:58:"Vendor/Smarty/sysplugins/smarty_internal_compile_block.php";s:4:"23d3";s:58:"Vendor/Smarty/sysplugins/smarty_internal_compile_break.php";s:4:"4670";s:57:"Vendor/Smarty/sysplugins/smarty_internal_compile_call.php";s:4:"a8ca";s:60:"Vendor/Smarty/sysplugins/smarty_internal_compile_capture.php";s:4:"bbb4";s:64:"Vendor/Smarty/sysplugins/smarty_internal_compile_config_load.php";s:4:"1e82";s:61:"Vendor/Smarty/sysplugins/smarty_internal_compile_continue.php";s:4:"6e40";s:58:"Vendor/Smarty/sysplugins/smarty_internal_compile_debug.php";s:4:"9d9d";s:57:"Vendor/Smarty/sysplugins/smarty_internal_compile_eval.php";s:4:"bd94";s:60:"Vendor/Smarty/sysplugins/smarty_internal_compile_extends.php";s:4:"ac71";s:56:"Vendor/Smarty/sysplugins/smarty_internal_compile_for.php";s:4:"e3d5";s:60:"Vendor/Smarty/sysplugins/smarty_internal_compile_foreach.php";s:4:"559a";s:61:"Vendor/Smarty/sysplugins/smarty_internal_compile_function.php";s:4:"a084";s:55:"Vendor/Smarty/sysplugins/smarty_internal_compile_if.php";s:4:"0a29";s:60:"Vendor/Smarty/sysplugins/smarty_internal_compile_include.php";s:4:"f6b0";s:64:"Vendor/Smarty/sysplugins/smarty_internal_compile_include_php.php";s:4:"50a8";s:59:"Vendor/Smarty/sysplugins/smarty_internal_compile_insert.php";s:4:"b4da";s:59:"Vendor/Smarty/sysplugins/smarty_internal_compile_ldelim.php";s:4:"b60c";s:60:"Vendor/Smarty/sysplugins/smarty_internal_compile_nocache.php";s:4:"69a4";s:73:"Vendor/Smarty/sysplugins/smarty_internal_compile_private_block_plugin.php";s:4:"7901";s:76:"Vendor/Smarty/sysplugins/smarty_internal_compile_private_function_plugin.php";s:4:"ebac";s:69:"Vendor/Smarty/sysplugins/smarty_internal_compile_private_modifier.php";s:4:"ce4d";s:82:"Vendor/Smarty/sysplugins/smarty_internal_compile_private_object_block_function.php";s:4:"54bb";s:76:"Vendor/Smarty/sysplugins/smarty_internal_compile_private_object_function.php";s:4:"8fd6";s:77:"Vendor/Smarty/sysplugins/smarty_internal_compile_private_print_expression.php";s:4:"c134";s:77:"Vendor/Smarty/sysplugins/smarty_internal_compile_private_registered_block.php";s:4:"79fd";s:80:"Vendor/Smarty/sysplugins/smarty_internal_compile_private_registered_function.php";s:4:"e1b5";s:77:"Vendor/Smarty/sysplugins/smarty_internal_compile_private_special_variable.php";s:4:"06bf";s:59:"Vendor/Smarty/sysplugins/smarty_internal_compile_rdelim.php";s:4:"e0ad";s:60:"Vendor/Smarty/sysplugins/smarty_internal_compile_section.php";s:4:"f52e";s:62:"Vendor/Smarty/sysplugins/smarty_internal_compile_setfilter.php";s:4:"7187";s:58:"Vendor/Smarty/sysplugins/smarty_internal_compile_while.php";s:4:"db77";s:56:"Vendor/Smarty/sysplugins/smarty_internal_compilebase.php";s:4:"3d70";s:51:"Vendor/Smarty/sysplugins/smarty_internal_config.php";s:4:"2b1d";s:65:"Vendor/Smarty/sysplugins/smarty_internal_config_file_compiler.php";s:4:"ed64";s:60:"Vendor/Smarty/sysplugins/smarty_internal_configfilelexer.php";s:4:"a35c";s:61:"Vendor/Smarty/sysplugins/smarty_internal_configfileparser.php";s:4:"96c8";s:49:"Vendor/Smarty/sysplugins/smarty_internal_data.php";s:4:"0be3";s:50:"Vendor/Smarty/sysplugins/smarty_internal_debug.php";s:4:"95fb";s:59:"Vendor/Smarty/sysplugins/smarty_internal_filter_handler.php";s:4:"0f82";s:66:"Vendor/Smarty/sysplugins/smarty_internal_function_call_handler.php";s:4:"be46";s:61:"Vendor/Smarty/sysplugins/smarty_internal_get_include_path.php";s:4:"2241";s:59:"Vendor/Smarty/sysplugins/smarty_internal_nocache_insert.php";s:4:"33c6";s:54:"Vendor/Smarty/sysplugins/smarty_internal_parsetree.php";s:4:"bd56";s:58:"Vendor/Smarty/sysplugins/smarty_internal_resource_eval.php";s:4:"67aa";s:61:"Vendor/Smarty/sysplugins/smarty_internal_resource_extends.php";s:4:"5838";s:58:"Vendor/Smarty/sysplugins/smarty_internal_resource_file.php";s:4:"e19b";s:57:"Vendor/Smarty/sysplugins/smarty_internal_resource_php.php";s:4:"d719";s:64:"Vendor/Smarty/sysplugins/smarty_internal_resource_registered.php";s:4:"6b83";s:60:"Vendor/Smarty/sysplugins/smarty_internal_resource_stream.php";s:4:"6baa";s:60:"Vendor/Smarty/sysplugins/smarty_internal_resource_string.php";s:4:"d262";s:67:"Vendor/Smarty/sysplugins/smarty_internal_smartytemplatecompiler.php";s:4:"3e20";s:53:"Vendor/Smarty/sysplugins/smarty_internal_template.php";s:4:"b098";s:57:"Vendor/Smarty/sysplugins/smarty_internal_templatebase.php";s:4:"2b77";s:65:"Vendor/Smarty/sysplugins/smarty_internal_templatecompilerbase.php";s:4:"0d8f";s:58:"Vendor/Smarty/sysplugins/smarty_internal_templatelexer.php";s:4:"e4c1";s:59:"Vendor/Smarty/sysplugins/smarty_internal_templateparser.php";s:4:"ab83";s:52:"Vendor/Smarty/sysplugins/smarty_internal_utility.php";s:4:"2dc8";s:55:"Vendor/Smarty/sysplugins/smarty_internal_write_file.php";s:4:"612c";s:44:"Vendor/Smarty/sysplugins/smarty_resource.php";s:4:"74f6";s:51:"Vendor/Smarty/sysplugins/smarty_resource_custom.php";s:4:"8317";s:55:"Vendor/Smarty/sysplugins/smarty_resource_recompiled.php";s:4:"8ad5";s:55:"Vendor/Smarty/sysplugins/smarty_resource_uncompiled.php";s:4:"8112";s:44:"Vendor/Smarty/sysplugins/smarty_security.php";s:4:"5127";}',
	'suggests' => array(
	),
);

?>
