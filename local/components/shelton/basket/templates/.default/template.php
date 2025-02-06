<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>

<div class="" bis_skin_checked="1">


    <div id="basket-container"
        class="space-y-4 overflow-hidden rounded-t-lg border border-b-0 bg-white p-4 dark:border-gray-800 dark:bg-gray-900"
        bis_skin_checked="1" style="position: relative;">


        <div class="flex items-center justify-between gap-2" bis_skin_checked="1">
            <div class="text-2xl leading-none" bis_skin_checked="1">Корзина</div>
            <div class="flex items-center gap-4" bis_skin_checked="1">
                <button
                    class="flex items-center gap-1.5 text-base leading-tight text-red-500 underline-offset-4 hover:underline"
                    aria-haspopup="dialog" aria-expanded="false" data-state="closed"><span
                        class="iconify i-ri:delete-bin-2-fill icon text-xl" aria-hidden="true"></span>
                </button>
            </div>
        </div>


        <div id="basket-item-template" class="hidden">
            <div class="flex items-start gap-4 py-4">
                <div class="aspect-[4/3] w-28 shrink-0">
                    <img src="" alt="" class="object-fit-custom h-full w-full rounded-md">
                </div>
                <div class="space-y-2">
                    <div class="space-y-1">
                        <div class="leading-none product-name"></div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" class="inline-flex decrease-quantity">
                            <span class="iconify i-ri:subtract-line icon" aria-hidden="true"></span>
                        </button>
                        <div class="relative grid min-w-10 place-items-center text-center text-xl">
                            <span class="product-quantity"></span>
                        </div>
                        <button type="button" class="inline-flex increase-quantity">
                            <span class="iconify i-ri:add-line icon" aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-lg leading-none product-price"></span>
                    </div>
                </div>
            </div>
        </div>

        <section class="space-y-2" cart="[object Object]">
            <div class="text-lg font-bold leading-none" bis_skin_checked="1"> Детали заказа </div>
            <div class="space-y-1.5" bis_skin_checked="1">
                <div class="flex justify-between gap-2" bis_skin_checked="1">
                    <div bis_skin_checked="1">Товаров на сумму</div>
                    <div class="whitespace-nowrap" bis_skin_checked="1">123 ₽</div>
                </div>
                <div class="flex justify-between gap-2 font-bold" bis_skin_checked="1">
                    <div class="!leading-none lg:text-lg" bis_skin_checked="1">Итого</div>
                    <div class="whitespace-nowrap" bis_skin_checked="1">123 ₽</div>
                </div>
            </div>
        </section>


    </div>

    <div class="rounded-b-lg border border-t-0 bg-white p-4 dark:border-gray-800 dark:bg-gray-900" bis_skin_checked="1">
        <button id="orderButton" type="submit"
            class="flex w-full border-transparent bg-primary text-white focus-visible:ring-primary/30 disabled:cursor-not-allowed items-center justify-center rounded-md border px-4 py-3 text-center leading-none transition focus-visible:outline-none focus-visible:ring-4 disabled:opacity-50"
            disabled="" data-v-wave-boundary="true">
            <div class="w-full" bis_skin_checked="1">
                <div class="flex items-center justify-between gap-3" bis_skin_checked="1">
                    Перейти к оформлению
                    <span id="totalSum" class="whitespace-nowrap"></span>
                </div>
            </div>
            <span class="iconify i-ri:loader-4-line icon absolute animate-spin" aria-hidden="true"
                style="display: none"></span>
        </button>
    </div>
</div>

<?
$this->addExternalJS("/local/js/basket/index.js");
?>