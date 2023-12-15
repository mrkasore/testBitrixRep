<?php
echo "Добавить категорию";

$propertyCode = "CATEGORY";

// Новое значение для списка
$newValue = "Новое значение списка 2";

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
            if ($enumId) {
                echo "Новое значение успешно добавлено с ID: " . $enumId;
            } else {
                echo "Ошибка при добавлении значения: " . $enum->LAST_ERROR;
            }
        } else {
            echo "Значение уже существует в списке с ID: " . $enumId;
        }
    } else {
        echo "Свойство-список не найдено";
    }
} else {
    echo "Инфоблок не найден";
}
?>
