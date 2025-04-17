<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>


<?
echo '<pre>';
print_r($_POST);
echo '</pre>';
?>

<?
$APPLICATION->IncludeFile(
    SITE_TEMPLATE_PATH . '/include/comment-model.php',
    array(),
    array()
);
?>

<?
$APPLICATION->IncludeFile(
    SITE_TEMPLATE_PATH . '/include/date-time-model.php',
    array('DATES' => $arResult['DATES']),
    array()
);
?>

<input type="hidden" name="order-comment" id="orderCommentHidden" value="">
<input type="hidden" name="order-date" id="orderDateHidden" value="">

<input type="hidden" name="delivery_option" id="thirdDeliveryOption"
    value="<?= isset($_POST['delivery_option']) ? htmlspecialchars($_POST['delivery_option']) : '' ?>">
<input type="hidden" name="address" id="thirdAddress"
    value="<?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?>">

<input type="hidden" name="entrance" id="thirdEntrance"
    value="<?= isset($_POST['entrance']) ? htmlspecialchars($_POST['entrance']) : '' ?>">

<input type="hidden" name="intercom" id="thirdIntercom"
    value="<?= isset($_POST['intercom']) ? htmlspecialchars($_POST['intercom']) : '' ?>">
<input type="hidden" name="floor" id="thirdFloor"
    value="<?= isset($_POST['floor']) ? htmlspecialchars($_POST['floor']) : '' ?>">
<input type="hidden" name="apartment" id="thirdApartment"
    value="<?= isset($_POST['apartment']) ? htmlspecialchars($_POST['apartment']) : '' ?>">
<input type="hidden" name="address-comment" id="thirdAddressComment"
    value="<?= isset($_POST['address-comment']) ? htmlspecialchars($_POST['address-comment']) : '' ?>">
<input type="hidden" id="thirdSelectedAddress" name="selected_address"
    value="<?= isset($_POST['selected_address']) ? htmlspecialchars($_POST['selected_address']) : '' ?>">

<div class="min-w-0 max-w-[425px] grow space-y-6 lg:shrink-0">
    <div class="space-y-6 rounded-lg border bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
        <section class="space-y-3">
            <h2 class="font-bold !leading-none lg:text-xl">Контактные данные</h2>
            <div class="flex flex-col gap-3">
                <div class="relative w-full">
                    <input id="name" name="name"
                        class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                        placeholder=" " autocomplete="off" type="text" required />
                    <span
                        class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">
                        Имя
                    </span>
                </div>

                <div class="relative w-full">
                    <input id="phone" name="phone"
                        class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                        placeholder=" " autocomplete="off" type="text" inputmode="numeric" required />
                    <span
                        class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">
                        Номер телефона
                    </span>
                </div>

                <div class="relative w-full hidden" id="email-wrapper">
                    <input id="email" name="email"
                        class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                        placeholder=" " autocomplete="off" type="email" />
                    <span
                        class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">
                        Email
                    </span>
                </div>
            </div>
        </section>
    </div>

    <div class="space-y-6 rounded-lg border bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
        <section class="space-y-2 rounded-lg bg-gray-100 px-4 py-1 dark:bg-gray-800 !bg-transparent !p-0">
            <h2 id="orderType" class="font-bold !leading-none lg:text-xl pt-3">
                Тип заказа: Доставка
            </h2>
            <div class="divide-y divide-gray-300 dark:divide-gray-700">

                <div id="orderButton" href="#address"
                    class="order-address-button relative flex items-center gap-2.5 py-2.5 leading-none cursor-pointer pr-8">
                    <span class="iconify i-ri:map-pin-line icon" aria-hidden="true"></span>
                    <div class="space-y-1">
                        <div id="deliveryAddress"></div>
                        <div id="deliveryAddressDetail" class="text-sm leading-none text-gray-500"></div>
                    </div>
                    <span class="iconify i-ri:arrow-right-s-line icon absolute right-0" aria-hidden="true"></span>
                </div>

                <div class="popup-datetime relative flex items-center gap-2.5 py-2.5 leading-none cursor-pointer pr-8"
                    type="button" aria-haspopup="dialog" aria-expanded="false" href="#dateTimeModal">
                    <span class="iconify i-ri:chat-history-line icon" aria-hidden="true"></span>
                    <div>Укажите дату</div>
                    <span class="iconify i-ri:arrow-right-s-line icon absolute right-0" aria-hidden="true"></span>
                </div>

                <div class="popup-comment relative flex items-center gap-2.5 py-2.5 leading-none cursor-pointer pr-8"
                    type="button" aria-haspopup="dialog" aria-expanded="false" href="#commentModal">
                    <span class="iconify i-ri:message-3-line icon" aria-hidden="true"></span>
                    <div class="truncate">Комментарий к заказу</div>
                    <span class="iconify i-ri:arrow-right-s-line icon absolute right-0" aria-hidden="true"></span>
                </div>
            </div>
        </section>
    </div>

    <div
        class="space-y-6 rounded-lg border bg-white p-6 dark:border-gray-800 dark:bg-gray-900 sticky top-[calc(var(--sticky-top-offset)+1.5rem)]">
        <section class="space-y-2" style="position: relative;">
            <h2 class="leading-none! font-bold lg:text-xl">Способ оплаты</h2>
            <input type="hidden" name="payment_type" id="payment_type" value="cod">

            <div class="payment-options">
                <button type="button" id="payment_cod" class="payment-option flex items-center gap-3 py-1" value="2">
                    <div
                        class="indicator-wrapper border-2 grid h-6 w-6 place-items-center rounded-full bg-white transition">
                        <span class="indicator h-3 w-3 rounded-full bg-primary"></span>
                    </div>
                    <div>Наличными курьеру</div>
                </button>

                <!-- Блок для ввода суммы сдачи -->
                <div id="change_block" class="flex flex-col gap-x-4 gap-y-2 change-amount"
                    style="display: flex; margin-top: 5px;">
                    <div class="flex w-full max-w-xs items-center gap-4">
                        <div class="relative w-full">
                            <input type="text" name="change_amount" id="change_amount"
                                class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/30"
                                placeholder=" " autocomplete="off" inputmode="numeric" required>
                            <span
                                class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all">
                                С какой суммы нужна сдача?
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Кнопка "Банковской картой" -->
                <button type="button" id="payment_card" class="payment-option flex items-center gap-3 py-1" value="3">
                    <div
                        class="indicator-wrapper border-2 grid h-6 w-6 place-items-center rounded-full bg-white transition">
                        <!-- Изначально без красного кружка -->
                        <span class="indicator h-3 w-3 rounded-full"></span>
                    </div>
                    <div>Банковской картой</div>
                </button>
            </div>

            <section class="space-y-2">
                <h2 class="leading-none! font-bold lg:text-xl">Детали заказа</h2>
                <div class="space-y-1.5">
                    <div class="flex justify-between gap-2">
                        <div>Товаров на сумму</div>
                        <div class="whitespace-nowrap" id="totalSum"></div>
                    </div>
                    <div class="flex justify-between gap-2">
                        <div>Скидка</div>
                        <div class="whitespace-nowrap">0 BYN</div>
                    </div>
                    <div class="flex justify-between gap-2 font-bold">
                        <div class="leading-none! lg:text-lg">Итого</div>
                        <div class="whitespace-nowrap" id="totalSum"></div>
                    </div>
                </div>
            </section>

            <div class="sticky bottom-4">
                <button type="submit" id="orderLogic"
                    class="flex w-full bg-primary focus-visible:ring-primary/30 border-transparent text-white disabled:cursor-not-allowed cursor-pointer items-center justify-center rounded-md border px-4 py-3 text-center leading-none transition focus-visible:ring-4 focus-visible:outline-hidden disabled:opacity-50 h-14! shadow-md"
                    data-v-wave-boundary="true">
                    <div class="w-full">
                        <div class="flex w-full items-center justify-between gap-1.5 px-1 text-lg leading-none">
                            <span>Заказать</span><span class="whitespace-nowrap" id="totalSum"></span>
                        </div>
                    </div>
                    <span class="iconify i-ri:loader-4-line icon absolute animate-spin" aria-hidden="true"
                        style="display: none;"></span>
                </button>
            </div>

            <div class="flex gap-3 text-xs leading-none">
                <input type="checkbox"
                    class="text-primary focus:border-primary focus:ring-primary/30 h-5 w-5 rounded border-gray-300 transition focus:ring-4 focus:ring-offset-0 focus:outline-hidden dark:border-gray-800 dark:bg-gray-950 scroll-m-20"
                    id="agreement-v-6-0-4" required="">
                <label for="agreement-v-6-0-4" class="block text-left text-gray-600 dark:text-gray-400">
                    Я даю
                    <a href="/agreement" rel="noopener noreferrer" target="_blank"
                        class="text-primary font-semibold hover:underline">
                        согласие
                    </a>
                    на обработку моих персональных данных, в соответствии с Федеральным законом
                    от 27.07.2006 г. №152-ФЗ "О персональных данных", на условиях, определенных
                    <a href="/privacy" rel="noopener noreferrer" target="_blank"
                        class="text-primary font-semibold hover:underline">
                        политикой
                    </a> в области обработки и обеспечения безопасности персональных данных
                </label>
            </div>
        </section>
    </div>
</div>

<style>
    .white-popup {
        position: relative;
        background: #fff;
        padding: 30px;
        width: 100%;
        max-width: 400px;
        margin: 40px auto;
        text-align: center;
        border-radius: 10px;
    }

    .white-popup h2 {
        font-size: 20px;
        margin-bottom: 15px;
    }

    .white-popup ul {
        list-style: none;
        padding: 0;
        margin-bottom: 20px;
        text-align: left;
    }

    .white-popup ul li {
        padding: 4px 0;
        color: #d60000;
    }

    .white-popup .close-popup {
        background: #333;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
    }

    .white-popup .close-popup:hover {
        background: #000;
    }
</style>

<div id="validation-error-popup" class="mfp-hide white-popup">
    <h2>Не заполнены поля</h2>
    <ul id="validation-error-list"></ul>
    <button class="close-popup">Закрыть</button>
</div>

<script>
    $(function () {
        var $buttons = $(".payment-option");
        var $changeBlock = $("#change_block");
        var $changeInput = $("#change_amount");
        var $paymentType = $("#payment_type");

        function updatePayment($button) {
            $buttons.removeClass("active");
            $buttons.find(".indicator").removeClass("bg-primary");
            $button.addClass("active");
            $button.find(".indicator").addClass("bg-primary");
            $paymentType.val($button.val());
            if ($button.val() === "2") {
                $changeBlock.show();
                $changeInput.prop("disabled", false).attr("required", true);
            } else {
                $changeBlock.hide();
                $changeInput.prop("disabled", true).removeAttr("required");
            }
        }

        $buttons.on("click", function () {
            updatePayment($(this));
        });

        var initialPayment = $paymentType.val();
        if (initialPayment === "2") {
            updatePayment($("#payment_cod"));
        } else {
            updatePayment($("#payment_card"));
        }
    });
</script>

<script>
    $(function () {
        // Логика для комментариев
        $('#saveCommentBtn').on('click', function () {
            var commentValue = $('#commentTextArea').val().trim();
            $('#orderCommentHidden').val(commentValue);
            $.magnificPopup.close();
        });

        // Инициализация Magnific Popup для комментариев
        $('.popup-comment').magnificPopup({
            type: 'inline',
            removalDelay: 300,
            mainClass: 'mfp-fade',
            closeBtnInside: true
        });
        $('#closeCommentModal').on('click', function () {
            $.magnificPopup.close();
        });
    });

    $(function () {
        // Логика для выбора даты/времени
        $('#closeDateTimeModal').on('click', function () {
            $.magnificPopup.close();
        });

        let selectedDate = null;
        const saveBtn = $('#saveDateTimeBtn');
        const container = $('#dateSwiper');
        const dateHiddenInput = $('#orderDateHidden');

        container.on('click', 'swiper-slide', function () {
            container.find('swiper-slide').removeClass('active');
            $(this).addClass('active');
            selectedDate = $(this).text().trim();
            saveBtn.prop('disabled', false);
        });

        let asapActive = false;
        $('#asapBtn').on('click', function () {
            asapActive = !asapActive;
            if (asapActive) {
                $(this).attr('data-state', 'on').attr('aria-pressed', 'true');
                selectedDate = 'Как можно скорее';
                container.find('swiper-slide').removeClass('active');
                saveBtn.prop('disabled', false);
            } else {
                $(this).attr('data-state', 'off').attr('aria-pressed', 'false');
                selectedDate = null;
                saveBtn.prop('disabled', true);
            }
        });

        saveBtn.on('click', function () {
            console.log('Выбрана дата:', selectedDate);
            dateHiddenInput.val(selectedDate);
            $.magnificPopup.close();
        });

        // Инициализация Magnific Popup для выбора даты/времени
        $('.popup-datetime').magnificPopup({
            type: 'inline',
            removalDelay: 300,
            mainClass: 'mfp-fade',
            closeBtnInside: true
        });
    });

</script>

<script>
    $(function () {
        $('.order-address-button').magnificPopup({
            type: 'inline',
            preloader: false,
            focus: '#username',
            modal: true
        });
        $(document).on('click', '#closedOrderContainer', function (e) {
            e.preventDefault();
            $.magnificPopup.close();
        });
    });
</script>

<?php
$this->addExternalJS(SITE_TEMPLATE_PATH . "/js/order/index.js");
?>