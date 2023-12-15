<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1С-Битрикс: Управление сайтом");
?><div id="panel">
    <?php $APPLICATION->ShowPanel();?>
</div>



<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule('iblock');
echo "Форма отправлена";
$el = new CIBlockElement;
$PROP = array();
$PROP["CATEGORY"] = array("VALUE" => $_POST['select_category']);
//$PROP[12] = "Белый";  // свойству с кодом 12 присваиваем значение "Белый"
//$PROP[3] = 38;        // свойству с кодом 3 присваиваем значение 38
$arLoadProductArray = array(
    "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID" => 1,
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
?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

<?php
//    echo 'Hello World';
//CModule::IncludeModule('iblock');
//$el = new CIBlockElement;
////$PROP = array();
////$PROP[12] = "Белый";  // свойству с кодом 12 присваиваем значение "Белый"
////$PROP[3] = 38;        // свойству с кодом 3 присваиваем значение 38
//$arLoadProductArray = array(
//    "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
//    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
//    "IBLOCK_ID" => 1,
////    "PROPERTY_VALUES"=> $PROP,
//    "NAME" => "Элемент2",
//    "ACTIVE" => "Y",            // активен
////    "PREVIEW_TEXT"   => "текст для списка элементов",
////    "DETAIL_TEXT"    => "текст для детального просмотра",
////    "DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image.gif")
//);
//if ($PRODUCT_ID = $el->Add($arLoadProductArray))
//    echo "New ID: " . $PRODUCT_ID;
//else
//    echo "Error: " . $el->LAST_ERROR;
//
//?>
