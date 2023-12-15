<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1С-Битрикс: Управление сайтом");
?><div id="panel">
	 <?php $APPLICATION->ShowPanel();?>
</div>
<?$APPLICATION->IncludeComponent(
	"testname:mycomponent",
	"",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
		"IBLOCK_ID" => 1,
		"IBLOCK_TYPE" => "content",
		"NEWS_COUNT" => 5
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>