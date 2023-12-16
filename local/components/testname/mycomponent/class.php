<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;

class CIblocList extends CBitrixComponent
{

    public function executeComponent()
    {
        try {
            $this->checkModules();
            $this->getResult();

        } catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }

    public function getUrl() {
        $current_link = $_SERVER["REQUEST_URI"];
        if(str_contains($current_link, "page=detail&id=")) {
            return true;
        }
    }

    public function onIncludeComponentLang()
    {
        Loc::loadMessages(__FILE__);
    }

    protected function checkModules()
    {
        if (!Loader::includeModule('iblock'))
            throw new SystemException(Loc::getMessage('IBLOCK_MODULE_NOT_INSTALLED'));
    }


    function addNewsSend($iblockID) {
        $el = new CIBlockElement;
        $PROP = array();
        $PROP["CATEGORY"] = array("VALUE" => $_POST['select_category']);
        $arLoadProductArray = array(
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => $iblockID,
            "PROPERTY_VALUES"=> $PROP,
            "NAME" => strip_tags($_REQUEST['name']),
            "ACTIVE" => "Y",
            "PREVIEW_TEXT"   => strip_tags($_REQUEST['about']),
            "PREVIEW_PICTURE" => $_FILES['image-news'],
            "DETAIL_TEXT"    => strip_tags($_REQUEST['about']),
            "DETAIL_PICTURE" => $_FILES['image-news']
        );
        if ($PRODUCT_ID = $el->Add($arLoadProductArray))
            echo "New ID: " . $PRODUCT_ID;
        else
            echo "Error: " . $el->LAST_ERROR;
        LocalRedirect("index.php");
    }

    function addCategorySend($iblockID) {
        $propertyCode = "CATEGORY";
        $newValue = strip_tags($_REQUEST['category_add']);

        // Получаем ID инфоблока
        $iblockId = $iblockID;
        if ($iblockId) {
            // Получаем ID свойства-списка
            $propertyId = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $iblockId, "CODE" => $propertyCode))->Fetch()["ID"];

            if ($propertyId) {
                // Проверяем, есть ли уже такое значение в списке
                $enumId = CIBlockPropertyEnum::GetList(
                    array(),
                    array("IBLOCK_ID" => $iblockId, "PROPERTY_ID" => $propertyId, "VALUE" => $newValue)
                )->Fetch()["ID"];

                if (!$enumId) {
                    // Если значения нет, то добавляем новое значение в список
                    $enum = new CIBlockPropertyEnum;
                    $enumId = $enum->Add(array("PROPERTY_ID" => $propertyId, "VALUE" => $newValue));
                }
            }
        }
        LocalRedirect("index.php");
    }

    function modDeleteCat($iblockID) {
        $propertyCode = "CATEGORY";
        $iblockId = $iblockID;

        if ($iblockId) {
            // Получаем ID свойства-списка
            $propertyId = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $iblockId, "CODE" => $propertyCode))->Fetch()["ID"];

            if ($propertyId) {
                // Получаем все значения списка свойства-списка
                $enumList = CIBlockPropertyEnum::GetList(
                    array(),
                    array("IBLOCK_ID" => $iblockId, "PROPERTY_ID" => $propertyId)
                );

                CIBlockPropertyEnum::Delete($_GET['id']);

            }
        }
        LocalRedirect("index.php");
    }

    function modUpdateCategory($iblockID) {
        // Код свойства-списка
        $propertyCode = "CATEGORY";

        $iblockId = $iblockID;

        if ($iblockId) {
            // Получаем ID свойства-списка
            $propertyId = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $iblockId, "CODE" => $propertyCode))->Fetch()["ID"];

            if ($propertyId) {
                // Получаем все значения списка свойства-списка
                $enumList = CIBlockPropertyEnum::GetList(
                    array(),
                    array("IBLOCK_ID" => $iblockId, "PROPERTY_ID" => $propertyId)
                );

                while ($enum = $enumList->Fetch()) {

                    if($enum["ID"] == $_GET['id']) {
                        // Редактирование значения
                        $enumId = $enum["ID"];
                        $newValue = strip_tags($_REQUEST['category-type-change']);
                        $enumUpdate = new CIBlockPropertyEnum;
                        $enumUpdate->Update($enumId, array("VALUE" => $newValue));
                    }

                }
            }
        }
        LocalRedirect("index.php");
    }

    function modifyNewsSend() {
        $el = new CIBlockElement;
        $PROP = array();
        $PROP["CATEGORY"] = array("VALUE" => $_POST['select_category']);
        $arLoadProductArray = Array(
            "IBLOCK_SECTION" => false,
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => strip_tags($_REQUEST['name']),
            "ACTIVE"         => "Y",
            "PREVIEW_TEXT"   => strip_tags($_REQUEST['about']),
            "DETAIL_TEXT"    => strip_tags($_REQUEST['about']),
            "DETAIL_PICTURE" => $_FILES['image-news'],
            "PREVIEW_PICTURE" => $_FILES['image-news'],
        );
        $PRODUCT_ID = $_GET['id'];
        $res = $el->Update($PRODUCT_ID, $arLoadProductArray);

        LocalRedirect("index.php");
    }

    function deleteNews() {
        CIBlockElement::Delete($_GET['id']);
        LocalRedirect("index.php");
    }



    // подготовка массива $arResult (метод подключается внутри класса try...catch)
    protected function getResult()
    {
        // если нет валидного кеша, получаем данные из БД
        if ($this->startResultCache()) {

            // Запрос к инфоблоку через класс ORM
            $res = \Bitrix\Iblock\Elements\ElementNewsTable::getList([
                "select" => ["ID", "NAME", "IBLOCK_ID", "PREVIEW_TEXT", "PREVIEW_PICTURE", "CATEGORY", "DATE_CREATE"],
                "filter" => ["ACTIVE" => "Y"],
                "order" => ["SORT" => "ASC"]
            ]);


            $array = array();
            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arResult["IBLOCK_ID"], "CODE"=>"CATEGORY"));
            while ($enum_fields = $property_enums->GetNext()) {
                array_push($array, $enum_fields);
            }


            // Формируем массив arResult
            while ($arItem = $res->fetch()) {
                $dateCreate = CIBlockFormatProperties::DateFormat(
                    'j F Y',
                    MakeTimeStamp(
                        $arItem["DATE_CREATE"],
                        CSite::GetDateFormat()
                    )
                );
                $arItem["PREVIEW_PICTURE"] = CFile::GetFileArray($arItem["PREVIEW_PICTURE"]);
                $arItem["DATE"] = $dateCreate;
                $UserField = CIBlockPropertyEnum::GetList(
                    array(),
                    array("ID" => $arItem["IBLOCK_ELEMENTS_ELEMENT_NEWS_CATEGORY_VALUE"])
                );
                if($UserFieldAr = $UserField->GetNext()) {
                    $arItem["CATEGORY"] = $UserFieldAr["VALUE"];
                }
                $arItem["CATEGORIES"] = $array;
                $this->arResult[] = $arItem;
            }



            if (isset($this->arResult)) {

                $current_link = $_SERVER["REQUEST_URI"];
                $iblockID = $this->arResult[0]['IBLOCK_ID'];
                if (str_contains($current_link, "page=detail&id=")) {
                    $this->IncludeComponentTemplate('detail');
                } else if ((str_contains($current_link, "?page=add_news"))) {
                    $this->IncludeComponentTemplate('add_news');
                } else if ((str_contains($current_link, "?page=send_form"))) {
                    $this->addNewsSend($iblockID);
                } else if ((str_contains($current_link, "?page=modify_news"))) {
                    $this->IncludeComponentTemplate('modify_news');
                } else if ((str_contains($current_link, "?page=send_modify_form"))) {
                    $this->modifyNewsSend();
                } else if ((str_contains($current_link, "?page=delete"))) {
                    $this->deleteNews();
                } else if ((str_contains($current_link, "?page=add_category"))) {
                    $this->IncludeComponentTemplate('add_category');
                } else if ((str_contains($current_link, "?page=add_send_category"))) {
                    $this->addCategorySend($iblockID);
                } else if (str_contains($current_link, "?page=modify_category")) {
                    $this->IncludeComponentTemplate('modify_category');
                } else if (str_contains($current_link, "?page=mod_update_cat&id=")) {
                    $this->modUpdateCategory($iblockID);
                } else if (str_contains($current_link, "?page=mod_delete_cat&id=")) {
                    $this->modDeleteCat($iblockID);
                } else {
                    $this->IncludeComponentTemplate();
                }

            }
        }
    }
}


