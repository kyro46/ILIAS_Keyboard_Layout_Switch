ILIAS 4.4.+ KeyboardLayoutSwitch
===

PageComponentPlugin - Shows a predefinied keyboard layout (eg. russian) and switches the keyboardinput accordingly

* Students can select a predefined keyboard layout
* No need to enable languages locally inside the operationg system
* Easy switching between keyboards even inside special environments (e.g. SafeExamBrowser)

###Usage
Create a new Page Component for your testquestions, select the language

###Install
1. Copy the content under your ILIAS main directory at:
Customizing/global/plugins/Services/COPage/PageComponent/KeyboardLayoutSwitch

2. Open ILIAS > Administration > Plugins
Update/Activate the Plugin

###Inserting new/custom Keyboard Layouts
* Create a .json-file with the mapping (see existing files) inside ./mappings
* Create a xxx.help.html inside ./help with e.g. image or description
* Add the language variable in the ilias_XX.lang-file
* Add a new radio option in initForm() and a new switch-case in getElementHTML() in class.ilKeyboardLayoutSwitchPluginGUI.php

###Credits
* Mapping: IALT Leipzig, Martin Czygan et.al.: https://ialt.philol.uni-leipzig.de
* jquery-retype by Martin Czygan: https://github.com/miku/jquery-retype 