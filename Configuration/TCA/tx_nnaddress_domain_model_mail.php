<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$_extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['nn_address']);

$tx_nnaddress_domain_model_mail = [

    'ctrl' => array(
        'hideTable' => 1,
        'title' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_mail',
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
        'searchFields' => 'type,email',
        'iconfile' => 'EXT:nn_address/Resources/Public/Icons/tx_nnaddress_domain_model_mail.gif'
    ),
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, email',
    ),
    'types' => array(
        '1' => array('showitem' => 'l10n_parent, l10n_diffsource, hidden, type, email, flexform'),
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
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_nnaddress_domain_model_mail',
                'foreign_table_where' => 'AND tx_nnaddress_domain_model_mail.pid=###CURRENT_PID### AND tx_nnaddress_domain_model_mail.sys_language_uid IN (-1,0)',
                'default' => 0,
            ),
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
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
                        'LLL:EXT:nn_address/Resources/Private/Language/locallang_csh_tx_nnaddress_domain_model_mail.xlf:type.0',
                        0
                    ), // Private
                    array(
                        'LLL:EXT:nn_address/Resources/Private/Language/locallang_csh_tx_nnaddress_domain_model_mail.xlf:type.1',
                        1
                    ), // Work
                    array(
                        'LLL:EXT:nn_address/Resources/Private/Language/locallang_csh_tx_nnaddress_domain_model_mail.xlf:type.2',
                        2
                    ), // Other
                ),
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ),
        ),
        'email' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:locallang_csh_tx_nnaddress_domain_model_mail.email',
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
    ),
];


$flexFormFile = $_extConfig['flexForm'] . 'Mail.xml';
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
    $tx_nnaddress_domain_model_mail['columns']['flexform'] = $tempFlexform;
    unset($tempFlexform);
}

unset($_extConfig);

return $tx_nnaddress_domain_model_mail;
