const DELIVERY_ID = 2; // ID для доставки
const PICKUP_ID = 3;   // ID для самовывоза

// Установка значения сервиса доставки в скрытое поле
function setDeliveryServiceID(id) {
    document.getElementById("deliveryServiceId").value = id;
}

// Переключение видимости полей и атрибута "required"
function toggleFieldsVisibility(fields, isVisible) {
    fields.forEach(function (field) {
        const container = field.closest(".relative");
        container.style.display = isVisible ? "" : "none";
        if (isVisible) {
            field.setAttribute("required", "required");
        } else {
            field.removeAttribute("required");
        }
    });
}

// Функция для показа и обязательного заполнения полей (используется для доставки)
function showAndRequireFields() {
    const fields = ["entrance", "doorphone", "floor", "flat"].map(function (id) {
        return document.getElementById(id);
    });
    toggleFieldsVisibility(fields, true);
    document.getElementById("privateHouseContainer").style.display = "";
    document.getElementById("addressComment").style.display = "";
}

// Функция для скрытия полей и удаления обязательности (используется для самовывоза)
function hideAndRemoveRequiredFields() {
    const fields = ["entrance", "doorphone", "floor", "flat"].map(function (id) {
        return document.getElementById(id);
    });
    toggleFieldsVisibility(fields, false);
    document.getElementById("privateHouseContainer").style.display = "none";
    document.getElementById("addressComment").style.display = "none";
}

// Переключение активного состояния кнопок
function toggleActiveState(activeButton, inactiveButton) {
    activeButton.setAttribute("aria-checked", "true");
    activeButton.setAttribute("data-state", "checked");
    inactiveButton.setAttribute("aria-checked", "false");
    inactiveButton.setAttribute("data-state", "unchecked");

    activeButton.classList.add("address__active");
    inactiveButton.classList.remove("address__active");

    activeButton.setAttribute("tabindex", "0");
    inactiveButton.setAttribute("tabindex", "-1");
}

document.addEventListener("DOMContentLoaded", function() {
    const deliveryButton = document.getElementById("delivery-button");
    const pickupButton = document.getElementById("pickup-button");
    const deliveryForm = document.getElementById("deliveryForm");
    const pickupForm = document.getElementById("pickupForm");

    // Изначально показываем форму доставки, скрывая форму самовывоза
    deliveryForm.style.display = "";
    pickupForm.style.display = "none";
    showAndRequireFields();
    setDeliveryServiceID(DELIVERY_ID);

    deliveryButton.addEventListener("click", function() {
        toggleActiveState(deliveryButton, pickupButton);
        deliveryForm.style.display = "";
        pickupForm.style.display = "none";
        showAndRequireFields();
        setDeliveryServiceID(DELIVERY_ID);
    });

    pickupButton.addEventListener("click", function() {
        toggleActiveState(pickupButton, deliveryButton);
        deliveryForm.style.display = "none";
        pickupForm.style.display = "";
        hideAndRemoveRequiredFields();
        setDeliveryServiceID(PICKUP_ID);
    });
});