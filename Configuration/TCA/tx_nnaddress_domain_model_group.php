<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$_extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['nn_address']);

$tx_nnaddress_domain_model_group = [

    'ctrl' => array(
        'title' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_group',
        'label' => 'title',
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
        'searchFields' => 'title,description,',
        // 'dynamicConfigFile' => 'EXT:nn_address/Configuration/TCA/Group.php',
        'iconfile' => 'EXT:nn_address/Resources/Public/Icons/tx_nnaddress_domain_model_group.gif'
    ),

    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, parent_group',
    ),
    'types' => array(
        '1' => array('showitem' => 'l10n_parent, l10n_diffsource, hidden, title, description, parent_group, flexform'),
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
                'foreign_table' => 'tx_nnaddress_domain_model_group',
                'foreign_table_where' => 'AND tx_nnaddress_domain_model_group.pid=###CURRENT_PID### AND tx_nnaddress_domain_model_group.sys_language_uid IN (-1,0)',
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
                'checkbox' => 0,
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
        'title' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_group.title',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'description' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_group.description',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ),
        ),
        'parent_group' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nn_address/Resources/Private/Language/locallang_db.xlf:tx_nnaddress_domain_model_group.parent_group',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_nnaddress_domain_model_group',
                'foreign_table_where' => ' AND tx_nnaddress_domain_model_group.parent_group <> ###REC_FIELD_uid### AND (((\'###PAGE_TSCONFIG_IDLIST###\' <> \'\' OR \'###PAGE_TSCONFIG_IDLIST###\' > 0) AND FIND_IN_SET(tx_nnaddress_domain_model_group.pid,\'###PAGE_TSCONFIG_IDLIST###\')) OR (\'###PAGE_TSCONFIG_IDLIST###\' = \'\' OR \'###PAGE_TSCONFIG_IDLIST###\' = 0)) AND tx_nnaddress_domain_model_group.sys_language_uid=###REC_FIELD_sys_language_uid###',
                'renderMode' => 'tree',
                'treeConfig' => array(
                    'parentField' => 'parent_group',
                    'appearance' => array(
                        'expandAll' => true,
                        'showHeader' => true,
                    ),
                ),
                'size' => 10,
                'autoSizeMax' => 30,
                'minitems' => 0,
                'maxitems' => 1,
            ),
        ),
    ),
];


$flexFormFile = $_extConfig['flexForm'] . 'Group.xml';
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
    $tx_nnaddress_domain_model_group['columns']['flexform'] = $tempFlexform;
    unset($tempFlexform);
}

unset($_extConfig);

return $tx_nnaddress_domain_model_group;
