<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>

<div class="min-w-0 max-w-[686px] grow space-y-6 lg:shrink-0">
    <div id="basketList"
        class="space-y-6 rounded-lg border bg-white p-6 dark:border-gray-800 dark:bg-gray-900 rounded-lg bg-white p-6 dark:bg-gray-900">
        <!-- <h2 class="font-bold !leading-none lg:text-xl">Корзина</h2> -->
        <div id="basketTemplate" class="divide-y dark:divide-gray-800" style="position: relative">
            <div class="flex items-start gap-4 py-4">
                <div class="aspect-[4/3] w-28 shrink-0">
                    <img id="productImage" loading="lazy" src="" alt=""
                        class="object-fit-custom h-full w-full rounded-md" />
                </div>
                <div class="space-y-2">
                    <div class="space-y-1">
                        <div class="leading-none product-name">
                        </div>
                        <div
                            class="product-gramm flex flex-wrap items-center gap-1 text-sm leading-none text-gray-400 dark:text-gray-400">
                        </div>
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
    </div>
</div>

<?
$this->addExternalJS(SITE_TEMPLATE_PATH . "/js/basket/index.js");
?>