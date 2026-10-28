<?php

declare(strict_types=1);

return [
    'dependencies' => ['backend'],
    'tags' => [
        'backend.form',
    ],
    'imports' => [
        '@tollwerk/tw_exercise/t3editor/mode/lang-css-wrapped.js' => 'EXT:tw_exercise/Resources/Public/JavaScript/T3Editor/Mode/lang-css-wrapped.js',
    ],
];
