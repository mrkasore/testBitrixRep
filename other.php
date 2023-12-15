<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

\Bitrix\Main\Loader::includeModule('iblock');




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
        'ID' => $arParams['ELEMENT_ID']
    ],
    'select' => [
        'ID',
        'NAME',
    ],
]);


while ($arItem = $rsElements->fetch()) {
    echo "<pre>";
    print_r($arItem);
    echo "</pre>";
}

echo '<pre>';
print_r($arParams);
echo '</pre>';
?>

<?php
$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arResult["IBLOCK_ID"], "CODE"=>"CATEGORY"));
while($enum_fields = $property_enums->GetNext()) {
    if($enum_fields["VALUE"] == $arItem["CATEGORY"]) {
        echo '<option value="'.$enum_fields["ID"].'" selected>'.$enum_fields["VALUE"].'</option>';
    } else {
        echo '<option value="'.$enum_fields["ID"].'">'.$enum_fields["VALUE"].'</option>';
    }
}
?>



