<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php
//echo '<pre>';
//print_r($arResult);
//echo '</pre>';
?>



<?php foreach ($arResult as $arItem): ?>
<div class="container">
    <div class="category"><?=$arItem["CATEGORY"]?></div>
    <div class="name">
        <a href="index.php?page=detail&id=<?=$arItem["ID"]?>"><?=$arItem["NAME"]?></a>
    </div>
    <div class="date"><?=$arItem["DATE"]?></div>

</div>
<?php endforeach; ?>

<div сlass="container">
    <a href="index.php?page=add_news"><button>Добавить новость</button></a>
    <a href="index.php?page=add_category"><button>Добавить категорию новости</button></a>
</div>
