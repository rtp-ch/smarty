<?php

/**
 *
 * Smarty resource "string"
 * -------------------------------------------------------------
 * get a concrete filename for automagically created content
 * Modifies the function _get_auto_filename to enable using strings as
 * smarty resources (http://smarty.incutio.com/?page=resource_string)
 *
 * File:    resource.string.php
 * Type:    resource
 * Name:    string
 * Version: 1.1
 * Author:  Joshua Thijssen <jthijssen@noxlogic.nl>
 * Purpose:	Use a string as a smarty resource
 * Example: $smarty->display('string:<em>Hello {$name}</em>, How are you?');
 * -------------------------------------------------------------
 *
 **/


	function smarty_resource_string_source ($tpl_name, &$tpl_source, &$smarty_obj) {
	  $tpl_source = $tpl_name;
	  return TRUE;
	}

	function smarty_resource_string_timestamp($tpl_name, &$tpl_timestamp, &$smarty_obj) {
	  $tpl_timestamp = time();
	  return TRUE;
	}

	function smarty_resource_string_secure($tpl_name, &$smarty_obj) {
	  // Assume all templates are secure
	  return TRUE;
	}

	function smarty_resource_string_trusted($tpl_name, &$smarty_obj) {
	  // not used for templates
	}

	// register the resource name 'string'
	$smarty->register_resource('string', array('smarty_resource_string_source','smarty_resource_string_timestamp','smarty_resource_string_secure','smarty_resource_string_trusted'));

?>