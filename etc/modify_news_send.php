<?
$el = new CIBlockElement;
$PROP = array();
$PROP["CATEGORY"] = array("VALUE" => $_POST['select_category']);
$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION" => false,          // элемент лежит в корне раздела
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => strip_tags($_REQUEST['name']),
    "ACTIVE"         => "Y",            // активен
    "PREVIEW_TEXT"   => strip_tags($_REQUEST['about']),
    "DETAIL_TEXT"    => strip_tags($_REQUEST['about']),
    "DETAIL_PICTURE" => $_FILES['image-news'],
    "PREVIEW_PICTURE" => $_FILES['image-news'],
);
$PRODUCT_ID = $_GET['id'];  // изменяем элемент с кодом (ID) 2
$res = $el->Update($PRODUCT_ID, $arLoadProductArray);

header("Location: index.php");
exit();
?>

