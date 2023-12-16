<div class="main-container">
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
</div>




