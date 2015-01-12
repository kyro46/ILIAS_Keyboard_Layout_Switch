<?php

include_once("./Services/COPage/classes/class.ilPageComponentPluginGUI.php");
 
/**
 * Keyboard Layout Switcher ILIAS_Keyboard_Layout_Switch
 *
 * @author Christoph Jobst <christoph.jobst@llz.uni-halle.de>
 * @version $Id$
 * @ilCtrl_isCalledBy ilKeyboardLayoutSwitchPluginGUI: ilPCPluggedGUI
 */
class ilKeyboardLayoutSwitchPluginGUI extends ilPageComponentPluginGUI
{
	/**
	 * Execute command
	 *
	 * @param
	 * @return
	 */
	function executeCommand()
	{
		global $ilCtrl;
		
		$next_class = $ilCtrl->getNextClass();

		switch($next_class)
		{
			default:
				// perform valid commands
				$cmd = $ilCtrl->getCmd();
				if (in_array($cmd, array("create", "save", "edit", "edit2", "update", "cancel")))
				{
					$this->$cmd();
				}
				break;
		}
	}
	
	
	/**
	 * Create
	 *
	 * @param
	 * @return
	 */
	function insert()
	{
		global $tpl;
		
		$form = $this->initForm(true);
		$tpl->setContent($form->getHTML());
	}
	
	/**
	 * Save new pc example element
	 */
	public function create()
	{
		global $tpl, $lng, $ilCtrl;
	
		$form = $this->initForm(true);
		if ($form->checkInput())
		{
			$properties = array(
				"value_1" => $form->getInput("val1"),
				"value_2" => $form->getInput("val2")
				);
			if ($this->createElement($properties))
			{
				ilUtil::sendSuccess($lng->txt("msg_obj_modified"), true);
				$this->returnToParent();
			}
		}

		$form->setValuesByPost();
		$tpl->setContent($form->getHtml());
	}
	
	/**
	 * Edit
	 *
	 * @param
	 * @return
	 */
	function edit()
	{
		global $tpl;
		
		$this->setTabs("edit");
		
		$form = $this->initForm();
		$tpl->setContent($form->getHTML());		
	}
	
	/**
	 * Update
	 *
	 * @param
	 * @return
	 */
	function update()
	{
		global $tpl, $lng, $ilCtrl;
	
		$form = $this->initForm(true);
		if ($form->checkInput())
		{
			$properties = array(
				"value_1" => $form->getInput("val1"),
				"value_2" => $form->getInput("val2")
				);
			if ($this->updateElement($properties))
			{
				ilUtil::sendSuccess($lng->txt("msg_obj_modified"), true);
				$this->returnToParent();
			}
		}

		$form->setValuesByPost();
		$tpl->setContent($form->getHtml());

	}
	
	
	/**
	 * Init editing form
	 *
	 * @param        int        $a_mode        Edit Mode
	 */
	public function initForm($a_create = false)
	{
		global $lng, $ilCtrl;

		include_once("Services/Form/classes/class.ilPropertyFormGUI.php");
		$form = new ilPropertyFormGUI();

		// value one 
		$v1 = new ilTextInputGUI($this->getPlugin()->txt("value_1"), "val1");
		$v1->setMaxLength(40);
		$v1->setSize(40);
		$v1->setRequired(true);
		$form->addItem($v1);

		// value two 
		$v2 = new ilTextInputGUI($this->getPlugin()->txt("value_2"), "val2");
		$v2->setMaxLength(40);
		$v2->setSize(40);
		$form->addItem($v2);
		
		if (!$a_create)
		{
			$prop = $this->getProperties();
			$v1->setValue($prop["value_1"]);
			$v2->setValue($prop["value_2"]);
		}

		// save and cancel commands
		if ($a_create)
		{
			$this->addCreationButton($form);
			$form->addCommandButton("cancel", $lng->txt("cancel"));
			$form->setTitle($this->getPlugin()->txt("cmd_insert"));
		}
		else
		{
			$form->addCommandButton("update", $lng->txt("save"));
			$form->addCommandButton("cancel", $lng->txt("cancel"));
			$form->setTitle($this->getPlugin()->txt("edit_ex_el"));
		}
		
		$form->setFormAction($ilCtrl->getFormAction($this));
		
		return $form;
	}

	/**
	 * Cancel
	 */
	function cancel()
	{
		$this->returnToParent();
	}
	
	/**
	 * Get HTML for element
	 *
	 * @param string $a_mode (edit, presentation, preview, offline)s
	 * @return string $html
	 */
	function getElementHTML($a_mode, array $a_properties, $a_plugin_version)
	{
		$pl = $this->getPlugin();
		$tpl = $pl->getTemplate("tpl.content.html");
//var_dump($a_properties);
		foreach ($a_properties as $name => $value)
		{
			$tpl->setCurrentBlock("prop");
			$tpl->setVariable("TXT_PROP", $pl->txt("property"));
			$tpl->setVariable("PROP_NAME", $name);
			$tpl->setVariable("PROP_VAL", $value);
			$tpl->parseCurrentBlock();
		}
		$tpl->setVariable("TXT_VERSION", $pl->txt("content_plugin_version"));
		$tpl->setVariable("TXT_MODE", $pl->txt("mode"));
		$tpl->setVariable("VERSION", $a_plugin_version);
		$tpl->setVariable("MODE", $a_mode);
		
		return $tpl->get();
	}
	
	/**
	 * Set tabs
	 *
	 * @param
	 * @return
	 */
	function setTabs($a_active)
	{
		global $ilTabs, $ilCtrl;
		
		$pl = $this->getPlugin();
		
		$ilTabs->addTab("edit", $pl->txt("settings_1"),
			$ilCtrl->getLinkTarget($this, "edit"));

		$ilTabs->addTab("edit2", $pl->txt("settings_2"),
			$ilCtrl->getLinkTarget($this, "edit2"));
		
		$ilTabs->activateTab($a_active);
	}

	/**
	 * More settings editing
	 *
	 * @param
	 * @return
	 */
	function edit2()
	{
		global $tpl;
		
		$this->setTabs("edit2");
		
		ilUtil::sendInfo($this->getPlugin()->txt("more_editing"));
	}

}

?>
