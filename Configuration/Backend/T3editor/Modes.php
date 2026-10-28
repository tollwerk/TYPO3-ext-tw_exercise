<?php

use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;

return [
    'markdown' => [
        'module' => JavaScriptModuleInstruction::create('@tollwerk/tw_exercise/t3editor/mode/lang-markdown.js', 'markdown')->invoke(),
        'extensions' => ['markdown'],
    ],
    'twexercise' => [
        'module' => JavaScriptModuleInstruction::create('@tollwerk/tw_exercise/t3editor/mode/lang-css-wrapped.js')->invoke(),
        'extensions' => ['twexercise'],
    ],
];
