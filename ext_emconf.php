<?php

########################################################################
# Extension Manager/Repository config file for ext: "smarty"
#
# Auto generated 06-09-2009 11:15
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Smarty Templating Engine',
	'description' => 'A library for extension developers who want to use the Smarty templating engine for extension templates. Includes Smarty (2.6.19) and some custom Smarty tags for common TYPO3 functions, for example, {translate} (a Smarty tag for localization), {link} (a Smarty tag to create typolinks), etc.',
	'category' => 'misc',
	'shy' => 0,
	'version' => '1.7.3',
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
	'author_email' => 'stu@rtpartner.ch',
	'author_company' => 'Rueegg Tuck Partner',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:143:{s:9:"ChangeLog";s:4:"e778";s:6:"README";s:4:"ee2d";s:19:"class.tx_smarty.php";s:4:"573e";s:23:"class.tx_smarty_div.php";s:4:"bbc0";s:27:"class.tx_smarty_wrapper.php";s:4:"64c7";s:21:"ext_conf_template.txt";s:4:"6a40";s:12:"ext_icon.gif";s:4:"f477";s:17:"ext_localconf.php";s:4:"8d41";s:24:"ext_typoscript_setup.txt";s:4:"76da";s:8:"todo.txt";s:4:"d41d";s:22:"debug/smarty_debug.tpl";s:4:"d0e2";s:24:"debug/upgrade_notice.gif";s:4:"77cf";s:14:"doc/manual.sxw";s:4:"e270";s:28:"lib/SmartyPaginate.class.php";s:4:"0012";s:23:"lib/class.html2text.php";s:4:"4296";s:26:"lib/class.ux_html2text.php";s:4:"5b95";s:34:"lib/class.ux_tx_lib_smartyView.php";s:4:"082f";s:12:"lib/dBug.php";s:4:"b6cb";s:11:"Smarty/BUGS";s:4:"fd67";s:18:"Smarty/COPYING.lib";s:4:"68ad";s:16:"Smarty/ChangeLog";s:4:"0b20";s:10:"Smarty/FAQ";s:4:"7f0e";s:14:"Smarty/INSTALL";s:4:"26e2";s:11:"Smarty/NEWS";s:4:"699c";s:18:"Smarty/QUICK_START";s:4:"e9e7";s:13:"Smarty/README";s:4:"f5c5";s:20:"Smarty/RELEASE_NOTES";s:4:"d664";s:11:"Smarty/TODO";s:4:"7e8a";s:21:"Smarty/demo/index.php";s:4:"2e48";s:29:"Smarty/demo/configs/test.conf";s:4:"2f99";s:32:"Smarty/demo/templates/footer.tpl";s:4:"c1fc";s:32:"Smarty/demo/templates/header.tpl";s:4:"78ba";s:31:"Smarty/demo/templates/index.tpl";s:4:"a72e";s:33:"Smarty/libs/Config_File.class.php";s:4:"8005";s:28:"Smarty/libs/Smarty.class.php";s:4:"4f28";s:37:"Smarty/libs/Smarty_Compiler.class.php";s:4:"79d2";s:21:"Smarty/libs/debug.tpl";s:4:"def6";s:55:"Smarty/libs/internals/core.assemble_plugin_filepath.php";s:4:"c988";s:54:"Smarty/libs/internals/core.assign_smarty_interface.php";s:4:"4c2d";s:51:"Smarty/libs/internals/core.create_dir_structure.php";s:4:"a12f";s:52:"Smarty/libs/internals/core.display_debug_console.php";s:4:"297b";s:47:"Smarty/libs/internals/core.get_include_path.php";s:4:"ba78";s:44:"Smarty/libs/internals/core.get_microtime.php";s:4:"72eb";s:47:"Smarty/libs/internals/core.get_php_resource.php";s:4:"e0fc";s:40:"Smarty/libs/internals/core.is_secure.php";s:4:"7ea8";s:41:"Smarty/libs/internals/core.is_trusted.php";s:4:"83e2";s:43:"Smarty/libs/internals/core.load_plugins.php";s:4:"d600";s:51:"Smarty/libs/internals/core.load_resource_plugin.php";s:4:"08d5";s:53:"Smarty/libs/internals/core.process_cached_inserts.php";s:4:"2a84";s:55:"Smarty/libs/internals/core.process_compiled_include.php";s:4:"95e1";s:46:"Smarty/libs/internals/core.read_cache_file.php";s:4:"e7de";s:38:"Smarty/libs/internals/core.rm_auto.php";s:4:"8834";s:36:"Smarty/libs/internals/core.rmdir.php";s:4:"0820";s:49:"Smarty/libs/internals/core.run_insert_handler.php";s:4:"f645";s:49:"Smarty/libs/internals/core.smarty_include_php.php";s:4:"0d87";s:47:"Smarty/libs/internals/core.write_cache_file.php";s:4:"a000";s:53:"Smarty/libs/internals/core.write_compiled_include.php";s:4:"ff79";s:54:"Smarty/libs/internals/core.write_compiled_resource.php";s:4:"caa7";s:41:"Smarty/libs/internals/core.write_file.php";s:4:"23f9";s:40:"Smarty/libs/plugins/block.textformat.php";s:4:"f4e1";s:39:"Smarty/libs/plugins/compiler.assign.php";s:4:"b4f1";s:50:"Smarty/libs/plugins/function.assign_debug_info.php";s:4:"0abd";s:44:"Smarty/libs/plugins/function.config_load.php";s:4:"fa64";s:40:"Smarty/libs/plugins/function.counter.php";s:4:"9531";s:38:"Smarty/libs/plugins/function.cycle.php";s:4:"db7b";s:38:"Smarty/libs/plugins/function.debug.php";s:4:"4963";s:37:"Smarty/libs/plugins/function.eval.php";s:4:"3fed";s:38:"Smarty/libs/plugins/function.fetch.php";s:4:"5125";s:48:"Smarty/libs/plugins/function.html_checkboxes.php";s:4:"a054";s:43:"Smarty/libs/plugins/function.html_image.php";s:4:"de11";s:45:"Smarty/libs/plugins/function.html_options.php";s:4:"b634";s:44:"Smarty/libs/plugins/function.html_radios.php";s:4:"6a00";s:49:"Smarty/libs/plugins/function.html_select_date.php";s:4:"ad1d";s:49:"Smarty/libs/plugins/function.html_select_time.php";s:4:"ac7c";s:43:"Smarty/libs/plugins/function.html_table.php";s:4:"d7ad";s:39:"Smarty/libs/plugins/function.mailto.php";s:4:"03b5";s:37:"Smarty/libs/plugins/function.math.php";s:4:"6cfa";s:38:"Smarty/libs/plugins/function.popup.php";s:4:"1e8b";s:43:"Smarty/libs/plugins/function.popup_init.php";s:4:"b235";s:43:"Smarty/libs/plugins/modifier.capitalize.php";s:4:"70f5";s:36:"Smarty/libs/plugins/modifier.cat.php";s:4:"9dbc";s:49:"Smarty/libs/plugins/modifier.count_characters.php";s:4:"9169";s:49:"Smarty/libs/plugins/modifier.count_paragraphs.php";s:4:"c64e";s:48:"Smarty/libs/plugins/modifier.count_sentences.php";s:4:"c22e";s:44:"Smarty/libs/plugins/modifier.count_words.php";s:4:"0734";s:44:"Smarty/libs/plugins/modifier.date_format.php";s:4:"5d57";s:48:"Smarty/libs/plugins/modifier.debug_print_var.php";s:4:"0839";s:40:"Smarty/libs/plugins/modifier.default.php";s:4:"11c1";s:39:"Smarty/libs/plugins/modifier.escape.php";s:4:"3bd0";s:39:"Smarty/libs/plugins/modifier.indent.php";s:4:"ea1f";s:38:"Smarty/libs/plugins/modifier.lower.php";s:4:"5520";s:38:"Smarty/libs/plugins/modifier.nl2br.php";s:4:"1d16";s:46:"Smarty/libs/plugins/modifier.regex_replace.php";s:4:"f3ae";s:40:"Smarty/libs/plugins/modifier.replace.php";s:4:"b7d1";s:40:"Smarty/libs/plugins/modifier.spacify.php";s:4:"6699";s:46:"Smarty/libs/plugins/modifier.string_format.php";s:4:"4010";s:38:"Smarty/libs/plugins/modifier.strip.php";s:4:"b128";s:43:"Smarty/libs/plugins/modifier.strip_tags.php";s:4:"4811";s:41:"Smarty/libs/plugins/modifier.truncate.php";s:4:"da35";s:38:"Smarty/libs/plugins/modifier.upper.php";s:4:"0ef0";s:41:"Smarty/libs/plugins/modifier.wordwrap.php";s:4:"b80b";s:51:"Smarty/libs/plugins/outputfilter.trimwhitespace.php";s:4:"ac1d";s:51:"Smarty/libs/plugins/shared.escape_special_chars.php";s:4:"2f72";s:45:"Smarty/libs/plugins/shared.make_timestamp.php";s:4:"29ff";s:27:"typo3_plugins/block.LLL.php";s:4:"e9ea";s:30:"typo3_plugins/block.format.php";s:4:"912a";s:29:"typo3_plugins/block.getLL.php";s:4:"0579";s:30:"typo3_plugins/block.header.php";s:4:"d0fc";s:34:"typo3_plugins/block.headerData.php";s:4:"ae4a";s:28:"typo3_plugins/block.hide.php";s:4:"4289";s:28:"typo3_plugins/block.link.php";s:4:"80c1";s:32:"typo3_plugins/block.nl2space.php";s:4:"778e";s:33:"typo3_plugins/block.plaintext.php";s:4:"03de";s:30:"typo3_plugins/block.substr.php";s:4:"0a58";s:33:"typo3_plugins/block.translate.php";s:4:"5a36";s:32:"typo3_plugins/block.typolink.php";s:4:"a166";s:34:"typo3_plugins/block.typoscript.php";s:4:"8d49";s:31:"typo3_plugins/function.data.php";s:4:"0d4a";s:35:"typo3_plugins/function.date2cal.php";s:4:"f45d";s:36:"typo3_plugins/function.editIcons.php";s:4:"60c3";s:36:"typo3_plugins/function.editPanel.php";s:4:"7de0";s:31:"typo3_plugins/function.file.php";s:4:"0791";s:41:"typo3_plugins/function.get_debug_info.php";s:4:"d57c";s:32:"typo3_plugins/function.image.php";s:4:"54ce";s:31:"typo3_plugins/function.l10n.php";s:4:"9380";s:33:"typo3_plugins/function.lookup.php";s:4:"f781";s:37:"typo3_plugins/function.multimedia.php";s:4:"6f28";s:33:"typo3_plugins/function.object.php";s:4:"f326";s:41:"typo3_plugins/function.paginate_first.php";s:4:"ade0";s:40:"typo3_plugins/function.paginate_last.php";s:4:"0d00";s:42:"typo3_plugins/function.paginate_middle.php";s:4:"1b6a";s:40:"typo3_plugins/function.paginate_next.php";s:4:"619c";s:40:"typo3_plugins/function.paginate_prev.php";s:4:"8522";s:29:"typo3_plugins/function.sl.php";s:4:"9683";s:38:"typo3_plugins/function.typolinkURL.php";s:4:"f936";s:44:"typo3_plugins/function.typoscript_object.php";s:4:"286d";s:30:"typo3_plugins/function.url.php";s:4:"da8d";s:36:"typo3_plugins/modifier.debug_var.php";s:4:"0cc8";s:33:"typo3_plugins/modifier.format.php";s:4:"8f62";s:38:"typo3_plugins/prefilter.conditions.php";s:4:"46ab";s:32:"typo3_plugins/prefilter.dots.php";s:4:"9f42";s:31:"typo3_plugins/resource.path.php";s:4:"621b";s:33:"typo3_plugins/resource.string.php";s:4:"48aa";}',
	'suggests' => array(
	),
);

?>