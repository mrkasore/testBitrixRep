<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// класс для работы с языковыми файлами
use Bitrix\Main\Localization\Loc;
// класс для всех исключений в системе
use Bitrix\Main\SystemException;
// класс для загрузки необходимых файлов, классов, модулей
use Bitrix\Main\Loader;

// основной класс, является оболочкой компонента унаследованного от CBitrixComponent
class CIblocList extends CBitrixComponent
{

    // выполняет основной код компонента, аналог конструктора (метод подключается автоматически)
    public function executeComponent()
    {
        try {
            // подключаем метод проверки подключения модуля «Информационные блоки»
            $this->checkModules();
            // подключаем метод подготовки массива $arResult
            $this->getResult();

//            $current_link = $_SERVER["REQUEST_URI"];
//            if(str_contains($current_link, "page=detail&id=")) {
//                echo 'true';
//            }

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

    // подключение языковых файлов (метод подключается автоматически)
    public function onIncludeComponentLang()
    {
        Loc::loadMessages(__FILE__);
    }

    // проверяем установку модуля «Информационные блоки» (метод подключается внутри класса try...catch)
    protected function checkModules()
    {
        // если модуль не подключен
        if (!Loader::includeModule('iblock'))
            // выводим сообщение в catch
            throw new SystemException(Loc::getMessage('IBLOCK_MODULE_NOT_INSTALLED'));
    }

    // обработка массива $arParams (метод подключается автоматически)
    public function onPrepareComponentParams($arParams)
    {
        // время кеширования
        if (!isset($arParams['CACHE_TIME'])) {
            $arParams['CACHE_TIME'] = 3600;
        } else {
            $arParams['CACHE_TIME'] = intval($arParams['CACHE_TIME']);
        }
        // возвращаем в метод новый массив $arParams     
        return $arParams;
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

            function GetListValueById($ID)
            {
                $UserField = CIBlockPropertyEnum::GetList(
                    array(),
                    array("ID" => $ID)
                );
                if($UserFieldAr = $UserField->GetNext())
                {
                    return $UserFieldAr["VALUE"];
                } else {
                    return false;
                }
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
                $arItem["CATEGORY"] = GetListValueById($arItem["IBLOCK_ELEMENTS_ELEMENT_NEWS_CATEGORY_VALUE"]);
                $this->arResult[] = $arItem;
            }

            // кэш не затронет весь код ниже, он будут выполняться на каждом хите, здесь работаем с другим $arResult, будут доступны только те ключи массива, которые перечислены в вызове SetResultCacheKeys()
            if (isset($this->arResult)) {
                // ключи $arResult перечисленные при вызове этого метода, будут доступны в component_epilog.php и ниже по коду, обратите внимание там будет другой $arResult
                $this->SetResultCacheKeys(
                    array()
                );
                $current_link = $_SERVER["REQUEST_URI"];
                $compPage = '';
                if (str_contains($current_link, "page=detail&id=")) {
                    $this->IncludeComponentTemplate('detail');
                } else if ((str_contains($current_link, "?page=add_news"))) {
                    $this->IncludeComponentTemplate('add_news');
                } else if ((str_contains($current_link, "?page=send_form"))) {
                    $this->IncludeComponentTemplate('add_news_send');
                } else if ((str_contains($current_link, "?page=modify_news"))) {
                    $this->IncludeComponentTemplate('modify_news');
                } else if ((str_contains($current_link, "?page=send_modify_form"))) {
                    $this->IncludeComponentTemplate('modify_news_send');
                } else if ((str_contains($current_link, "?page=delete"))) {
                    $this->IncludeComponentTemplate('delete_news');
                } else if ((str_contains($current_link, "?page=add_category"))) {
                    $this->IncludeComponentTemplate('add_category');
                } else if ((str_contains($current_link, "?page=add_send_category"))) {
                    $this->IncludeComponentTemplate('add_category_send');
                } else if (str_contains($current_link, "?page=modify_category")) {
                    $this->IncludeComponentTemplate('modify_category');
                } else if (str_contains($current_link, "?page=mod_update_cat&id=")) {
                    $this->IncludeComponentTemplate('mod_update_cat');
                } else if (str_contains($current_link, "?page=mod_delete_cat&id=")) {
                    $this->IncludeComponentTemplate('mod_delete_cat');
                } else {
                    $this->IncludeComponentTemplate();
                }
                // подключаем шаблон и сохраняем кеш

            } else { // если выяснилось что кешировать данные не требуется, прерываем кеширование и выдаем сообщение «Страница не найдена»
                $this->AbortResultCache();
                \Bitrix\Iblock\Component\Tools::process404(
                    Loc::getMessage('PAGE_NOT_FOUND'),
                    true,
                    true
                );
            }
        }
    }
}
