<?php

/**
 * File tx_twexercise_domain_model_cloze_gap.php
 *
 * @category  Tollwerk
 * @package   Tollwerk\TwDashboard
 * @author    tollwerk GmbH <info@tollwerk.de>
 * @copyright 2024 tollwerk GmbH <info@tollwerk.de>
 * @license   GPL https://www.gnu.org/licenses/gpl-3.0.html.en
 * @link      https://tollwerk.de
 */

defined('TYPO3') or die();

return [
    'ctrl' => [
        'hideTable' => true,
        'title' => 'LLL:EXT:tw_exercise/Resources/Private/Language/locallang_db.xlf:tx_twexercise_domain_model_cloze_gap',
        'label' => 'identifier',
        'label_alt' => 'value',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'iconfile' => 'EXT:tw_exercise/Resources/Public/Icons/Backend/tx_twexercise_domain_model_cloze_gap.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'palettes' => [
        'meta' => ['showitem' => 'identifier, is_example'],
    ],
    'types' => [
        '1' => ['showitem' => '
                --palette--;;meta,
                value,
                options, 
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, 
                sys_language_uid, 
                l10n_diffsource'
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'identifier' => [
            'exclude' => false,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:tw_exercise/Resources/Private/Language/locallang_db.xlf:tx_twexercise_domain_model_cloze_gap.identifier',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'required' => true,
                'default' => '',
                'size' => 1,
            ]
        ],
        'value' => [
            'exclude' => false,
            'label' => 'LLL:EXT:tw_exercise/Resources/Private/Language/locallang_db.xlf:tx_twexercise_domain_model_cloze_gap.value',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'required' => true,
                'default' => '',
                'size' => 50,
            ]
        ],
        'is_example' => [
            'exclude' => false,
            'label' => 'LLL:EXT:tw_exercise/Resources/Private/Language/locallang_db.xlf:tx_twexercise_domain_model_cloze_gap.is_example',
            'config' => [
                'type' => 'check',
            ]
        ],
        'options' => [
            'exclude' => false,
            'label' => 'LLL:EXT:tw_exercise/Resources/Private/Language/locallang_db.xlf:tx_twexercise_domain_model_cloze_gap.options',
            'description' => 'LLL:EXT:tw_exercise/Resources/Private/Language/locallang_db.xlf:tx_twexercise_domain_model_cloze_gap.options.description',
            'config' => [
                'type' => 'text',
                'eval' => 'trim',
                'required' => true,
                'rows' => 8,
                'size' => 50,
                'default' => ''
            ]
        ],
    ],
];
