<?php
/*
 * Файл local/components/tokmakov/iblock.section/component.php
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

\Bitrix\Main\Loader::includeModule('iblock');

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

if (!CModule::IncludeModule('iblock')) {
    ShowError('Модуль «Информационные блоки» не установлен');
    return;
}


$entityClass = "\Bitrix\Iblock\Elements\ElementNewsTable";
$arParams['ELEMENT_ID'] = empty($arParams['ELEMENT_ID']) ? 1 : intval($arParams['ELEMENT_ID']);
$iblockId = $arParams['ELEMENT_ID'];
$rsElements = $entityClass::getList([
    'filter' => [
        'IBLOCK_ID' => $iblockId,
    ],
    'select' => [
        'ID',
        'NAME',
        'PREVIEW_TEXT',
        'PREVIEW_PICTURE'
    ],
]);

$arResult = $rsElements;

$arDefaultUrlTemplates404 = array(
    "news" => "",
    "search" => "search/",
    "rss" => "rss/",
    "rss_section" => "#SECTION_ID#/rss/",
    "detail" => "#ELEMENT_ID#/",
    "section" => "",
);

$arDefaultVariableAliases404 = array();

$arDefaultVariableAliases = array();

$arComponentVariables = array(
    "SECTION_ID",
    "SECTION_CODE",
    "ELEMENT_ID",
    "ELEMENT_CODE",
);

while ($arItem = $arResult->fetch()) {
    echo "<pre>";
    print_r($arItem);
    echo "</pre>";
}


$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultUrlTemplates404, $arParams["SEF_URL_TEMPLATES"]);

$url = $_SERVER['REQUEST_URI'];
echo $url;
echo '<pre>';
print_r($arUrlTemplates);
echo '</pre>';

?>
