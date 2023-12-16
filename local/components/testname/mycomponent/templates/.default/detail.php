
<div class="main-container">
    <?php foreach ($arResult as $arItem) : ?>
        <?php if($arItem['ID'] == $_GET['id']) : ?>
            <div class="container">
                <h1 class="category"><?=$arItem["NAME"]?></h1>
                <div class="about_news"><?=$arItem["PREVIEW_TEXT"]?></div>
                <div class="img_news"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="news"/></div>
                <div class="date"><?=$arItem["DATE"]?></div>
                <div class="category"><?=$arItem["CATEGORY"]?></div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <a href="index.php?page=modify_news&id=<?=$_GET['id']?>"><button>Редактировать новость</button></a>
</div>



