<?php
//echo $_GET['id'];
//echo strip_tags($_REQUEST['category-type-change']);
// Код свойства-списка
$propertyCode = "CATEGORY";

// Получаем ID инфоблока
$iblockId = $arResult[0]["IBLOCK_ID"];

if ($iblockId) {
    // Получаем ID свойства-списка
    $propertyId = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $iblockId, "CODE" => $propertyCode))->Fetch()["ID"];

    if ($propertyId) {
        // Получаем все значения списка свойства-списка
        $enumList = CIBlockPropertyEnum::GetList(
            array(),
            array("IBLOCK_ID" => $iblockId, "PROPERTY_ID" => $propertyId)
        );

        CIBlockPropertyEnum::Delete($_GET['id']);

    }
}
header("Location: index.php");
exit();
?>