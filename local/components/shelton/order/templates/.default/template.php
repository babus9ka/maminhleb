<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST);
} else {
    echo "Ошибка: Данные не отправлены.";
}
die();
?>


<main class="desktop-container flex min-h-0 w-full min-w-0 grow flex-col p-6">
    <div class="mb-4 ml-4 2xl:absolute" bis_skin_checked="1">
        <button
            class="inline-flex h-11 w-fit items-center gap-1.5 rounded-lg bg-gray-200 px-4 text-gray-600 transition hover:bg-gray-300 dark:bg-gray-800 dark:text-gray-400 hover:dark:bg-gray-700">
            <span class="iconify i-ri:arrow-left-line icon" aria-hidden="true"></span>
            Назад
        </button>
    </div>
    <div class="mx-auto w-full max-w-[1146px] space-y-6" bis_skin_checked="1">
        <div class="flex items-center justify-between gap-3" bis_skin_checked="1">
            <h1 class="text-2xl !leading-none md:text-3xl dark:text-white">
                Оформление заказа
            </h1>
            <button
                class="flex items-center gap-1.5 text-base leading-tight text-red-500 underline-offset-4 hover:underline"
                aria-haspopup="dialog" aria-expanded="false" data-state="closed">
                <span class="iconify i-ri:delete-bin-2-fill icon text-xl" aria-hidden="true"></span>
                Очистить корзину
            </button>
        </div>
        <form class="flex gap-6">
            <div class="min-w-0 max-w-[686px] grow space-y-6 lg:shrink-0" bis_skin_checked="1">
                <div class="space-y-6 rounded-lg border bg-white p-6 dark:border-gray-800 dark:bg-gray-900 rounded-lg bg-white p-6 dark:bg-gray-900"
                    bis_skin_checked="1">
                    <h2 class="font-bold !leading-none lg:text-xl">Корзина</h2>
                    <div class="divide-y dark:divide-gray-800" bis_skin_checked="1" style="position: relative">
                        <div class="flex items-start gap-4 py-4" bis_skin_checked="1">
                            <div class="aspect-[4/3] w-28 shrink-0" bis_skin_checked="1">
                                <img loading="lazy" src="./Мамин хлеб_files/adi82361711376246.jpg" alt="Пицца колбасная"
                                    class="object-fit-custom h-full w-full rounded-md" />
                            </div>
                            <div class="space-y-2" bis_skin_checked="1">
                                <div class="space-y-1" bis_skin_checked="1">
                                    <div class="leading-none" bis_skin_checked="1">
                                        Пицца колбасная
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1 text-sm leading-none text-gray-400 dark:text-gray-400"
                                        bis_skin_checked="1">
                                        <!----><!---->
                                    </div>
                                </div>
                                <div class="flex items-center gap-2" bis_skin_checked="1">
                                    <button type="button" class="inline-flex">
                                        <span class="iconify i-ri:subtract-line icon" aria-hidden="true"></span>
                                    </button>
                                    <div class="relative grid min-w-10 place-items-center text-center text-xl"
                                        bis_skin_checked="1">
                                        <span class="iconify i-ri:loader-4-line icon absolute h-5 w-5 animate-spin"
                                            aria-hidden="true" style="display: none"></span><span class="">5</span>
                                    </div>
                                    <button type="button" class="inline-flex">
                                        <span class="iconify i-ri:add-line icon" aria-hidden="true"></span>
                                    </button>
                                </div>
                                <div class="flex items-center gap-2" bis_skin_checked="1">
                                    <!----><span class="text-lg leading-none">3&nbsp;450 ₽</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---->
                </div>
                <!----><!---->
            </div>
            <div class="min-w-0 max-w-[425px] grow space-y-6 lg:shrink-0" bis_skin_checked="1">
                <div class="space-y-6 rounded-lg border bg-white p-6 dark:border-gray-800 dark:bg-gray-900"
                    bis_skin_checked="1">
                    <section class="space-y-3">
                        <h2 class="font-bold !leading-none lg:text-xl">
                            Контактные данные
                        </h2>
                        <div class="flex flex-col gap-3" bis_skin_checked="1">
                            <div class="relative w-full" bis_skin_checked="1">
                                <input
                                    class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500 scroll-mt-[calc(var(--sticky-top-offset)+2.5rem)]"
                                    placeholder=" " autocomplete="off" type="text" required="" /><span
                                    class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">Имя</span>
                            </div>
                            <div class="relative w-full" bis_skin_checked="1">
                                <input
                                    class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500 scroll-mt-[calc(var(--sticky-top-offset)+2.5rem)]"
                                    placeholder=" " autocomplete="off" type="text" inputmode="numeric"
                                    required="" /><span
                                    class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">Номер
                                    телефона</span>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="space-y-6 rounded-lg border bg-white p-6 dark:border-gray-800 dark:bg-gray-900"
                    bis_skin_checked="1">
                    <section class="space-y-2 rounded-lg bg-gray-100 px-4 py-1 dark:bg-gray-800 !bg-transparent !p-0">
                        <h2 class="font-bold !leading-none lg:text-xl pt-3">
                            Тип заказа: Доставка <span> ~60 мин </span>
                        </h2>
                        <div class="divide-y divide-gray-300 dark:divide-gray-700" bis_skin_checked="1">
                            <div class="relative flex items-center gap-2.5 py-2.5 leading-none cursor-pointer pr-8"
                                bis_skin_checked="1">
                                <span class="iconify i-ri:map-pin-line icon" aria-hidden="true"></span>
                                <div class="space-y-1" bis_skin_checked="1">
                                    <div bis_skin_checked="1">
                                        улица Софьи Ковалевской, 4А
                                    </div>
                                    <div class="text-sm leading-none text-gray-500" bis_skin_checked="1">
                                        подъезд 5, домофон 456, этаж 3, квартира 7
                                    </div>
                                    <!----><!---->
                                </div>
                                <span class="iconify i-ri:arrow-right-s-line icon absolute right-0"
                                    aria-hidden="true"></span>
                            </div>
                            <div class="relative flex items-center gap-2.5 py-2.5 leading-none cursor-pointer pr-8"
                                type="button" aria-haspopup="dialog" aria-expanded="false" data-state="closed"
                                bis_skin_checked="1">
                                <span class="iconify i-ri:chat-history-line icon" aria-hidden="true"></span>
                                <div bis_skin_checked="1">Укажите дату и время</div>
                                <span class="iconify i-ri:arrow-right-s-line icon absolute right-0"
                                    aria-hidden="true"></span>
                            </div>
                            <div class="relative flex items-center gap-2.5 py-2.5 leading-none cursor-pointer pr-8"
                                type="button" aria-haspopup="dialog" aria-expanded="false" data-state="closed"
                                bis_skin_checked="1">
                                <span class="iconify i-ri:message-3-line icon" aria-hidden="true"></span>
                                <div class="truncate" bis_skin_checked="1">
                                    Комментарий к заказу
                                </div>
                                <span class="iconify i-ri:arrow-right-s-line icon absolute right-0"
                                    aria-hidden="true"></span>
                            </div>
                            <div class="relative flex items-center gap-2.5 py-2.5 leading-none justify-between"
                                bis_skin_checked="1">
                                <label for="call" class="flex items-center gap-2"><span
                                        class="iconify i-ri:phone-line icon" aria-hidden="true"></span>
                                    <div bis_skin_checked="1">
                                        Перезвонить мне?
                                    </div>
                                </label><button type="button" aria-pressed="false" data-state="off"
                                    class="group inline-flex h-8 w-16 items-center rounded-full bg-gray-200 p-0.5 transition data-[state=on]:bg-primary dark:bg-gray-950"
                                    id="call">
                                    <span
                                        class="h-7 w-7 translate-x-0 rounded-full bg-white transition group-data-[state=on]:translate-x-8"></span><!----></button><!---->
                            </div>
                        </div>
                    </section>
                </div>
                <div class="space-y-6 rounded-lg border bg-white p-6 dark:border-gray-800 dark:bg-gray-900 sticky top-[calc(var(--sticky-top-offset)+1.5rem)]"
                    bis_skin_checked="1">
                    <section class="space-y-2" style="position: relative">
                        <h2 class="font-bold !leading-none lg:text-xl">
                            Способ оплаты
                        </h2>
                        <div role="radiogroup" aria-required="true" dir="ltr" tabindex="0" class="flex flex-col gap-2"
                            style="outline: none; position: relative" bis_skin_checked="1">
                            <button class="group flex items-center gap-3 py-1" tabindex="-1" data-active="true"
                                data-reka-collection-item="" role="radio" type="button" aria-checked="true"
                                data-state="checked" required="true" value="yandex_kassa">
                                <div class="grid h-6 w-6 shrink-0 place-items-center rounded-full border-2 bg-white transition group-data-[state=checked]:border-primary dark:border-gray-800 dark:bg-gray-900"
                                    bis_skin_checked="1">
                                    <span data-state="checked"
                                        class="h-3 w-3 rounded-full bg-primary data-[state=checked]:animate-fadeIn"></span>
                                </div>
                                <div class="text-left leading-none" bis_skin_checked="1">
                                    Банковской картой
                                </div>
                                <div class="ml-auto grid shrink-0 place-items-center" bis_skin_checked="1">
                                    <img src="./Мамин хлеб_files/payment-cards.svg" alt="" />
                                </div>
                                <!---->
                            </button><!----><!---->
                        </div>
                    </section>
                    <section class="space-y-2 rounded-lg bg-gray-100 px-4 py-1 dark:bg-gray-800">
                        <!---->
                        <div class="divide-y divide-gray-300 dark:divide-gray-700" bis_skin_checked="1">
                            <div class="relative flex items-center gap-2.5 py-2.5 leading-none" type="button"
                                aria-haspopup="dialog" aria-expanded="false" data-state="closed" bis_skin_checked="1">
                                <span class="iconify i-ri:percent-line icon" aria-hidden="true"></span>
                                <div class="flex w-full flex-wrap items-center gap-x-1" bis_skin_checked="1">
                                    <span>Промокод</span><button type="button"
                                        class="inline-flex border-transparent bg-primary text-white focus-visible:ring-primary/30 disabled:cursor-not-allowed items-center justify-center rounded-md border px-4 py-3 text-center leading-none transition focus-visible:outline-none focus-visible:ring-4 disabled:opacity-50 ml-auto h-7"
                                        data-v-wave-boundary="true">
                                        <div class="w-full" bis_skin_checked="1">
                                            Ввести
                                        </div>
                                        <span class="iconify i-ri:loader-4-line icon absolute animate-spin"
                                            aria-hidden="true" style="display: none"></span>
                                    </button>
                                </div>
                                <!---->
                            </div>
                            <!---->
                        </div>
                    </section>
                    <section class="space-y-2">
                        <!---->
                        <h2 class="font-bold !leading-none lg:text-xl">
                            Детали заказа
                        </h2>
                        <div class="space-y-1.5" bis_skin_checked="1">
                            <div class="flex justify-between gap-2" bis_skin_checked="1">
                                <div bis_skin_checked="1">Товаров на сумму</div>
                                <div class="whitespace-nowrap" bis_skin_checked="1">
                                    3&nbsp;450 ₽
                                </div>
                            </div>
                            <div class="flex justify-between gap-2" bis_skin_checked="1">
                                <div bis_skin_checked="1">Доставка</div>
                                <div class="whitespace-nowrap" bis_skin_checked="1">
                                    0 ₽
                                </div>
                            </div>
                            <div class="flex justify-between gap-2" bis_skin_checked="1">
                                <div bis_skin_checked="1">Скидка</div>
                                <div class="whitespace-nowrap" bis_skin_checked="1">
                                    0 ₽
                                </div>
                            </div>
                            <!---->
                            <div class="flex justify-between gap-2 font-bold" bis_skin_checked="1">
                                <div class="!leading-none lg:text-lg" bis_skin_checked="1">
                                    Итого
                                </div>
                                <div class="whitespace-nowrap" bis_skin_checked="1">
                                    3&nbsp;450 ₽
                                </div>
                            </div>
                        </div>
                    </section>
                    <!---->
                    <div class="sticky bottom-4" bis_skin_checked="1">
                        <button type="submit"
                            class="flex w-full border-transparent bg-primary text-white focus-visible:ring-primary/30 disabled:cursor-not-allowed items-center justify-center rounded-md border px-4 py-3 text-center leading-none transition focus-visible:outline-none focus-visible:ring-4 disabled:opacity-50 !h-14 shadow-md"
                            data-v-wave-boundary="true">
                            <div class="w-full" bis_skin_checked="1">
                                <div class="flex w-full items-center justify-between gap-1.5 px-1 text-lg leading-none"
                                    bis_skin_checked="1">
                                    <span>Заказать</span><span class="whitespace-nowrap">3&nbsp;450 ₽</span>
                                </div>
                            </div>
                            <span class="iconify i-ri:loader-4-line icon absolute animate-spin" aria-hidden="true"
                                style="display: none"></span>
                        </button>
                    </div>
                    <div class="flex gap-3 text-xs leading-none" bis_skin_checked="1">
                        <input type="checkbox"
                            class="h-5 w-5 rounded border-gray-300 text-primary transition focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/30 focus:ring-offset-0 dark:border-gray-800 dark:bg-gray-950 scroll-m-20"
                            id="agreement-v-4-0-4" required="" /><label for="agreement-v-4-0-4"
                            class="block text-left text-gray-600 dark:text-gray-400">
                            Я даю
                            <a href="https://dostavka.maminhleb.ru/agreement" rel="noopener noreferrer" target="_blank"
                                class="font-semibold text-primary hover:underline">согласие</a>
                            на обработку моих персональных данных, в соответствии с
                            Федеральным законом от 27.07.2006 г. №152-ФЗ "О
                            персональных данных", на условиях, определенных
                            <a href="https://dostavka.maminhleb.ru/privacy" rel="noopener noreferrer" target="_blank"
                                class="font-semibold text-primary hover:underline">политикой</a>
                            в области обработки и обеспечения безопасности
                            персональных данных
                        </label>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        BX.ajax.runComponentAction('shelton:order', 'checkBasketAndAddressSession', {
            mode: 'class',
            data: {}
        }).then(function (response) {
            if (response.data.status === 'error') {
                window.location.href = response.data.redirect;
            }
        }).catch(function (error) {
            console.log(error);
        });

        BX.ajax.runComponentAction('shelton:order', 'getBasket', {
            mode: 'class',
            data: {}
        }).then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        })
    });
</script>