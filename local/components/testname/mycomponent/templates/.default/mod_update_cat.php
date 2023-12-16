<?php
echo $_GET['id'];
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

        while ($enum = $enumList->Fetch()) {
//            echo "ID: " . $enum["ID"] . "<br>";
//            echo "VALUE: " . $enum["VALUE"] . "<br>";

            if($enum["ID"] == $_GET['id']) {
                // Редактирование значения
                $enumId = $enum["ID"];
                $newValue = strip_tags($_REQUEST['category-type-change']);
                $enumUpdate = new CIBlockPropertyEnum;
                $enumUpdate->Update($enumId, array("VALUE" => $newValue));
            }

        }
    }
}
header("Location: index.php");
exit();
?>