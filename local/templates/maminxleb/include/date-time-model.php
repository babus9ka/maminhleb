<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$dateList = $arParams['DATES'];
?>
<div id="dateTimeModal" class="mfp-hide">
    <div
        class="relative m-auto flex w-full min-w-0 flex-col gap-4 overflow-hidden rounded-lg bg-white shadow-md p-5 max-w-lg">
        <h2 class="pr-6 text-lg leading-none font-bold">Укажите дату и время заказа</h2>

        <div class="space-y-4">
            <swiper-container id="dateSwiper" class="swiper-container-date-order flex gap-2" space-between="8" slides-per-view="auto"
                free-mode="true" slide-to-clicked-slide="">
                <div class="swiper-wrapper">
                <?php foreach ($dateList as $date): ?>
                    <swiper-slide class="swiper-slide w-auto shrink-0 cursor-pointer">
                        <div
                            class="inline-flex rounded-md px-4 py-2 leading-none transition bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-white">
                            <?= htmlspecialchars($date) ?>
                        </div>
                    </swiper-slide>
                <?php endforeach; ?>
                </div>
            </swiper-container>

            <div class="flex items-center justify-between gap-4">
                <label for="asap" class="flex items-center gap-2">
                    <span class="iconify i-ri:run-fill icon"></span>
                    <div>Как можно скорее</div>
                </label>
                <button type="button" id="asapBtn" aria-pressed="false" data-state="off"
                    class="group data-[state=on]:bg-primary inline-flex h-8 w-16 items-center rounded-full bg-gray-200 p-0.5 transition dark:bg-gray-950">
                    <span
                        class="h-7 w-7 translate-x-0 rounded-full bg-white transition group-data-[state=on]:translate-x-8"></span>
                </button>
            </div>

            <button type="button" id="saveDateTimeBtn"
                class="flex w-full bg-primary border-transparent text-white disabled:cursor-not-allowed cursor-pointer items-center justify-center rounded-md border border-solid px-4 py-3 text-center leading-none transition focus-visible:ring-4 focus-visible:outline-hidden disabled:opacity-50"
                disabled>
                Сохранить
            </button>
        </div>

        <button type="button" class="absolute top-3 right-3 outline-hidden" id="closeDateTimeModal">
            <span class="iconify i-ri:close-fill icon text-gray-500 dark:text-gray-500" aria-hidden="true"></span>
        </button>
    </div>
</div>