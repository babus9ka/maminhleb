<?php
// $APPLICATION->IncludeComponent(
//     "shelton:auth.registration",
//     "",
//     []
// );
?>





<div id="authModal" aria-describedby="reka-dialog-description-v-1" aria-labelledby="reka-dialog-title-v-0"
    data-state="open" tabindex="-1"
    class="relative m-auto flex w-full min-w-0 flex-col gap-4 overflow-hidden rounded-lg bg-white shadow-md data-[state=closed]:animate-fadeOut data-[state=open]:animate-contentShow focus:outline-none dark:bg-black p-5 max-w-lg mfp-hide white-popup-block"
    style="pointer-events: auto; " >
    <h2 id="reka-dialog-title-v-0" class="pr-6 text-lg font-bold leading-none hidden"></h2>
    <div id="reka-dialog-description-v-1" class="space-y-4" >
        <div class="mx-auto flex min-h-0 max-w-lg grow flex-col gap-6 p-6 text-center" >
            <div class="flex min-h-0 grow flex-col items-center justify-center gap-12" ><img src=""
                    alt="" class="mx-auto max-h-20 rounded-sm">
                <div class="w-full space-y-4" >
                    <div class="flex items-center justify-center gap-6 text-xl leading-none text-gray-400 dark:text-gray-500"
                        >
                        <button id="authButton" class="font-bold text-gray-800 dark:text-gray-200">Вход</button>
                        <button id="registerButton" class=""> Регистрация </button>
                    </div>
                    <form id="authForm" class="" class="w-full space-y-4">
                        <div id="authError" style="color:red;"></div>
                        <input type="hidden" name="action" value="auth">
                        <div class="relative w-full"  style="margin-bottom: 10px;"><input
                                class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                                placeholder=" " autocomplete="off" type="text" name="phone" required=""><span
                                class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">Номер
                                телефона</span></div>
                        <div class="relative w-full"  style="margin-bottom: 10px;"><input
                                class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                                placeholder=" " autocomplete="off" type="password" name="password" required=""><span
                                class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">Пароль</span>
                        </div><button type="button" class="text-gray-500 underline dark:text-gray-500"> Забыли пароль?
                        </button><button type="submit"
                            class="flex w-full border-transparent bg-primary text-white focus-visible:ring-primary/30 disabled:cursor-not-allowed items-center justify-center rounded-md border px-4 py-3 text-center leading-none transition focus-visible:outline-none focus-visible:ring-4 disabled:opacity-50 h-12"
                            data-v-wave-boundary="true">
                            <div class="w-full" > Войти </div><span
                                class="iconify i-ri:loader-4-line  icon absolute animate-spin" aria-hidden="true"
                                style="display: none;"></span>
                        </button>
                    </form>
                    <form id="registerForm" class="" class="w-full space-y-4">
                        <div id="registerError" style="color:red;"></div>
                        <input type="hidden" name="action" value="register">
                        <div class="relative w-full"  style="margin-bottom: 10px;">
                            <input
                                class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                                placeholder=" " autocomplete="off" type="text" name="phone" required="">
                            <span
                                class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">Номер
                                телефона</span>
                        </div>
                        <div class="relative w-full"  style="margin-bottom: 10px;">
                            <input
                                class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                                placeholder=" " autocomplete="off" type="text" name="name" required="">
                            <span
                                class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">Имя</span>
                        </div>
                        <div class="relative w-full"  style="margin-bottom: 10px;">
                            <input
                                class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                                placeholder=" " autocomplete="off" type="text" name="email" required="">
                            <span
                                class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">Почта</span>
                        </div>
                        <div class="relative w-full"  style="margin-bottom: 10px;">
                            <input
                                class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                                placeholder=" " autocomplete="off" type="password" name="password" required="">
                            <span
                                class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">Пароль</span>
                        </div>
                        <div class="relative w-full"  style="margin-bottom: 10px;">
                            <input
                                class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                                placeholder=" " autocomplete="off" type="password" name="password_confirm" required="">
                            <span
                                class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">Подтвердите
                                пароль</span>
                        </div>

                        <button type="submit"
                            class="flex w-full border-transparent bg-primary text-white focus-visible:ring-primary/30 disabled:cursor-not-allowed items-center justify-center rounded-md border px-4 py-3 text-center leading-none transition focus-visible:outline-none focus-visible:ring-4 disabled:opacity-50 h-12"
                            data-v-wave-boundary="true">
                            <div class="w-full" > Зарегистироваться </div><span
                                class="iconify i-ri:loader-4-line  icon absolute animate-spin" aria-hidden="true"
                                style="display: none;"></span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <button type="button" class="absolute right-3 top-3 outline-none popup-modal-dismiss closeAuthModalButton">
        <span class="iconify i-ri:close-fill icon text-gray-500 dark:text-gray-500" aria-hidden="true"></span>
    </button>
</div>

<script>
    $(document).ready(function () {
        // Скрываем форму регистрации по умолчанию
        $('#registerForm').hide();

        // При клике на кнопку "Регистрация"
        $('#registerButton').on('click', function () {
            // Переносим классы с кнопки "Вход" на кнопку "Регистрация"
            $('#authButton').removeClass('font-bold text-gray-800 dark:text-gray-200');
            $('#registerButton').addClass('font-bold text-gray-800 dark:text-gray-200');

            // Скрываем форму авторизации и показываем форму регистрации
            $('#authForm').hide();
            $('#registerForm').fadeIn();
        });

        // При клике на кнопку "Вход"
        $('#authButton').on('click', function () {
            // Переносим классы с кнопки "Регистрация" на кнопку "Вход"
            $('#registerButton').removeClass('font-bold text-gray-800 dark:text-gray-200');
            $('#authButton').addClass('font-bold text-gray-800 dark:text-gray-200');

            // Скрываем форму регистрации и показываем форму авторизации
            $('#registerForm').hide();
            $('#authForm').fadeIn();
        });

        // Добавляем маску для белорусского номера телефона
        $('input[name="phone"]').mask('+375 (99) 999-99-99', {
        });

        //Ajax обработка
        const $authForm = $("#authForm");
        const $registerForm = $("#registerForm");

        // Авторизация
        $authForm.on("submit", function (e) {
            e.preventDefault();

            BX.ajax
                .runComponentAction("shelton:auth.registration", "auth", {
                    mode: "class",
                    data: {
                        phone: $authForm.find("[name='phone']").val(),
                        password: $authForm.find("[name='password']").val(),
                    },
                })
                .then((response) => {
                    if (response.data.status === "success") {
                        alert(response.data.message);
                        location.reload();
                    } else {
                        $('#authError').html(response.data.message + '<br>');
                        // alert(response.data.message);
                    }
                })
                .catch((error) => {
                    console.error(error);
                    alert("Ошибка отправки запроса");
                });
        });

        // Регистрация
        $registerForm.on("submit", function (e) {
            e.preventDefault();

            BX.ajax
                .runComponentAction("shelton:auth.registration", "register", {
                    mode: "class",
                    data: {
                        phone: $registerForm.find("[name='phone']").val(),
                        name: $registerForm.find("[name='name']").val(),
                        email: $registerForm.find("[name='email']").val(),
                        password: $registerForm.find("[name='password']").val(),
                        passwordConfirm: $registerForm.find("[name='password_confirm']").val(),
                    },
                })
                .then((response) => {
                    if (response.data.status === "success") {
                        alert(response.data.message);
                        location.reload();
                    } else {
                        $('#registerError').html(response.data.message + '<br><br>');
                    }
                })
                .catch((error) => {
                    console.error(error);
                    alert("Ошибка отправки запроса");
                });
        });
    });

</script>