document.addEventListener("DOMContentLoaded", function () {
  const orderForm = document.getElementById("orderForm");
  const submitButton = document.getElementById("orderLogic");
  const clearBasket = document.getElementById("clearBasket");
  const emailWrapper = document.getElementById("email-wrapper");
  const emailInput = document.getElementById("email");

  let isAuthorized = false;

  // Универсальная функция для запросов к компоненту
  function handleAjaxRequest(component, action, data = {}) {
    return BX.ajax.runComponentAction(component, action, {
      mode: "class",
      data: data,
    });
  }

  // Проверка авторизации пользователя
  handleAjaxRequest("shelton:order", "isAuthorized").then(function (response) {
    isAuthorized = !!response.data;

    if (!isAuthorized) {
      emailWrapper.classList.remove("hidden");
      emailInput.setAttribute("required", "required");
    } else {
      emailWrapper.classList.add("hidden");
      emailInput.removeAttribute("required");
    }
  });

  // Очистка корзины
  clearBasket?.addEventListener("click", function () {
    handleAjaxRequest("shelton:order", "clearBasket")
      .then(function (response) {
        if (response.status === "success" && response.data.redirect) {
          window.location.href = response.data.redirect;
        } else {
          console.warn("Ошибка при очистке корзины");
        }
      })
      .catch(console.error);
  });

  // Обработка отправки формы
  submitButton?.addEventListener("click", function (event) {
    event.preventDefault();

    const name = orderForm.querySelector('input[name="name"]');
    const phone = orderForm.querySelector('input[name="phone"]');
    const email = orderForm.querySelector('input[name="email"]');

    const errors = validateForm({ name, phone, email, isAuthorized });

    if (errors.length > 0) {
      showValidationPopup(errors);
      return;
    }

    const formData = new FormData(orderForm);
    const orderData = Object.fromEntries(formData.entries());

    console.log("Отправляем данные:", orderData);

    handleAjaxRequest("shelton:order", "processOrder", { orderData })
      .then(function (response) {
        console.log("Ответ от сервера:", response);
        // здесь можно сделать redirect, popup или сообщение об успехе
      })
      .catch(function (error) {
        console.error("Ошибка сети или сервера:", error);
      });
  });

  // Валидация формы
  function validateForm({ name, phone, email, isAuthorized }) {
    const errors = [];

    if (!name?.value.trim()) {
      errors.push("Введите ваше имя");
    }

    if (!phone?.value.trim()) {
      errors.push("Введите номер телефона");
    }

    if (!isAuthorized) {
      if (!email || !email.value.trim()) {
        errors.push("Введите ваш email — он нужен для входа");
      }
    }

    return errors;
  }

  // Показать popup с ошибками
  function showValidationPopup(errors) {
    const $list = $('#validation-error-list');
    $list.empty();
    errors.forEach(error => {
      $list.append(`<li>${error}</li>`);
    });

    $.magnificPopup.open({
      items: {
        src: '#validation-error-popup',
        type: 'inline',
      },
    });
  }

  // Закрытие popup-а
  $(document).on("click", ".close-popup", function () {
    $.magnificPopup.close();
  });
});
