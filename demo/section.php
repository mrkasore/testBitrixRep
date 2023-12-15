<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1С-Битрикс: Управление сайтом");
?><div id="panel">
	 <?php $APPLICATION->ShowPanel();?>
</div>
 <?$APPLICATION->IncludeComponent(
	"tokmakov:iblock.section",
	"",
	Array(
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_COUNT" => "3",
		"ELEMENT_URL" => "item/id/#ELEMENT_ID#/",
		"IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "content",
		"MESSAGE_404" => "",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Элементы",
		"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_URL" => "category/id/#SECTION_ID#/",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_PAGE_TITLE" => "Y",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "N",
		"USE_CODE_INSTEAD_ID" => "N"
	)
);?> <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>