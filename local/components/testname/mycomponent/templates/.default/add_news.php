<?//
//$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arResult["IBLOCK_ID"], "CODE"=>"CATEGORY"));
//while($enum_fields = $property_enums->GetNext())
//{
//    echo $enum_fields["ID"]." - ".$enum_fields["VALUE"]."<br>";
//}
//?>
<h1>Добавить новость</h1>
<form name="add_new_news" method="post" action="index.php?page=send_form" enctype="multipart/form-data">
    <div>
        <label>Заголовок: </label>
        <input type="text" name="name" required>
        <label>Описание новости: </label>
        <textarea name="about" rows="10" cols="45" required></textarea>
        <label>Добавить картинку </label>
        <input type="file" name="image-news" required>
        <label>Дата: <?=date("d.m.y"); ?></label>
        <label>Категогия:</label>
        <select name="select_category" size="5" multiple required>
            <?php $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arResult["IBLOCK_ID"], "CODE"=>"CATEGORY")); ?>
            <?php while($enum_fields = $property_enums->GetNext()) : ?>
                <option value="<?=$enum_fields["ID"]?>"><?=$enum_fields["VALUE"]?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <input type="submit" name="test" id="test" value="Добавить элемент">
</form>


<?php
//if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
//if(isset($_POST['test'])) {
//    echo "Форма отправлена";
//    $el = new CIBlockElement;
//    //$PROP = array();
//    //$PROP[12] = "Белый";  // свойству с кодом 12 присваиваем значение "Белый"
//    //$PROP[3] = 38;        // свойству с кодом 3 присваиваем значение 38
//    $arLoadProductArray = array(
//    "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
//    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
//    "IBLOCK_ID" => $arResult[0]["IBLOCK_ID"],
////  "PROPERTY_VALUES"=> $PROP,
//    "NAME" => "Элемент2",
//    "ACTIVE" => "Y",            // активен
//    "PREVIEW_TEXT"   => strip_tags($_REQUEST['about']),
////    "DETAIL_TEXT"    => "текст для детального просмотра",
////    "DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image.gif")
//        );
//    if ($PRODUCT_ID = $el->Add($arLoadProductArray))
//        echo "New ID: " . $PRODUCT_ID;
//    else
//        echo "Error: " . $el->LAST_ERROR;
//    exit();
//}
//?>



