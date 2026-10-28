<?php

use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;

return [
    'twexercise_cloze' => [
        'module' => JavaScriptModuleInstruction::create('@tollwerk/tw_exercise/t3editor/mode/lang-css-wrapped.js')->invoke(),
        'extensions' => ['twexercise'],
    ],
];
