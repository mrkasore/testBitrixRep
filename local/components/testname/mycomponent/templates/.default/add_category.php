<div class="main-container">
    <h1>Добавить категорию новости</h1>
    <h2>В списке имеется: </h2>
    <?php foreach ($arResult[0]["CATEGORIES"] as $enum_fields) : ?>
        <div class="change-category-form">
            <option value="<?=$enum_fields["ID"]?>"><?=$enum_fields["VALUE"]?></option>
            <a href="index.php?page=modify_category&id=<?=$enum_fields["ID"]?>"><button>Редактировать</button></a>
        </div>
    <?php endforeach; ?>

    <form name="add_new_news" method="post" action="index.php?page=add_send_category">
        <input type="text" name="category_add">
        <input type="submit" name="test" id="test" value="Добавить категорию">
    </form>
</div>

