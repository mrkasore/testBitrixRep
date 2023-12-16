<?php

$propertyCode = "CATEGORY";

// Новое значение для списка
$newValue = strip_tags($_REQUEST['category_add']);

// Получаем ID инфоблока
$iblockId = $arResult[0]["IBLOCK_ID"];

if ($iblockId) {
    // Получаем ID свойства-списка
    $propertyId = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $iblockId, "CODE" => $propertyCode))->Fetch()["ID"];

    if ($propertyId) {
        // Проверяем, есть ли уже такое значение в списке
        $enumId = CIBlockPropertyEnum::GetList(
            array(),
            array("IBLOCK_ID" => $iblockId, "PROPERTY_ID" => $propertyId, "VALUE" => $newValue)
        )->Fetch()["ID"];

        if (!$enumId) {
            // Если значения нет, то добавляем новое значение в список
            $enum = new CIBlockPropertyEnum;
            $enumId = $enum->Add(array("PROPERTY_ID" => $propertyId, "VALUE" => $newValue));
        }
    }
}
header("Location: index.php");
exit();
?>
