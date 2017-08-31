<?php
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3_MODE') or die;

//// add content element type
call_user_func(function () {

    $_extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['nn_address']);

    // Register plugins
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'nn_address',
        'Single',
        'Address - Single'
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'nn_address',
        'List',
        'Address - List'
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'nn_address',
        'AbcList',
        'Address - ABC List'
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'nn_address',
        'BirthdayList',
        'Address - Birthday List'
    );

    // Add Typoscript
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('nn_address', 'Configuration/TypoScript/Default',
        'NN Address');

    // Add flexform for plugins
    $_extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['nn_address']);

    // Add flexform for plugin BirthdayList
    $flexFormFile = $_extConfig['flexFormPlugin'] . 'BirthdayList.xml';
    if (file_exists(GeneralUtility::getFileAbsFileName($flexFormFile))) {
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['nnaddress_birthdaylist'] = 'recursive,select_key,pages, ';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['nnaddress_birthdaylist'] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('nnaddress_birthdaylist',
            'FILE:' . $flexFormFile);
    }

    // Add flexform for plugin AbcList
    $flexFormFile = $_extConfig['flexFormPlugin'] . 'AbcList.xml';
    if (file_exists(GeneralUtility::getFileAbsFileName($flexFormFile))) {
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['nnaddress_abclist'] = 'recursive,select_key,pages, ';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['nnaddress_abclist'] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('nnaddress_abclist',
            'FILE:' . $flexFormFile);
    }

    // Add flexform for plugin List
    $flexFormFile = $_extConfig['flexFormPlugin'] . 'List.xml';
    if (file_exists(GeneralUtility::getFileAbsFileName($flexFormFile))) {
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['nnaddress_list'] = 'recursive,select_key,pages, ';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['nnaddress_list'] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('nnaddress_list',
            'FILE:' . $flexFormFile);
    }

    // Add flexform for plugin Single
    $flexFormFile = $_extConfig['flexFormPlugin'] . 'Single.xml';
    if (file_exists(GeneralUtility::getFileAbsFileName($flexFormFile))) {
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['nnaddress_single'] = 'recursive,select_key,pages,  ';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['nnaddress_single'] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('nnaddress_single',
            'FILE:' . $flexFormFile);
    }

});