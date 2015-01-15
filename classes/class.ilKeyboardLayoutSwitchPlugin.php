<?php

include_once("./Services/COPage/classes/class.ilPageComponentPlugin.php");
 
/**
 * Keyboard Layout Switcher ILIAS_Keyboard_Layout_Switch
 *
 * @author Christoph Jobst <christoph.jobst@llz.uni-halle.de>
 * @version $Id$
 *
 */
class ilKeyboardLayoutSwitchPlugin extends ilPageComponentPlugin
{
	/**
	 * Get plugin name 
	 *
	 * @return string
	 */
	function getPluginName()
	{
		return "KeyboardLayoutSwitch";
	}
	
	
	/**
	 * Get plugin name 
	 *
	 * @return string
	 */
	function isValidParentType($a_parent_type)
	{
		if (in_array($a_parent_type, array("qpl", "qht")))
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Get Javascript files
	 */
	function getJavascriptFiles()
	{
		return array("js/jquery.fieldselection.min.js", "js/jquery.retype.min.js");
	}
	
	/**
	 * Get css files
	 */
	function getCssFiles()
	{
		return array();
	}

}

?>
