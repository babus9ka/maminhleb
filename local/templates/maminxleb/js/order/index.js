document.addEventListener("DOMContentLoaded", function () {
  function handleAjaxRequest(componentsClass, action, data = {}) {
    return BX.ajax.runComponentAction(componentsClass, action, {
      mode: "class",
      data: data,
    });
  }

  handleAjaxRequest("shelton:order", "isAuthorized").then(function (response) {
    const emailWrapper = document.getElementById("email-wrapper");
    const emailInput = document.getElementById("email");
    if (!response.data) {
      emailWrapper.classList.remove("hidden");
      emailInput.setAttribute("required", "required");
    } else {
      emailWrapper.classList.add("hidden");
      emailInput.removeAttribute("required");
    }
  });

  const clearBasket = document.getElementById("clearBasket");
  clearBasket.addEventListener("click", function () {
    handleAjaxRequest("shelton:order", "clearBasket")
      .then(function (response) {
        if (response.status === "success") {
          if (response.data.redirect) {
            window.location.href = response.data.redirect;
          }
        } else {
          console.log("Произошла ошибка при очистке корзины");
        }
      })
      .catch(function (error) {
        console.log(error);
      });
  });

  var orderForm = document.getElementById("orderForm");
  var submitButton = document.getElementById("orderLogic");

  submitButton.addEventListener("click", function (event) {
    event.preventDefault(); // Отменяем стандартную отправку формы

    var name = orderForm.querySelector('input[name="name"]');
    var phone = orderForm.querySelector('input[name="phone"]');
    var email = orderForm.querySelector('input[name="email"]');
    var isAuthorized = orderForm.getAttribute('data-user-auth') === 'Y';

    var errors = [];

    if (!name || !name.value.trim()) {
      errors.push("Введите ваше имя");
    }
    if (!phone || !phone.value.trim()) {
      errors.push("Введите номер телефона");
    }
    if (!isAuthorized && (!email || !email.value.trim())) {
      errors.push("Введите ваш email");
    }

    if (errors.length > 0) {
      showValidationPopup(errors);
      return;
    }

    var formData = new FormData(orderForm);
    var orderData = {};
    formData.forEach(function (value, key) {
      orderData[key] = value;
    });

    console.log(orderData);

    BX.ajax.runComponentAction('shelton:order', 'processOrder', {
      mode: 'class',
      data: {
        orderData: orderData
      }
    }).then(function (response) {
      console.log(response);
    }).catch(function (error) {
      console.error('Ошибка сети или сервера:', error);
    });
  });

  // Функция открытия popup-а с ошибками
  function showValidationPopup(errors) {
    var $list = $('#validation-error-list');
    $list.empty();
    errors.forEach(function (error) {
      $list.append('<li>' + error + '</li>');
    });

    $.magnificPopup.open({
      items: {
        src: '#validation-error-popup',
        type: 'inline'
      }
    });
  }

  // Закрытие popup-а
  $(document).on('click', '.close-popup', function () {
    $.magnificPopup.close();
  });
});


