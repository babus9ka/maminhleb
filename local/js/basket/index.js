document.addEventListener("DOMContentLoaded", function () {
  // Определяем функцию для получения корзины
  function getBasket() {
    const basketList = document.getElementById("basket-container");
    const template = document.getElementById("basket-item-template");
    const totalSumElement = document.getElementById("totalSum"); // Контейнер для суммы
    const orderButton = document.getElementById("orderButton"); // Кнопка оформления заказа

    if (!template) {
      console.error("Шаблон basket-item-template не найден!");
      return;
    }

    BX.ajax
      .runComponentAction("shelton:basket", "getBasket", {
        mode: "class",
      })
      .then(function (response) {
        basketList.innerHTML = ""; // Очищаем корзину

        if (response.data && response.data.ITEMS.length > 0) {
          // Убираем атрибут disabled, чтобы кнопка стала активной
          orderButton.disabled = false;

          response.data.ITEMS.forEach((item) => {
            const productItem = template.cloneNode(true);

            productItem.id = "";
            productItem.classList.remove("hidden");

            productItem.querySelector("img").src = item.IMAGE;
            productItem.querySelector("img").alt = item.NAME;
            productItem.querySelector(".product-name").textContent = item.NAME;
            productItem.querySelector(".product-quantity").textContent =
              item.QUANTITY;
            productItem.querySelector(
              ".product-price"
            ).textContent = `${item.PRICE} BYN`;

            // Обработчик для увеличения количества товара
            const increaseButton =
              productItem.querySelector(".increase-quantity");
            increaseButton.addEventListener("click", function () {
              const productId = item.PRODUCTID;
              const currentQuantity = parseInt(
                productItem.querySelector(".product-quantity").textContent,
                10
              );
              const newQuantity = currentQuantity + 1;

              BX.ajax
                .runComponentAction("shelton:basket", "addToBasketQuantity", {
                  mode: "class",
                  data: {
                    productId: productId,
                    quantity: newQuantity,
                  },
                })
                .then(function (response) {
                  if (response.data) {
                    productItem.querySelector(".product-quantity").textContent =
                      response.data.QUANTITY;
                    productItem.querySelector(
                      ".product-price"
                    ).textContent = `${response.data.PRICE} BYN`;
                    getBasket();
                  }
                })
                .catch(function (error) {
                  console.error(
                    "Ошибка при увеличении количества товара:",
                    error
                  );
                });
            });

            // Обработчик для уменьшения количества товара
            const decreaseButton =
              productItem.querySelector(".decrease-quantity");
            decreaseButton.addEventListener("click", function () {
              const productId = item.PRODUCTID;
              const currentQuantity = parseInt(
                productItem.querySelector(".product-quantity").textContent,
                10
              );
              const newQuantity = currentQuantity - 1;

              BX.ajax
                .runComponentAction(
                  "shelton:basket",
                  "removeFromBasketQuantity",
                  {
                    mode: "class",
                    data: {
                      productId: productId,
                      quantity: newQuantity,
                    },
                  }
                )
                .then(function (response) {
                  if (response.data) {
                    if (response.data.QUANTITY === 0) {
                      productItem.remove();
                    } else {
                      productItem.querySelector(
                        ".product-quantity"
                      ).textContent = response.data.QUANTITY;
                      productItem.querySelector(
                        ".product-price"
                      ).textContent = `${response.data.PRICE} BYN`;
                      getBasket();
                    }
                  }
                })
                .catch(function (error) {
                  console.error(
                    "Ошибка при уменьшении количества товара:",
                    error
                  );
                });
            });

            basketList.appendChild(productItem);
          });

          totalSumElement.textContent = `${response.data.TOTAL_SUM} BYN`;
        } else {
          // Если корзина пуста
          basketList.innerHTML = "<div>Корзина пуста</div>";
          totalSumElement.textContent = "0 BYN";

          // Устанавливаем кнопку в неактивное состояние
          orderButton.disabled = true; // Устанавливаем кнопку в неактивное состояние
        }

        // Возвращаем шаблон в контейнер, если он был очищен
        if (!document.getElementById("basket-item-template")) {
          basketList.appendChild(template);
        }
      })
      .catch(function (error) {
        console.error("Ошибка при получении корзины:", error);
      });
  }

  // Добавление товара в корзину
  const addButtons = document.querySelectorAll("[data-product-id]");

  addButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const productData = {
        productId: this.getAttribute("data-product-id"),
        quantity: 1,
        price: this.getAttribute("data-product-price"),
        name: this.getAttribute("data-product-name"),
        image: this.getAttribute("data-product-image"),
      };

      BX.ajax
        .runComponentAction("shelton:basket", "addToBasket", {
          mode: "class",
          data: productData,
        })
        .then(function (response) {
          if (response.data && response.status === "success") {
            console.log("Товар добавлен в корзину: " + response.data.data.NAME);
            getBasket(); // Обновляем корзину
          } else {
            console.error("Ошибка добавления товара в корзину");
          }
        })
        .catch(function (error) {
          console.error("Ошибка при отправке запроса:", error);
        });
    });
  });

  // Инициализация корзины при загрузке страницы
  getBasket();
});
