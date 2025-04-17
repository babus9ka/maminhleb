<swiper-container style="margin-bottom: 20px;" init="false"
    class="swiper-container overflow-hidden mx-auto flex h-full w-full max-w-full items-center gap-3 rounded-lg"
    data-v-9c9e2ac1="" ref_key="swiperContainerRef" ref="[object Object]">

    <div class="swiper-wrapper">
        <?

        foreach ($arResult['ITEMS'] as $slide) {
            ?>
            <swiper-slide lazy="true" class="swiper-slide grid h-auto max-w-full shrink-0 place-items-center w-auto"
                data-v-2a8a35d4="" style="margin-right: 12px">
                <template shadowrootmode="open">
                    <slot></slot>
                </template>
                <img loading="lazy" img src="<?= $slide['DETAIL_PICTURE']['SRC'] ?>" alt="<?= $slide['NAME'] ?>"
                    class="rounded-lg object-fit-custom max-h-[425px]" data-v-2a8a35d4="" />
            </swiper-slide>
            <?
        }
        ?>


    </div>


</swiper-container>