<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$_extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['nn_address']);

$tx_nnaddress_domain_model_address = [

    'ctrl' => array(
        'hideTable' => 1,
        'title' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_address',
        'label' => 'type',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => 2,
        'versioning_followPages' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'searchFields' => 'type,street,street_nr,building,room,zip,city,country,region,website',
        'iconfile' => 'EXT:nn_address/Resources/Public/Icons/tx_nnaddress_domain_model_address.gif'
    ),

    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, street, street_nr, building, room, zip, city, country, region, website',
    ),
    'types' => array(
        '1' => array('showitem' => 'l10n_parent, l10n_diffsource, hidden, type, street, street_nr, building, room, zip, city, country, region, website, flexform'),
    ),
    'columns' => array(
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
                'default' => 0,
            ]
        ),
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_nnaddress_domain_model_address',
                'foreign_table_where' => 'AND tx_nnaddress_domain_model_address.pid=###CURRENT_PID### AND tx_nnaddress_domain_model_address.sys_language_uid IN (-1,0)',
                'default' => 0,
            ]
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => ''
            ]
        ],
        't3ver_label' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'starttime' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                // 'renderType' => 'inputDateTime',
                'default' => 0
            ),
        ),
        'endtime' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                // 'renderType' => 'inputDateTime',
                'default' => 0
            ),
        ),
        'type' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_address.type',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array(
                    array(
                        'LLL:EXT:nn_address/Resources/Private/Language/locallang_csh_tx_nnaddress_domain_model_address.xlf:type.0',
                        0
                    ),
                    array(
                        'LLL:EXT:nn_address/Resources/Private/Language/locallang_csh_tx_nnaddress_domain_model_address.xlf:type.1',
                        1
                    ),
                    array(
                        'LLL:EXT:nn_address/Resources/Private/Language/locallang_csh_tx_nnaddress_domain_model_address.xlf:type.2',
                        2
                    ),
                ),
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ),
        ),
        'street' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_address.street',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'street_nr' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_address.street_nr',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'building' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_address.building',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'room' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_address.room',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'zip' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_address.zip',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'city' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_address.city',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'country' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_address.country',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'region' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_address.region',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'website' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_address.website',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'person' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
        'flexform' => array(
            'exclude' => 1,
            'label' => '',
            'config' => array(
                'type' => 'flex',
                'ds' => array(
                    'default' => 'FILE:EXT:nn_address/Configuration/FlexForms/Model/Address.xml',
                ),
            ),
        )
    ),
];

$flexFormFile = $_extConfig['flexForm'] . 'Address.xml';
if (file_exists(GeneralUtility::getFileAbsFileName($flexFormFile))) {
    $tempFlexform = [
        'exclude' => 1,
        'label' => '',
        'config' => array(
            'type' => 'flex',
            'ds' => array(
                'default' => 'FILE:' . $flexFormFile,
            ),
        ),
    ];
    $tx_nnaddress_domain_model_address['columns']['flexform'] = $tempFlexform;
    unset($tempFlexform);
}

unset($_extConfig);

return $tx_nnaddress_domain_model_address;
