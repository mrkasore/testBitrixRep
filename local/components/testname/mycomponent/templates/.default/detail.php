<?php

//    $id2 = $_GET['id'];

//    $res = CIBlockElement::GetByID($_GET['id']);
//    $ar_res = $res->GetNext();
//
//    print_r($ar_res);

//    echo '<pre>';
//    print_r($arResult);
//    echo '</pre>';
?>
<?php foreach ($arResult as $arItem) : ?>
    <?php if($arItem['ID'] == $_GET['id']) : ?>
        <div class="container">
            <div class="category"><?=$arItem["NAME"]?></div>
            <div class="about_news"><?=$arItem["PREVIEW_TEXT"]?></div>
            <div class="img_news"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="news"/></div>
            <div class="date"><?=$arItem["DATE"]?></div>
            <div class="category"><?=$arItem["CATEGORY"]?></div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<a href="index.php?page=modify_news&id=<?=$_GET['id']?>"><button>Редактировать новость</button></a>


