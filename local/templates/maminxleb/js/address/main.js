document.addEventListener("DOMContentLoaded", function () {
  // Устанавливаем значение сервиса доставки по умолчанию
  setDeliveryServiceID(DELIVERY_ID);

  // Настраиваем начальное активное состояние кнопок
  const deliveryButton = document.getElementById("delivery-button");
  const pickupButton = document.getElementById("pickup-button");

  deliveryButton.setAttribute("aria-checked", "true");
  deliveryButton.setAttribute("data-state", "checked");
  deliveryButton.classList.add("address__active");
  pickupButton.setAttribute("aria-checked", "false");
  pickupButton.setAttribute("data-state", "unchecked");
  pickupButton.setAttribute("tabindex", "-1");

  // Обработчик для переключения на доставку
  deliveryButton.addEventListener("click", function () {
    document.getElementById("search-input").value = "";
    ymaps.ready(deliveryInitMap);
    toggleActiveState(deliveryButton, pickupButton);
    setDeliveryServiceID(DELIVERY_ID);
  });

  // Обработчик для переключения на самовывоз
  pickupButton.addEventListener("click", function () {
    ymaps.ready(pickupInitMap);
    toggleActiveState(pickupButton, deliveryButton);
    setDeliveryServiceID(PICKUP_ID);
  });

  // Обработчик для изменения состояния "частного дома"
  document.getElementById("privateHouse").addEventListener("change", function () {
    const isChecked = this.checked;
    const fieldIds = ["entrance", "doorphone", "floor", "flat"];
    const fields = fieldIds.map(function (id) {
      return document.getElementById(id);
    });
    const addressComment = document.getElementById("addressComment");

    toggleFieldsVisibility(fields, !isChecked);
    addressComment.toggleAttribute("required", isChecked);
  });

  // Инициализируем карту для доставки при загрузке страницы
  ymaps.ready(deliveryInitMap);
});

