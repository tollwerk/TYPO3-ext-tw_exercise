<?php

declare(strict_types=1);

defined('TYPO3') or die();

// Add new columns.
$newColumns = [
    'tx_twexercise_points' => [
        'exclude' => false,
        'l10n_mode' => 'exclude',
        'label' => 'LLL:EXT:tw_exercise/Resources/Private/Language/locallang_db.xlf:tt_content.tx_twexercise_points',
        'config' => [
            'type' => 'number',
            'format' => 'decimal',
            'required' => true,
            'default' => 1,
            'size' => 10,
            'range' => [
                'lower' => 1,
                'upper' => 255,
            ],
        ]
    ],
    'tx_twexercise_points_multiplier' => [
        'label' => 'LLL:EXT:tw_exercise/Resources/Private/Language/locallang_db.xlf:tt_content.tx_twexercise_points_multiplier',
        'config' => [
            'type' => 'number',
            'format' => 'decimal',
            'default' => 1,
            'required' => true,
            'size' => 10,
            'range' => [
                'lower' => 1,
                'upper' => 255,
            ],
        ],
    ],
    'tx_twexercise_cloze_gaps' => [
        'label' => 'LLL:EXT:tw_exercise/Resources/Private/Language/locallang_db.xlf:tt_content.tx_twexercise_cloze_gaps',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_twexercise_domain_model_cloze_gap',
            'foreign_field' => 'parent_id',
            'foreign_table_field' => 'parent_table',
            'foreign_sortby' => 'parent_sorting',
            'appearance' => [
                'showSynchronizationLink' => 1,
                'showAllLocalizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'useSortable' => true,
                'enabledControls' => [
                    'info' => false,
                    'new' => true,
                    'dragdrop' => true,
                    'hide' => false,
                    'delete' => true,
                    'localize' => true,
                ],
            ],
        ],
    ],
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $newColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    'tx_twexercise_points, tx_twexercise_points_multiplier, tx_twexercise_cloze_gaps',
    'twexercise_cloze',
    '',
);

// Define new palette
$GLOBALS['TCA']['tt_content']['palettes']['clozePoints'] = [
    'showitem' => 'tx_twexercise_points, tx_twexercise_points_multiplier'
];

// Adds the content element 'cloze' to the "Type" dropdown
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        // title
        'label' => 'LLL:EXT:tw_exercise/Resources/Private/Language/locallang_db.xlf:tt_content.twexercise_cloze.title',
        // plugin signature: extkey_identifier
        'value' => 'twexercise_cloze',
        // icon identifier
        'icon' => 'content-text',
        // group
        'group' => 'default',
        // description
        'description' => 'LLL:EXT:tw_exercise/Resources/Private/Language/locallang_db.xlf:tt_content.twexercise_cloze.description',
    ],
    'uploads',
    'after',
);
$GLOBALS['TCA']['tt_content']['types']['twexercise_cloze'] = [
    'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;;general,
               --palette--;;headers,
               bodytext;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel,
               --palette--;;clozePoints,
               tx_twexercise_cloze_gaps,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                 --palette--;;frames, 
                 --palette--;;appearanceLinks,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                --palette--;;language,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
               --palette--;;hidden,
               --palette--;;access,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories, 
                categories, 
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes, 
                rowDescription,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended
         ',
    'columnsOverrides' => [
        'bodytext' => [
            'config' => [
                'renderType' => 'codeEditor',
                'format' => 'twexercise',
                'rows' => 16,
            ],
        ],
    ],
];
