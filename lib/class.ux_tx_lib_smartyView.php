<?php

/**
 * A viewer class that is based on the extension 'rtp_smarty'.
 *
 * PHP versions 4 and 5
 *
 * Copyright (c) 2006-2007 Elmar Hinz
 *
 * LICENSE:
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package    TYPO3
 * @subpackage lib
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @copyright  2006-2007 Elmar Hinz
 * @license    http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @version    SVN: $Id: class.tx_lib_smartyView.php 7333 2007-11-30 12:21:48Z elmarhinz $
 * @since      0.1
 */

require_once(t3lib_extMgm::extPath('div') . 'class.tx_div.php');
require_once(t3lib_extMgm::extPath('lib') . 'class.tx_lib_phpTemplateEngine.php');
tx_div::load('tx_lib_object');

/**
 * A viewer class that is based on the extension 'rtp_smarty'.
 *
 * For initialisation call function init()
 *
 * To assign any variables for the template they are all stored in one masterArray.
 * If you want add a variable for the template add the variable to the masterArray
 * calling the function assignValue(pointer to the array, name of variable, value of variable, type of variable)
 *
 * Default extension of templates is 'tmpl', you can change it by function setTemplateExtension(), for example
 * tx_lib_smartyView::setTemplateExtension('html');
 *
 * To render the template just call the function render(templatename)
 *
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @package    TYPO3
 * @subpackage lib
 */
class ux_tx_lib_smartyView extends tx_lib_smartyView {

	/**
	 * Render the Smarty template and return the result as a string (typically html).
	 *
	 * @param	string		name of template file (e.g. myTemplate.tpl) or full path to template (e.g. full/path/to/myTemplate.tpl)
	 * @param 	array		Optional array of Smarty configuration variables, for example array('debugging' => true).
	 * @return	string		typically an (x)html string
	 */
	function render($template, $conf=array()) {
		if(!t3lib_extMgm::isLoaded('smarty')) return '<p class="warning">smarty is not available.</p>';
		$this->smarty = tx_smarty::smarty($conf);
		$this->smarty->assign($this->getArrayCopy());
		$this->smarty->assign_by_ref('view', $this);
		return $this->smarty->display($template);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/rtp_delicious/lib/class.ux_tx_lib_smartyView.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/rtp_delicious/lib/class.ux_tx_lib_smartyView.php']);
}

?>
