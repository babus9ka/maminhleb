document.addEventListener("DOMContentLoaded", function () {
    $(document).ready(function () {
        // Функция для отображения ошибок в блоке .error
        function showError(message) {
            $('.error').html(message);
        }

        // Функция для очистки блока с ошибками
        function clearError() {
            $('.error').html('');
        }

        // Функция проверки заполненности обязательных полей в форме доставки
        function validateDeliveryForm() {
            var isValid = true;
            clearError(); // очищаем ошибки перед проверкой

            // Перебираем все обязательные поля в форме доставки
            $('#deliveryForm input[required]').each(function () {
                if ($.trim($(this).val()) === '') {
                    isValid = false;
                    $(this).addClass('input-error'); // добавляем класс для подсветки ошибок
                } else {
                    $(this).removeClass('input-error');
                }
            });

            // Если режим "частный дом" включен, проверяем, что поле комментария заполнено
            if ($('#privateHouse').is(':checked')) {
                if ($.trim($('#addressComment').val()) === '') {
                    isValid = false;
                    $('#addressComment').addClass('input-error');
                    showError("При выборе частного дома необходимо указать комментарий к адресу.");
                } else {
                    $('#addressComment').removeClass('input-error');
                }
            }

            if (!isValid && $('.error').html() === '') {
                showError("Пожалуйста, заполните все обязательные поля доставки.");
            }
            return isValid;
        }

        // Функция проверки заполненности обязательных полей в форме самовывоза
        function validatePickupForm() {
            clearError();
            var isValid = true;
            // Проверяем, выбрана ли одна из radio кнопок
            if ($('input[name="pickup_selected"]:checked').length === 0) {
                isValid = false;
                showError("Пожалуйста, выберите адрес пункта выдачи.");
            }
            return isValid;
        }

        // Функция копирования данных из формы доставки
        function copyDeliveryData() {
            var address = $('#deliveryForm input[name="address"]').val();
            var entrance = $('#deliveryForm input[name="entrance"]').val();
            var intercom = $('#deliveryForm input[name="intercom"]').val();
            var floor = $('#deliveryForm input[name="floor"]').val();
            var apartment = $('#deliveryForm input[name="apartment"]').val();
            var comment = $('#addressComment').val();
            var isPrivate = $('#privateHouse').is(':checked');

            $('#thirdDeliveryOption').val('delivery');
            $('#thirdAddress').val(address);

            if (isPrivate) {
                // Сохраняем комментарий к адресу для частного дома
                $('#thirdAddressComment').val(comment);
                $('#thirdEntrance').val('');
                $('#thirdFloor').val('');
                $('#thirdApartment').val('');
            } else {
                $('#thirdEntrance').val(entrance);
                $('#thirdFloor').val(floor);
                $('#thirdApartment').val(apartment);
                $('#thirdApartment').val(apartment);
                $('#thirdIntercom').val(intercom);
                $('#thirdAddressComment').val('');
            }
        }

        // Функция копирования данных из формы самовывоза с установкой выбранного адреса склада
        function copyPickupData() {
            var $selectedRadio = $('input[name="pickup_selected"]:checked');
            var selectedAddress = '';
            if ($selectedRadio.length > 0) {
                // Предполагаем, что текст адреса лежит в ближайшем label
                selectedAddress = $selectedRadio.closest('.pickup-option').find('label').text().trim();
            } else {
                // Если ни одна опция не выбрана, можно выбрать адрес первого варианта
                selectedAddress = $('.pickup-option label').first().text().trim();
            }

            // Рекомендуется записать адрес именно туда, где сервер его ожидает. Если сервер ожидает поле с именем "selected_address", то запишем его туда
            $('input[name="selected_address"]').val(selectedAddress);

            // Если необходимо задать тип доставки
            $('#thirdDeliveryOption').val('pickup');

            // Очищаем поля, используемые только для доставки
            $('#thirdEntrance').val('');
            $('#thirdFloor').val('');
            $('#thirdApartment').val('');
            $('#thirdAddressComment').val('');
        }

        // Обработчик для подтверждения доставки
        $('#confirmAdress').on('click', function () {
            if (!validateDeliveryForm()) {
                return; // Прерываем выполнение, если валидация не пройдена
            }
            copyDeliveryData();
            if ($.magnificPopup) {
                $.magnificPopup.close();
            }
            $('#thirdForm').submit();
        });

        // Обработчик для подтверждения самовывоза
        $('#confirmPickup').on('click', function () {
            if (!validatePickupForm()) {
                return;
            }
            copyPickupData();
            if ($.magnificPopup) {
                $.magnificPopup.close();
            }
            $('#thirdForm').submit();
        });
    });
});