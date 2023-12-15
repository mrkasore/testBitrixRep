<?php
echo '<pre>';
print_r($_GET['id']);
print_r($arItem["CATEGORY"]);
echo '</pre>';

//$res = CIBlockElement::GetByID($_GET["id"]);
//if($ar_res = $res->GetNext())
//    echo '<pre>';
//    print_r($ar_res);
//    echo '</pre>';
//?>

<h1>Изменить новость</h1>
<?php foreach ($arResult as $arItem) : ?>
    <?php if($arItem['ID'] == $_GET['id']) : ?>
    <form name="add_new_news" method="post" action="index.php?page=send_modify_form&id=<?=$arItem['ID']?>" enctype="multipart/form-data">
        <div>
            <label>Заголовок: </label>
            <input type="text" name="name" value="<?=$arItem["NAME"]?>" required>
            <label>Описание новости: </label>
            <textarea name="about" rows="10" cols="45" required><?=$arItem["PREVIEW_TEXT"]?></textarea>
            <label>Добавить картинку </label>
            <input type="file" name="image-news" required>
            <label>Дата: <?=date("d.m.y"); ?></label>
            <label>Категогия: </label>
            <select name="select_category" size="5" multiple required>
                <?php $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arResult["IBLOCK_ID"], "CODE"=>"CATEGORY")); ?>;
                <?php while($enum_fields = $property_enums->GetNext()) : ?>
                    <?php if ($enum_fields["VALUE"] == $arItem["CATEGORY"]) : ?>
                        <option value="<?=$enum_fields["ID"]?>" selected><?=$enum_fields["VALUE"]?></option>
                    <?php else : ?>
                        <option value="<?=$enum_fields["ID"]?>"><?=$enum_fields["VALUE"]?></option>
                    <?php endif; ?>
                <?php endwhile; ?>;
            </select>
        </div>
        <input type="submit" name="test" id="test" value="Изменить">
    </form>
        <a href="index.php?page=delete_news&id=<?=$_GET['id']?>"><button>Удалить новость</button></a>
    <?php endif; ?>
<?php endforeach; ?>