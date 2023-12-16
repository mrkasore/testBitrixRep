<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule('iblock');
$el = new CIBlockElement;
$PROP = array();
$PROP["CATEGORY"] = array("VALUE" => $_POST['select_category']);
$arLoadProductArray = array(
    "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID" => $arResult[0]["IBLOCK_ID"],
    "PROPERTY_VALUES"=> $PROP,
    "NAME" => strip_tags($_REQUEST['name']),
    "ACTIVE" => "Y",            // активен
    "PREVIEW_TEXT"   => strip_tags($_REQUEST['about']),
    "PREVIEW_PICTURE" => $_FILES['image-news'],
//    "DETAIL_TEXT"    => "текст для детального просмотра",
    "DETAIL_PICTURE" => $_FILES['image-news']
);
if ($PRODUCT_ID = $el->Add($arLoadProductArray))
    echo "New ID: " . $PRODUCT_ID;
else
    echo "Error: " . $el->LAST_ERROR;

header("Location: index.php");
exit();
?>
