document.addEventListener("DOMContentLoaded", function () {
  let orderButton = document.getElementById("orderButton");
  let orderContainer = document.getElementById("orderContainer");
  let closedOrderContainer = document.getElementById("closedOrderContainer");
  let privateHouseContainer = document.getElementById("privateHouseContainer");

  function openOrderContainer() {
    orderContainer.style.display = "block";
    document.body.style.overflow = "hidden";
  }

  function closeOrderContainer() {
    orderContainer.style.display = "none";
    document.body.style.overflow = "";
  }

  closedOrderContainer.addEventListener("click", closeOrderContainer);

  orderButton.addEventListener("click", function () {
    BX.ajax
      .runComponentAction("shelton:address", "checkBasket", {
        mode: "class",
        data: {},
      })
      .then(function (response) {
        if (response === false) {
          console.log("Корзина пустая");
        } else {
          openOrderContainer();
        }
      })
      .catch(function (error) {
        console.log(error);
      });
  });

  document
    .getElementById("privateHouse")
    .addEventListener("change", function () {
      const privateHouseCheckbox = document.getElementById("privateHouse");

      // Поля формы
      const entrance = document.getElementById("entrance");
      const doorphone = document.getElementById("doorphone");
      const floor = document.getElementById("floor");
      const flat = document.getElementById("flat");
      const addressComment = document.getElementById("addressComment");

      function toggleFields() {
        if (privateHouseCheckbox.checked) {
          // Скрываем все поля и убираем атрибут "required"
          entrance.closest(".relative").style.display = "none";
          doorphone.closest(".relative").style.display = "none";
          floor.closest(".relative").style.display = "none";
          flat.closest(".relative").style.display = "none";

          entrance.removeAttribute("required");
          doorphone.removeAttribute("required");
          floor.removeAttribute("required");
          flat.removeAttribute("required");

          // Делаем textarea обязательным
          addressComment.setAttribute("required", "required");
        } else {
          // Показываем все поля и добавляем атрибут "required"
          entrance.closest(".relative").style.display = "";
          doorphone.closest(".relative").style.display = "";
          floor.closest(".relative").style.display = "";
          flat.closest(".relative").style.display = "";

          entrance.setAttribute("required", "required");
          doorphone.setAttribute("required", "required");
          floor.setAttribute("required", "required");
          flat.setAttribute("required", "required");

          // Убираем обязательность у textarea
          addressComment.removeAttribute("required");
        }
      }

      toggleFields();
    });

  let currentMap = null;

  function showAndRequireFields() {
    entrance.closest(".relative").style.display = "";
    doorphone.closest(".relative").style.display = "";
    floor.closest(".relative").style.display = "";
    flat.closest(".relative").style.display = "";

    entrance.setAttribute("required", "required");
    doorphone.setAttribute("required", "required");
    floor.setAttribute("required", "required");
    flat.setAttribute("required", "required");

    privateHouseContainer.style.display = "";
    addressComment.style.display = "";
  }

  function hideAndRemoveRequiredFields() {
    entrance.closest(".relative").style.display = "none";
    doorphone.closest(".relative").style.display = "none";
    floor.closest(".relative").style.display = "none";
    flat.closest(".relative").style.display = "none";

    entrance.removeAttribute("required");
    doorphone.removeAttribute("required");
    floor.removeAttribute("required");
    flat.removeAttribute("required");

    privateHouseContainer.style.display = "none";
    addressComment.style.display = "none";
  }

  function deliveryInitMap() {
    showAndRequireFields();

    if (currentMap) {
      currentMap.destroy(); // Уничтожаем старую карту
    }

    var map = new ymaps.Map("map", {
      center: [52.097621, 23.734051],
      zoom: 10, // Уровень масштаба
    });

    currentMap = map; // Сохраняем текущую карту

    var searchInput = document.getElementById("search-input");
    var suggestions = document.getElementById("suggestions");

    // Обработчик ввода текста
    searchInput.addEventListener("input", function () {
      var query = searchInput.value.trim();
      if (query.length > 2) {
        fetchSuggestions(query);
      } else {
        suggestions.innerHTML = ""; // Очищаем подсказки
      }
    });

    // Запрос подсказок из REST API
    function fetchSuggestions(query) {
      const apiKey = "84eaac21-a0f1-46e4-8faa-258382d17245";
      const url = `https://geocode-maps.yandex.ru/1.x/?apikey=${apiKey}&format=json&geocode=${encodeURIComponent(
        query
      )}`;

      fetch(url)
        .then((response) => response.json())
        .then((data) => {
          displaySuggestions(data);
        })
        .catch((error) => {
          console.error("Ошибка загрузки подсказок:", error);
        });
    }

    // Отображение подсказок
    function displaySuggestions(data) {
      const items = data.response.GeoObjectCollection.featureMember;
      suggestions.innerHTML = ""; // Очищаем старые подсказки

      if (items.length > 0) {
        items.forEach((item) => {
          const address = item.GeoObject.metaDataProperty.GeocoderMetaData.text;
          const coords = item.GeoObject.Point.pos
            .split(" ")
            .map(Number)
            .reverse();

          const suggestionItem = document.createElement("div");
          suggestionItem.className = "suggestion-item";
          suggestionItem.textContent = address;

          suggestionItem.addEventListener("click", function () {
            selectSuggestion(address, coords);
          });

          suggestions.appendChild(suggestionItem);
        });
      } else {
        const noResults = document.createElement("div");
        noResults.className = "suggestion-item";
        noResults.textContent = "Адреса не найдены";
        suggestions.appendChild(noResults);
      }
    }

    // Выбор подсказки
    function selectSuggestion(address, coords) {
      searchInput.value = address; // Обновляем строку поиска
      map.setCenter(coords, 14);

      const placemark = new ymaps.Placemark(
        coords,
        {
          balloonContent: address,
        },
        {
          preset: "islands#icon",
          iconColor: "#0095b6",
        }
      );

      map.geoObjects.removeAll(); // Удаляем старые метки
      map.geoObjects.add(placemark);

      suggestions.innerHTML = ""; // Очищаем подсказки
    }

    // Определение адреса по клику на карту
    map.events.add("click", async function (e) {
      const coords = e.get("coords");

      try {
        const res = await ymaps.geocode(coords);
        if (res.geoObjects.getLength() > 0) {
          const firstGeoObject = res.geoObjects.get(0);
          const address = firstGeoObject.getAddressLine();

          searchInput.value = address; // Обновляем строку поиска
          map.geoObjects.removeAll(); // Удаляем старые метки

          const placemark = new ymaps.Placemark(
            coords,
            {
              balloonContent: address,
            },
            {
              preset: "islands#icon",
              iconColor: "#0095b6",
            }
          );

          map.geoObjects.add(placemark);
          console.log("Адрес по клику:", address);
        } else {
          console.warn("Не найдено объектов по данным координатам.");
        }
      } catch (error) {
        console.error("Ошибка обратного геокодирования:", error);
      }
    });

    // Настройка управления картой
    map.controls.remove("geolocationControl"); // удаляем геолокацию
    map.controls.remove("searchControl"); // удаляем поиск
    map.controls.remove("trafficControl"); // удаляем контроль трафика
    map.controls.remove("typeSelector"); // удаляем тип
    map.controls.remove("fullscreenControl"); // удаляем кнопку перехода в полноэкранный режим
    map.controls.remove("rulerControl"); // удаляем контрол правил

    // Включение управления масштабом через тачпад
    map.behaviors.enable(["scrollZoom", "multiTouch"]); // Включаем прокрутку и масштабирование тачпадом

    map.controls.add("zoomControl", {
      // Добавляем контрол зуммирования
      position: {
        right: 10,
        top: 10,
      },
    });
  }

  function pickupInitMap() {
    hideAndRemoveRequiredFields();

    if (currentMap) {
      currentMap.destroy();
    }

    var map = new ymaps.Map("map", {
      center: [52.097621, 23.734051], // Центр карты
      zoom: 10, // Уровень масштаба
    });

    currentMap = map; // Сохраняем текущую карту

    // Фиксированные координаты для точки самовывоза
    var pickupCoords = [52.1, 23.73]; // Укажите нужные координаты

    // Создание метки
    var placemark = new ymaps.Placemark(
      pickupCoords,
      {
        balloonContent: "Пункт самовывоза", // Текст в баллоне
      },
      {
        preset: "islands#icon", // Тип иконки метки
        iconColor: "#0095b6", // Цвет иконки
      }
    );

    // Добавляем метку на карту
    map.geoObjects.add(placemark);

    // Получаем адрес по фиксированным координатам
    ymaps.geocode(pickupCoords).then(function (res) {
      var address = res.geoObjects.get(0).getAddressLine();
      document.getElementById("search-input").value = address; // Устанавливаем адрес в поле ввода
    });
  }

  const deliveryButton = document.getElementById("delivery-button");
  deliveryButton.addEventListener("click", function () {
    ymaps.ready(deliveryInitMap);
  });

  const pickupButton = document.getElementById("pickup-button");
  pickupButton.addEventListener("click", function () {
    ymaps.ready(pickupInitMap);
  });

  ymaps.ready(deliveryInitMap);
});
