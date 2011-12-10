<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006-2007 Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

class Tx_Smarty_Core_Builder
{
    public function &Get(array $options = array())
    {
        // Creates an instance of smarty
        $smartyInstance = t3lib_div::makeInstance('Tx_Smarty_Core_Wrapper');

        // Registers a reference to the calling class. Apparently "$this" is
        // accessible when referenced statically in a non-static context...
        $pObj = is_object($this) ? $this : new stdClass();
        $smartyInstance->setParentObject($pObj);

        // Gets the smarty configuration
        $setup = array();
        if(isset($smartyInstance->getParentObject()->prefixId)) {
            $prefixId = $smartyInstance->getParentObject()->prefixId;
            list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromTypo3('plugin.' . $prefixId . '.smarty');
        }
        $setup = t3lib_div::array_merge_recursive_overrule($setup, $options);
        $setup = Tx_Smarty_Utility_TypoScript::arrayStdWrap($setup);

        // Applies the smarty configuration
        foreach($setup as $key => $value) {
            $smartyInstance->set($key, $value);
        }

        return $smartyInstance;
    }
}
