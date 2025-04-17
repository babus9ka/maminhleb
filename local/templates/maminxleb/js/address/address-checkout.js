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

        // Функция обновления отображения адреса заказа для доставки
        function updateDeliveryOrderDisplay(address, entrance, intercom, floor, apartment, comment, isPrivate) {
            $('#orderType').html('Тип заказа: Доставка');
            $('#deliveryAddress').html(address);
            if (isPrivate) {
                // Если это частный дом – выводим в подробностях комментарий
                $('#deliveryAddressDetail').html(comment);
            } else {
                var details = "";
                if (entrance) {
                    details += "Подъезд: " + entrance + "; ";
                }
                if (floor) {
                    details += "Этаж: " + floor + "; ";
                }
                if (apartment) {
                    details += "Квартира: " + apartment + "; ";
                }
                if (intercom) {
                    details += "Домофон: " + intercom;
                }
                $('#deliveryAddressDetail').html(details);
            }
        }

        // Функция обновления отображения адреса заказа для самовывоза
        function updatePickupOrderDisplay() {
            $('#orderType').html('Тип заказа: Самовывоз');
            $('#deliveryAddress').html($('input[name="selected_address"]').val());
            $('#deliveryAddressDetail').html('');
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
                $('#thirdAddressComment').val(comment);
                $('#thirdEntrance').val('');
                $('#thirdFloor').val('');
                $('#thirdApartment').val('');
            } else {
                $('#thirdEntrance').val(entrance);
                $('#thirdIntercom').val(intercom);
                $('#thirdFloor').val(floor);
                $('#thirdApartment').val(apartment);
                $('#thirdAddressComment').val('');
            }

            updateDeliveryOrderDisplay(address, entrance, intercom, floor, apartment, comment, isPrivate);
        }

        // Функция копирования данных из формы самовывоза
        function copyPickupData() {
            var $selectedRadio = $('input[name="pickup_selected"]:checked');
            var selectedAddress = "";
            if ($selectedRadio.length > 0) {
                // Извлекаем текст из label, связанного с выбранным radio-input
                selectedAddress = $selectedRadio.closest('.pickup-option').find('label').text().trim();
            } else {
                // Если ни одна опция не выбрана, берём адрес из первого варианта
                selectedAddress = $('#warehouse-addresses .pickup-option:first label').text().trim();
            }
            // Устанавливаем тип заказа как самовывоз
            $('#thirdDeliveryOption').val('pickup');

            // Сохраняем выбранный адрес в скрытых полях
            // Обновляем поле, которое сервер ожидает (например, "selected_address")
            $('input[name="selected_address"]').val(selectedAddress);
            // Если используется ещё отдельное поле для адреса самовывоза, например, thirdAddress, обновляем и его:
            $('#thirdAddress').val(selectedAddress);

            // Если необходимо, можно сохранить адрес и в дополнительном поле (например, thirdSelectedAddress)
            $('#thirdSelectedAddress').val(selectedAddress);

            // Очищаем поля, которые применяются только для доставки
            $('#thirdEntrance').val('');
            $('#thirdFloor').val('');
            $('#thirdApartment').val('');
            $('#thirdAddressComment').val('');

            updatePickupOrderDisplay(selectedAddress);
        }

        // Обработчики нажатия кнопок подтверждения
        $('#confirmAdress').on('click', function () {
            if (!validateDeliveryForm()) {
                return;
            }
            copyDeliveryData();
            if ($.magnificPopup) {
                $.magnificPopup.close();
            }
        });

        $('#confirmPickup').on('click', function () {
            if (!validatePickupForm()) {
                return;
            }
            copyPickupData();
            if ($.magnificPopup) {
                $.magnificPopup.close();
            }
        });

        // Функция заполнения видимых полей формы значениями из скрытых полей,
        // чтобы пользователь мог редактировать их при открытии модального окна.
        function fillVisibleFieldsFromHidden() {
            if ($('#thirdDeliveryOption').val() === 'delivery') {
                var hiddenAddress = $('#thirdAddress').val();
                var hiddenEntrance = $('#thirdEntrance').val();
                var hiddenintercom = $('#thirdIntercom').val();
                var hiddenFloor = $('#thirdFloor').val();
                var hiddenApartment = $('#thirdApartment').val();
                var hiddenComment = $('#thirdAddressComment').val();

                $('#search-input').val(hiddenAddress);
                $('#entrance').val(hiddenEntrance);
                $('#doorphone').val(hiddenintercom);
                $('#floor').val(hiddenFloor);
                $('#flat').val(hiddenApartment); // поле квартиры имеет id="flat"
                $('#addressComment').val(hiddenComment);
            } else if ($('#thirdDeliveryOption').val() === 'pickup') {
                // Берём адрес самовывоза из hidden-поля "selected_address" или, если оно пустое, из thirdAddress
                var hiddenPickup = $('input[name="selected_address"]').val() || $('#thirdAddress').val();
                $('input[name="pickup_address"]').val(hiddenPickup);
            }
        }

        // Инициализация отображения заказа и заполнения видимых полей
        var initialOption = $('#thirdDeliveryOption').val();
        if (initialOption === 'delivery') {
            var address = $('#thirdAddress').val();
            var entrance = $('#thirdEntrance').val();
            var intercom = $('#thirdIntercom').val();
            var floor = $('#thirdFloor').val();
            var apartment = $('#thirdApartment').val();
            var comment = $('#thirdAddressComment').val();
            var isPrivate = (comment.trim() !== '');
            updateDeliveryOrderDisplay(address, entrance, intercom, floor, apartment, comment, isPrivate);
        } else if (initialOption === 'pickup') {
            var selectedAddress = $('#thirdAddress').val();
            updatePickupOrderDisplay(selectedAddress);
        }
        // Заполняем видимые поля формы данными из hidden полей,
        // чтобы пользователь мог их сразу редактировать в модальном окне.
        fillVisibleFieldsFromHidden();
    });
});
