
var currentMap = null;

// Функция инициализации карты. Если существует предыдущее экземпляр карты – уничтожаем его.
function initMap(mapContainerId, center, zoom) {
    if (currentMap) {
        currentMap.destroy();
    }
    const map = new ymaps.Map(mapContainerId, {
        center: center,
        zoom: zoom
    });
    currentMap = map;
    return map;
}

// Инициализация карты для доставки с реализацией подсказок
function deliveryInitMap() {
    // Показываем поля для доставки
    showAndRequireFields();
    const map = initMap("map", [52.097621, 23.734051], 10);

    const searchInput = document.getElementById("search-input");
    const suggestions = document.getElementById("suggestions");

    // Обработчик ввода для получения подсказок адресов
    searchInput.addEventListener("input", function () {
        const query = searchInput.value.trim();
        if (query.length > 2) {
            fetchSuggestions(query);
        } else {
            suggestions.innerHTML = "";
        }
    });

    // Запрос подсказок с использованием Yandex Geocode API
    function fetchSuggestions(query) {
        const apiKey = "84eaac21-a0f1-46e4-8faa-258382d17245";
        // Центр поиска – Брест (в формате "долгота,широта")
        const ll = "23.734051,52.097621";
        // Размер области поиска – подберите значения по необходимости
        const spn = "0.1,0.1";
        // Параметр rspn=1 ограничивает поиск указанной областью
        const url = `https://geocode-maps.yandex.ru/1.x/?apikey=${apiKey}&format=json&geocode=${encodeURIComponent(query)}&ll=${ll}&spn=${spn}&rspn=1`;

        fetch(url)
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                displaySuggestions(data);
            })
            .catch(function (error) {
                console.error("Ошибка загрузки подсказок:", error);
            });
    }

    // Отображение подсказок
    function displaySuggestions(data) {
        const items = data.response.GeoObjectCollection.featureMember;
        suggestions.innerHTML = "";

        if (items.length > 0) {
            items.forEach(function (item) {
                const address = item.GeoObject.metaDataProperty.GeocoderMetaData.text;
                const coords = item.GeoObject.Point.pos.split(" ").map(Number).reverse();
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

    // Выбор подсказки из выпадающего списка
    function selectSuggestion(address, coords) {
        searchInput.value = address;
        map.setCenter(coords, 14);
        const placemark = new ymaps.Placemark(coords, {
            balloonContent: address,
        }, {
            preset: "islands#icon",
            iconColor: "#0095b6",
        });
        map.geoObjects.removeAll();
        map.geoObjects.add(placemark);
        suggestions.innerHTML = "";
    }

    // Обратное геокодирование по клику на карте
    map.events.add("click", async function (e) {
        const coords = e.get("coords");
        try {
            const res = await ymaps.geocode(coords);
            if (res.geoObjects.getLength() > 0) {
                const firstGeoObject = res.geoObjects.get(0);
                const address = firstGeoObject.getAddressLine();
                searchInput.value = address;
                map.geoObjects.removeAll();
                const placemark = new ymaps.Placemark(coords, {
                    balloonContent: address,
                }, {
                    preset: "islands#icon",
                    iconColor: "#0095b6",
                });
                map.geoObjects.add(placemark);
                console.log("Адрес по клику:", address);
            } else {
                console.warn("Не найдено объектов по данным координатам.");
            }
        } catch (error) {
            console.error("Ошибка обратного геокодирования:", error);
        }
    });

    // Удаляем ненужные элементы управления картой
    map.controls.remove("geolocationControl");
    map.controls.remove("searchControl");
    map.controls.remove("trafficControl");
    map.controls.remove("typeSelector");
    map.controls.remove("fullscreenControl");
    map.controls.remove("rulerControl");

    // Включаем управление масштабированием через прокрутку и multiTouch
    map.behaviors.enable(["scrollZoom", "multiTouch"]);
    map.controls.add("zoomControl", {
        position: {
            right: 10,
            top: 10,
        },
    });
}


function pickupInitMap() {
    // Прячем поля, не нужные для самовывоза
    hideAndRemoveRequiredFields();

    // Создаём (или пересоздаём) карту
    const map = initMap("map", [52.097621, 23.734051], 10);

    // Массив пунктов самовывоза
    var pickupPoints = [
        {
            coords: [52.1, 23.73],
            label: "Брест, улица Янки Купалы, 1к3"
        },
        {
            coords: [52.11, 23.75],
            label: "Брест, улица Янки Купалы, 104"
        }
    ];

    // Находим контейнер для опций (радиокнопок) – он должен находиться внутри формы
    var addressesContainer = document.getElementById("warehouse-addresses");
    addressesContainer.innerHTML = ""; // Очищаем контейнер

    // Добавляем скрытое поле в форму, чтобы выбранный адрес отправлялся на сервер
    const pickupForm = document.getElementById("pickupForm");
    var hiddenAddressInput = document.createElement("input");
    hiddenAddressInput.type = "hidden";
    hiddenAddressInput.name = "selected_address";
    // Добавляем скрытое поле прямо в форму (например, в конец)
    pickupForm.appendChild(hiddenAddressInput);

    // Массив меток для дальнейшего использования (если нужно)
    var placemarks = [];

    // Функция, очищающая визуальное выделение всех опций
    function clearSelectedOptions() {
        var optionDivs = addressesContainer.querySelectorAll(".pickup-option");
        optionDivs.forEach(function (div) {
            div.classList.remove("bg-gray-100");
        });
    }

    pickupPoints.forEach(function (point, index) {
        // Создаём контейнер для одной опции – радиокнопка и подпись
        var optionContainer = document.createElement("div");
        optionContainer.className = "pickup-option mb-2 p-2 border rounded cursor-pointer flex items-center";

        // Создаём саму радиокнопку и обязательно указываем одинаковый name для группировки
        var radioElem = document.createElement("input");
        radioElem.type = "radio";
        radioElem.name = "pickup_selected";   
        radioElem.id = `pickup-option-${index}`;
        radioElem.value = index;
        radioElem.className = "cursor-pointer";

        // Создаём метку для радиокнопки
        var radioLabel = document.createElement("label");
        radioLabel.htmlFor = `pickup-option-${index}`;
        radioLabel.textContent = point.label;
        radioLabel.className = "ml-2 cursor-pointer";

        // Добавляем радиокнопку и метку в контейнер
        optionContainer.appendChild(radioElem);
        optionContainer.appendChild(radioLabel);
        addressesContainer.appendChild(optionContainer);

        // Создаём метку на карте
        var placemark = new ymaps.Placemark(
            point.coords,
            {
                balloonContent: point.label
            },
            {
                preset: "islands#icon",
                iconColor: "#0095b6"
            }
        );
        map.geoObjects.add(placemark);
        placemarks.push(placemark);

        // Обработчик клика по метке на карте:
        placemark.events.add("click", function () {
            // Центрируем карту на выбранном пункте
            map.setCenter(point.coords, 14);

            // Отмечаем соответствующую радиокнопку
            radioElem.checked = true;
            clearSelectedOptions();
            optionContainer.classList.add("bg-gray-100");

            // Выполняем геокодирование для получения реального адреса и обновляем подпись и скрытое поле
            ymaps.geocode(point.coords)
                .then(function (res) {
                    if (res.geoObjects.getLength() > 0) {
                        var address = res.geoObjects.get(0).getAddressLine();
                        radioLabel.textContent = address;
                        hiddenAddressInput.value = address;
                    }
                })
                .catch(function (err) {
                    console.error("Ошибка геокодирования:", err);
                });
        });

        // Обработчик изменения радиокнопки (при выборе опции в списке)
        radioElem.addEventListener("change", function () {
            // Центрируем карту и открываем balloon у метки
            map.setCenter(point.coords, 14);
            placemark.balloon.open();
            clearSelectedOptions();
            optionContainer.classList.add("bg-gray-100");

            // Геокодируем, чтобы получить адрес, обновляем подпись и скрытое поле
            ymaps.geocode(point.coords)
                .then(function (res) {
                    if (res.geoObjects.getLength() > 0) {
                        var address = res.geoObjects.get(0).getAddressLine();
                        radioLabel.textContent = address;
                        hiddenAddressInput.value = address;
                    }
                })
                .catch(function (err) {
                    console.error("Ошибка геокодирования:", err);
                });
        });

        // Если это первый пункт – выбираем его по умолчанию
        if (index === 0) {
            radioElem.checked = true;
            optionContainer.classList.add("bg-gray-100");
            map.setCenter(point.coords, 10);
            ymaps.geocode(point.coords)
                .then(function (res) {
                    if (res.geoObjects.getLength() > 0) {
                        var address = res.geoObjects.get(0).getAddressLine();
                        radioLabel.textContent = address;
                        hiddenAddressInput.value = address;
                    }
                });
        }

        // Дополнительно можно сделать так, чтобы клик по всему контейнеру выбирал вариант
        optionContainer.addEventListener("click", function () {
            radioElem.checked = true;
            radioElem.dispatchEvent(new Event("change", { bubbles: true }));
        });
    });
}
