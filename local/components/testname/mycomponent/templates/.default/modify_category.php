<?php
//echo $_GET['id'];
//?>

<form name="add_new_news" method="post" action="index.php?page=mod_update_cat&id=<?=$_GET['id']?>">
    <h1>Редактирование категории</h1>
    <label>Новое название категории: </label>
    <input type="text" name="category-type-change" required>
    <p>
        <input type="submit" name="upd-cat" id="upd-cat" value="Обновить категорию">
    </p>
<!--        <a href="index.php?page=mod_update_cat&id=--><?php //=$_GET['id']?><!--"><button>Обновить категорию</button></a>-->
</form>

<a href="index.php?page=mod_delete_cat&id=<?=$_GET['id']?>"><button>Удалить категорию</button></a>
