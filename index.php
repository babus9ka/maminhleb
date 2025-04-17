<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Главная');
?>


<div class="desktop-container relative flex w-full">


    <? $APPLICATION->IncludeComponent(
        "bitrix:catalog.section.list",
        "section-sidebar",
        array(
            "ADDITIONAL_COUNT_ELEMENTS_FILTER" => "additionalCountFilter",
            "ADD_SECTIONS_CHAIN" => "Y",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "COUNT_ELEMENTS" => "Y",
            "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
            "FILTER_NAME" => "sectionsFilter",
            "HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N",
            "HIDE_SECTION_NAME" => "N",
            "IBLOCK_ID" => "1",
            "IBLOCK_TYPE" => "catalog",
            "SECTION_CODE" => "",
            "SECTION_FIELDS" => array("CODE", "NAME", "PICTURE", ""),
            "SECTION_ID" => $_REQUEST["SECTION_ID"],
            "SECTION_URL" => "",
            "SECTION_USER_FIELDS" => array("", ""),
            "SHOW_PARENT_NAME" => "Y",
            "TOP_DEPTH" => "2",
            "VIEW_MODE" => "LINE"
        )
    ); ?>


    <main class="mx-auto flex w-full min-w-0 max-w-[1570px] flex-col px-4 py-6 max-lg:pt-3 lg:px-6">
        <!--[-->
        <div class="flex min-h-0 grow flex-col gap-y-8">

            <? $APPLICATION->IncludeComponent(
                "shelton:time-work",
                "",
                array(
                    "END_TIME" => "20:30",
                    "START_TIME" => "09:30"
                )
            ); ?>

            <div class="relative w-full max-w-full mb-4" data-v-2a8a35d4="" data-v-9c9e2ac1="">

                <!-- СЛАЙДЕР НА ГЛАВНОЙ -->
                <? $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "main.slider",
                    array(
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "AJAX_MODE" => "Y",
                        "IBLOCK_TYPE" => "content",
                        "IBLOCK_ID" => "2",
                        "NEWS_COUNT" => "20",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_ORDER1" => "DESC",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER2" => "ASC",
                        "FILTER_NAME" => "",
                        "FIELD_CODE" => array(
                            0 => "ID",
                            1 => "NAME",
                            2 => "DETAIL_PICTURE",
                            3 => "",
                        ),
                        "PROPERTY_CODE" => array(
                            0 => "",
                            1 => "DESCRIPTION",
                            2 => "",
                        ),
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "SET_TITLE" => "Y",
                        "SET_BROWSER_TITLE" => "Y",
                        "SET_META_KEYWORDS" => "Y",
                        "SET_META_DESCRIPTION" => "Y",
                        "SET_LAST_MODIFIED" => "Y",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                        "ADD_SECTIONS_CHAIN" => "Y",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                        "CACHE_FILTER" => "Y",
                        "CACHE_GROUPS" => "Y",
                        "DISPLAY_TOP_PAGER" => "Y",
                        "DISPLAY_BOTTOM_PAGER" => "Y",
                        "PAGER_TITLE" => "Новости",
                        "PAGER_SHOW_ALWAYS" => "Y",
                        "PAGER_TEMPLATE" => "",
                        "PAGER_DESC_NUMBERING" => "Y",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "Y",
                        "PAGER_BASE_LINK_ENABLE" => "Y",
                        "SET_STATUS_404" => "Y",
                        "SHOW_404" => "Y",
                        "MESSAGE_404" => "",
                        "PAGER_BASE_LINK" => "",
                        "PAGER_PARAMS_NAME" => "arrPager",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "COMPONENT_TEMPLATE" => "main.slider",
                        "STRICT_SECTION_CHECK" => "N",
                        "FILE_404" => ""
                    ),
                    false
                ); ?>



            </div>

            <? $APPLICATION->IncludeComponent(
                "shelton:catalog.section.element.list",
                "",
                array(
                    "CACHE_TIME" => "3600",
                    "CACHE_TYPE" => "A",
                    "END_TIME" => "20:00",
                    "IBLOCK_ID" => "1",
                    "IBLOCK_TYPE" => "catalog",
                    "START_TIME" => "10:00"
                )
            ); ?>


        </div>
        <!--]-->




    </main>
    <aside
        class="sticky top-[--sticky-top-offset] h-fit max-h-[calc(100vh-var(--sticky-top-offset))] min-h-0 shrink-0 overflow-y-auto overflow-x-hidden px-2 py-6 scrollbar-thin max-lg:pt-3 w-80 lg:w-[400px] lg:px-6"
        style="scrollbar-gutter: stable">
        <div class="space-y-3">

            <? $APPLICATION->IncludeComponent(
                "shelton:basket",
                "",
                array()
            );
            ?>

        </div>
    </aside>
</div>

<?
$APPLICATION->IncludeComponent(
    "shelton:address",
    "",
    array()
);
?>

<form style="opacity: 0" id="thirdForm" action="/checkout/" method="POST">
    <input type="hidden" name="delivery_option" id="thirdDeliveryOption" value="">
    <input type="hidden" name="address" id="thirdAddress" value="">
    <input type="hidden" name="entrance" id="thirdEntrance" value="">
    <input type="hidden" name="intercom" id="thirdIntercom" value="">
    <input type="hidden" name="floor" id="thirdFloor" value="">
    <input type="hidden" name="apartment" id="thirdApartment" value="">
    <!-- Новое скрытое поле для выбранного адреса склада -->
    <input type="hidden" name="address-comment" id="thirdAddressComment" value="">
    <input type="hidden" id="thirdSelectedAddress" name="selected_address" value="">
    <button type="submit">Отправить данные</button>
</form>

<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>