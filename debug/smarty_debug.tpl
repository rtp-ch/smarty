{*
	Smarty Debug Template
	copyright 	2007 Rueegg Tuck Partner GmbH
	author 		Simon Tuck <stu@rtpartner.ch>
	link 		http://www.rtpartner.ch/
	package 	smarty
	version 	1.2
*}
{if !$debug_output}
{get_debug_info}
{capture assign=debug_output}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title>{$_debug_resource.basename}</title>
{literal}
<style type="text/css">
<!--
* { margin: 0; padding: 0; text-decoration: none; font-size: 1em; outline: none; }
code, kbd, samp, pre, tt, var, textarea, input, select, isindex { font: inherit; font-size: 1em; }
dfn, i, cite, var, address, em { font-style: normal; }
th, b, strong, h1, h2, h3, h4, h5, h6 { font-weight: normal; }
a, img, a img, iframe, form, fieldset, abbr, acronym, object, applet { border: none; }
table { border-collapse: separate; border-spacing: 2px; }
caption, th, td, center { text-align: left; vertical-align: top; }
body { line-height: 1; background: white; color: black; }
q { quotes: "" ""; }
ul, ol, dir, menu { list-style: none; }
sub, sup { vertical-align: baseline; }
a { color: inherit; }
hr { display: none; }
font { color: inherit !important; font: inherit !important; color: inherit !important; }
html { font-size: 75%; line-height: 1em; font-weight: normal; font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", Lucida, Verdana, sans-serif; }
caption, th, td, center { padding: 3px; margin: 3px; }
h1 { font-size: 1.2em; line-height: 1.4em; color: #ffffff; font-weight: bold; background-color: #66a552; }
h2 { font-size: 1.2em; line-height: 1.4em; color: #ffffff; font-weight: bold; background-color: #ff9f33; }
h3 { font-size: 1em; line-height: 1.2em; color: #66a552; text-decoration: none; margin-top: .5em; font-weight: bold; }
h6 { font-size: 1em; }
.highlight { font-style: italic; color: #ff9f33; }
.small { font-size: .8em; font-weight: normal; }
-->
</style>
{/literal}
</head>
<body>
<h1>{$_debug_resource.basename} <span class="small">{$_debug_resource.dirname}</span></h1>
<h2>{$_debug_t3_ext_vars.extKey} <span class="small">{$_debug_t3_ext_vars.extPath}</span></h2>
<div id="assigned_vars">
<h3>Assigned Template Variables</h3>
{if $_assigned_vars}
	{$_assigned_vars|@debug_var:"":false:'$smarty->_tpl_vars'}
{else}
	<p><span class="highlight">No assigned template variables.</span></p>
{/if}
</div>
<div id="t3_config_vars">
<h3>Assigned Smarty Class Variables from TypoScript</h3>
{$_debug_resource.smartyClassVars|@debug_var:"":true:"Smarty Class Variables"}
</div>
<div id="config_vars">
<h3>Assigned Config File Variables (Outside of Template Scope)</h3>
{if $_debug_config_vars}
	{$_debug_config_vars|@debug_var:"":true:'$smarty->_config[0]'}
{else}
	<p><span class="highlight">No assigned config file variables</span></p>
{/if}
</div>
<div id="templates">
<h3>Included Templates &amp; Config Files (Load Time in Seconds)</h3>
{if $_debug_tpls}
	{$_debug_tpls|@debug_var:"":false:'$smarty->_smarty_debug_info'}
{else}
	<p><span class="highlight">No templates included</span></p>
{/if}
</div>
</body>
</html>
{/capture}
{header}
<script type="text/javascript">
// <![CDATA[
    _smarty_console = window.open("","{$_debug_resource.basename}","width=680,height=600,resizable,scrollbars=yes");
    _smarty_console.document.write('{$debug_output|escape:'javascript'}');
    _smarty_console.document.close();
// ]]>
</script>
{/header}
{/if}
