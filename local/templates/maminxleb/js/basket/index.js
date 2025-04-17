document.addEventListener("DOMContentLoaded", function () {
  const basketList = document.getElementById("basketList");
  const template = document.getElementById("basketTemplate");
  const addButtons = document.querySelectorAll("[data-product-id]");
  const totalSumElements = document.querySelectorAll("#totalSum");

  function handleAjaxRequest(action, data = {}) {
    return BX.ajax.runComponentAction("shelton:basket", action, {
      mode: "class",
      data: data,
    });
  }

  function checkBasket() {
    handleAjaxRequest("checkBasket")
      .then(function (response) {
        const orderButton = document.getElementById("orderButton");
        const orderLink = document.querySelector(".address__popup");
        if (response.data.hasItems) {
          orderButton.removeAttribute("disabled");
          orderLink.style.pointerEvents = "auto";
          orderLink.style.opacity = "1";
        } else {
          orderButton.setAttribute("disabled", "true");
          orderLink.style.pointerEvents = "none";
          orderLink.style.opacity = "0.5";
        }
      })
      .catch(function (error) {
        console.error("Ошибка при проверке корзины:", error);
      });
  }

  function updateBasket() {
    handleAjaxRequest("getBasket")
      .then(function (response) {
        basketList.innerHTML = "";

        if (response.data?.ITEMS?.length > 0) {
          response.data.ITEMS.forEach((item) => {
            const productItem = template.cloneNode(true);
            productItem.classList.remove("hidden");

            productItem.querySelector("img").src = item.IMAGE;
            productItem.querySelector("img").alt = item.NAME;
            productItem.querySelector(".product-name").textContent = item.NAME;
            productItem.querySelector(
              ".product-gramm"
            ).textContent = `${item.GRAMM} гр`;
            productItem.querySelector(".product-quantity").textContent =
              item.QUANTITY;
            productItem.querySelector(
              ".product-price"
            ).textContent = `${item.PRODUCT_PRICE} BYN`;

            setupQuantityButtons(item, productItem);
            basketList.appendChild(productItem);
          });
        }

        updateTotalSum();
        checkBasket();
      })
      .catch(function (error) {
        console.error("Ошибка при получении корзины:", error);
      });
  }

  function updateTotalSum() {
    handleAjaxRequest("getBasketTotalSum")
      .then(function (response) {
        if (response.data?.TOTAL_SUM !== undefined) {
          totalSumElements.forEach((totalSumElement) => {
            totalSumElement.textContent = `${response.data.TOTAL_SUM} BYN`;
          });
        }
      })
      .catch(function (error) {
        console.error("Ошибка при получении общей суммы корзины:", error);
      });
  }

  function setupQuantityButtons(item, productItem) {
    const increaseQuantityBtn = productItem.querySelector(".increase-quantity");
    increaseQuantityBtn.addEventListener("click", function () {
      updateQuantity(
        item.PRODUCTID,
        item.QUANTITY,
        item.PRICE,
        productItem,
        "increase"
      );
    });

    const decreaseQuantityBtn = productItem.querySelector(".decrease-quantity");
    decreaseQuantityBtn.addEventListener("click", function () {
      updateQuantity(
        item.PRODUCTID,
        item.QUANTITY,
        item.PRICE,
        productItem,
        "decrease"
      );
    });
  }

  function updateQuantity(
    productID,
    productQuantity,
    productPrice,
    productItem,
    actionType
  ) {
    const actionMap = {
      increase: "addToBasketQuantity",
      decrease: "removeFromBasketQuantity",
    };

    handleAjaxRequest(actionMap[actionType], {
      productId: productID,
      quantity: productQuantity,
      price: productPrice,
    })
      .then(function (response) {
        if (response.data) {
          if (response.data.QUANTITY == 0) {
            updateBasket();
          } else {
            productItem.querySelector(".product-quantity").textContent =
              response.data.QUANTITY;
            productItem.querySelector(
              ".product-price"
            ).textContent = `${response.data.PRODUCT_PRICE} BYN`;
          }
        }
        updateTotalSum();
      })
      .catch(function (error) {
        console.error(
          `Ошибка при ${
            actionType === "increase" ? "увеличении" : "уменьшении"
          } количества товара:`,
          error
        );
      });
  }

  addButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const productData = {
        productId: this.getAttribute("data-product-id"),
        quantity: 1,
        price: this.getAttribute("data-product-price"),
        name: this.getAttribute("data-product-name"),
        image: this.getAttribute("data-product-image"),
      };

      handleAjaxRequest("addToBasket", productData)
        .then(function (response) {
          if (response.data) {
            console.log("Товар добавлен в корзину:", response.data);
            updateBasket();
          } else {
            console.error("Ошибка добавления товара в корзину");
          }
        })
        .catch(function (error) {
          console.error("Ошибка при отправке запроса:", error);
        });
    });
  });

  updateBasket(); // Вызываем при загрузке страницы
});
