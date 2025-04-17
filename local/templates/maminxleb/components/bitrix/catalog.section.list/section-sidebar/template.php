<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arViewStyles = array(
	'LINE' => array(
		'CONT' => 'bx_catalog_line',
		'TITLE' => 'bx_catalog_line_category_title',
		'LIST' => 'bx_catalog_line_ul',
		'EMPTY_IMG' => $this->GetFolder() . '/images/line-empty.png'
	),
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?>
<?
if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID']) {
	$this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
	$this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

	?>
	<h1 class="<? echo $arCurView['TITLE']; ?>" id="<? echo $this->GetEditAreaId($arResult['SECTION']['ID']); ?>"><a
			href="<? echo $arResult['SECTION']['SECTION_PAGE_URL']; ?>">
			<?
			echo (
				isset($arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]) && $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != ""
				? $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
				: $arResult['SECTION']['NAME']
			);
			?>
		</a></h1>
	<?
}

?>
<aside
	class="sticky top-[--sticky-top-offset] h-fit max-h-[calc(100vh-var(--sticky-top-offset))] w-[260px] shrink-0 overflow-y-auto p-6 scrollbar-thin 2xl:pl-8 hidden lg:block">
	<?
	if (0 < $arResult["SECTIONS_COUNT"]) {
		?>

		<?
		switch ($arParams['VIEW_MODE']) {
			case 'LINE':
				foreach ($arResult['SECTIONS'] as &$arSection) {
					$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
					$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
					?>
					<div class="flex flex-col gap-1.5" >
						<a class="section_catalog_from_scroll" href="#<?= $arSection['CODE'] ?>"
							class="flex items-center gap-2 rounded border px-2.5 py-2 text-base leading-none transition hover:bg-white hover:dark:bg-gray-900 border-transparent"
							data-v-wave-boundary="true">
							<img src="<?= $arSection["PICTURE"]["SRC"]; ?>" alt="" class="h-9 w-12 rounded-sm object-cover" />
							<span class=""><?= $arSection["NAME"] ?></span>
						</a>
					</div>
					<?
				}
				unset($arSection);
				break;
		}
		?>
		<?
		echo ('LINE' != $arParams['VIEW_MODE'] ? '<div style="clear: both;"></div>' : '');
	}
	?>
</aside>