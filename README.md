KeyboardLayoutSwitch
===

PageComponentPlugin for ILIAS 4.4 to 5.2, 5.4 and 7 (5.3 and 6 not tested)
It shows a predefinied keyboard layout (eg. russian) and switches the keyboardinput accordingly

* Students can select a predefined keyboard layout
* No need to enable languages locally inside the operationg system
* Easy switching between keyboards even inside special environments (e.g. SafeExamBrowser)

###Usage
Create a new Page Component for your testquestions, select the language.

###Install
Install the plugin

```bash
mkdir -p Customizing/global/plugins/Services/COPage/PageComponent  
cd Customizing/global/plugins/Services/COPage/PageComponent
git clone https://github.com/kyro46/KeyboardLayoutSwitch.git
```
and activate it in the ILIAS-Admin-GUI.

###Inserting new/custom Keyboard Layouts
* Create a .json-file with the mapping (see existing files) inside ./mappings
* Create a xxx.help.html inside ./help with e.g. image or description
* Add the language variable in the ilias_XX.lang-file
* Add a new radio option in initForm() and a new switch-case in getElementHTML() in class.ilKeyboardLayoutSwitchPluginGUI.php

###Credits
* Mapping: IALT Leipzig, Martin Czygan et.al.: https://ialt.philol.uni-leipzig.de
* jquery-retype by Martin Czygan: https://github.com/miku/jquery-retype 