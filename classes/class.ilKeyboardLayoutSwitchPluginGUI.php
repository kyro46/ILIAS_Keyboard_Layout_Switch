<?php

include_once("./Services/COPage/classes/class.ilPageComponentPluginGUI.php");
 
/**
 * Keyboard Layout Switch
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
				if (in_array($cmd, array("create", "save", "edit", "update", "cancel")))
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
	 * Save new keyboard layout switch element
	 */
	public function create()
	{
		global $tpl, $lng, $ilCtrl;
	
		$form = $this->initForm(true);
		if ($form->checkInput())
		{
			$properties = array(
				"keyboardLayoutId" => $form->getInput("keylay")	
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
				"keyboardLayoutId" => $form->getInput("keylay")
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
		$pl = $this->getPlugin();
		
		// keyboard selection
		$klId = new ilRadioGroupInputGUI($pl->txt("select_keyboard"), "keylay");
		$klId->addOption(new ilRadioOption($pl->txt("intl_ru_standard"), 0, ''));
		$klId->addOption(new ilRadioOption($pl->txt("ialt_ru"), 1, ''));
		$klId->addOption(new ilRadioOption($pl->txt("ialt_fr"), 2, ''));
		$klId->addOption(new ilRadioOption($pl->txt("ialt_es"), 3, ''));
		$klId->setRequired(true);
		$form->addItem($klId);		
		
		if (!$a_create)
		{
			$prop = $this->getProperties();

			$klId->setValue($prop["keyboardLayoutId"]);
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
		
		$tpl->setVariable("SYSTEM_LANG", $pl->txt("system_lang"));
		$tpl->setVariable("KEYLASWI_ID", rand());
				
		switch ($a_properties['keyboardLayoutId']) {
			case "0":
				$tpl->setVariable("KEYBOARDLAYOUT", "intl_ru_standard");
				$tpl->setVariable("LANGUAGE", $pl->txt("intl_ru_standard"));
				break;
			case "1":
				$tpl->setVariable("KEYBOARDLAYOUT", "ialt_ru");
				$tpl->setVariable("LANGUAGE", $pl->txt("ialt_ru"));
				
				break;
			case "2":
				$tpl->setVariable("KEYBOARDLAYOUT", "ialt_fr");
				$tpl->setVariable("LANGUAGE", $pl->txt("ialt_fr"));
				break;
			case "3":
				$tpl->setVariable("KEYBOARDLAYOUT", "ialt_es");
				$tpl->setVariable("LANGUAGE", $pl->txt("ialt_es"));
				break;				
		}
		
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

		$ilTabs->activateTab($a_active);
	}

}

?>
