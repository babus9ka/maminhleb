<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die(); ?>

<div class="space-y-8" >

    <?php foreach ($arResult['SECTIONS'] as $section): ?>

        <section class="space-y-4">
            <div id="<?= $section['CODE'] ?>" class="flex items-end justify-between gap-4" >
                <a href="#">
                    <h2 class="text-2xl !leading-none md:text-3xl dark:text-white">
                        <?= ($section['NAME']) ?>
                    </h2>
                </a>
            </div>

            <div class="relative w-full max-w-ful swiper mySwiper">
                <!-- Инициализация Swiper -->
                <swiper-container class="swiper-container swiper-wrapper" slides-per-view="auto" space-between="8"
                    loop="true">

                    <?php
                    $hasProducts = false;
                    foreach ($arResult['PRODUCTS'] as $product):
                        if (in_array($section['ID'], (array) $product['IBLOCK_SECTION_ID'])):
                            ?>

                            <swiper-slide class="swiper-slide">
                                <div class="flex h-full flex-col rounded-lg border bg-white dark:border-gray-800 dark:bg-gray-900">
                                    <div class="relative m-1.5 cursor-pointer">
                                        <div class="aspect-[4/3]">
                                            <img loading="lazy" src="<?= $product['DETAIL_PICTURE'] ?>" alt="Изображение товара"
                                                class="object-fit-custom h-full w-full rounded-md" width="600" height="450" />
                                        </div>
                                    </div>
                                    <div class="flex min-h-0 grow flex-col gap-1 p-2 lg:gap-2.5 lg:p-3">
                                        <div class="line-clamp-3 break-words h-16 pb-0.5 !leading-none lg:text-lg">
                                            <?= $product["NAME"] ?>
                                        </div>
                                        <div class="text-sm text-gray-400 dark:text-gray-400">
                                            <?= $product["PROPERTY_GRAMM_VALUE"] ?> гр.
                                        </div>
                                        <div class="mt-auto flex items-center gap-1.5 justify-between">
                                            <div class="whitespace-nowrap !leading-none text-lg lg:text-xl">
                                                <?= $product["PRICE"] ?> BYN
                                            </div>
                                            <button type="button" aria-label="Добавить"
                                                class="grid h-8 w-8 shrink-0 place-items-center rounded-lg border border-transparent text-primary transition lg:h-11 lg:w-11 bg-primary/25"
                                                data-product-id="<?= $product['ID'] ?>"
                                                data-product-price="<?= $product["PRICE"] ?>"
                                                data-product-name="<?= $product["NAME"] ?>"
                                                data-product-image="<?= CFile::GetPath($product['DETAIL_PICTURE']) ?>">
                                                <span class="iconify i-ri:add-line icon" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </swiper-slide>

                        <? endif; endforeach; ?>

                </swiper-container>
            </div>
        </section>

    <? endforeach ?>

</div>