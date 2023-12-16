<div class="main-container">
    <h1>Добавить категорию новости</h1>
    <h2>В списке имеется: </h2>
    <?php $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arResult["IBLOCK_ID"], "CODE"=>"CATEGORY")); ?>
    <?php while($enum_fields = $property_enums->GetNext()) : ?>
        <div class="change-category-form">
            <option value="<?=$enum_fields["ID"]?>"><?=$enum_fields["VALUE"]?></option>
            <a href="index.php?page=modify_category&id=<?=$enum_fields["ID"]?>"><button>Редактировать</button></a>
        </div>
    <?php endwhile; ?>

    <form name="add_new_news" method="post" action="index.php?page=add_send_category">
        <input type="text" name="category_add">
        <input type="submit" name="test" id="test" value="Добавить категорию">
    </form>
</div>

