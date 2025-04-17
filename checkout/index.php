<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");
?>





<main class="desktop-container flex min-h-0 w-full min-w-0 grow flex-col p-6">
    <div class="mb-4 ml-4 2xl:absolute">
        <button
            class="inline-flex h-11 w-fit items-center gap-1.5 rounded-lg bg-gray-200 px-4 text-gray-600 transition hover:bg-gray-300 dark:bg-gray-800 dark:text-gray-400 hover:dark:bg-gray-700"
            onclick="window.location.href='/'">
            <span class="iconify i-ri:arrow-left-line icon" aria-hidden="true"></span>
            Назад
        </button>
    </div>
    <div class="mx-auto w-full max-w-[1146px] space-y-6">
        <div class="flex items-center justify-between gap-3">
            <h1 class="text-2xl !leading-none md:text-3xl dark:text-white">
                Оформление заказа
            </h1>
            <button id="clearBasket"
                class="flex items-center gap-1.5 text-base leading-tight text-red-500 underline-offset-4 hover:underline"
                aria-haspopup="dialog" aria-expanded="false" data-state="closed">
                <span class="iconify i-ri:delete-bin-2-fill icon text-xl" aria-hidden="true"></span>
                Очистить корзину
            </button>
        </div>
        <form action="" class="flex gap-6" method="POST" id="orderForm"
            data-user-auth="<?= $USER->IsAuthorized() ? 'Y' : 'N' ?>">

            <? $APPLICATION->IncludeComponent(
                "shelton:basket",
                "order",
                array()
            );
            ?>

            <? $APPLICATION->IncludeComponent(
                "shelton:order",
                "",
                array()
            );
            ?>
        </form>

        <?
        $APPLICATION->IncludeComponent(
            "shelton:address",
            "",
            array()
        );
        ?>
    </div>
</main>


<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>