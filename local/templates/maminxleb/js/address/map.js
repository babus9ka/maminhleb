
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
    showAndRequireFields();

    const map = initMap("map", [52.097621, 23.734051], 10);
    const searchInput = document.getElementById("search-input");
    const suggestions = document.getElementById("suggestions");

    // Очищаем подсказки, если клик вне input и подсказок
    document.addEventListener("click", function (e) {
        if (!searchInput.contains(e.target) && !suggestions.contains(e.target)) {
            suggestions.innerHTML = "";
            suggestions.style.display = "none";
        }
    });

    searchInput.addEventListener("input", function () {
        const query = searchInput.value.trim();
        if (query.length > 2) {
            fetchSuggestions(query);
        } else {
            suggestions.innerHTML = "";
            suggestions.style.display = "none";
        }
    });

    function fetchSuggestions(query) {
        const apiKey = "84eaac21-a0f1-46e4-8faa-258382d17245";
        const ll = "23.734051,52.097621";
        const spn = "0.1,0.1";
        const url = `https://geocode-maps.yandex.ru/1.x/?apikey=${apiKey}&format=json&geocode=${encodeURIComponent(query)}&ll=${ll}&spn=${spn}&rspn=1`;

        fetch(url)
            .then(response => response.json())
            .then(data => displaySuggestions(data))
            .catch(error => {
                console.error("Ошибка загрузки подсказок:", error);
            });
    }

    function displaySuggestions(data) {
        const items = data.response.GeoObjectCollection.featureMember;
        suggestions.innerHTML = "";
        suggestions.style.display = "block";

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
        suggestions.style.display = "none";
    }

    // ✅ Обратное геокодирование с задержкой и проверками
    map.events.add("click", function (e) {
        setTimeout(async function () {
            if (typeof ymaps === "undefined" || typeof ymaps.geocode !== "function") {
                console.error("Yandex Maps не загружены");
                return;
            }

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
                    console.warn("Не найдено объектов по координатам.");
                }
            } catch (error) {
                console.error("Ошибка обратного геокодирования:", error);
            }
        }, 100); // Задержка для стабильности
    });

    map.controls.remove("geolocationControl");
    map.controls.remove("searchControl");
    map.controls.remove("trafficControl");
    map.controls.remove("typeSelector");
    map.controls.remove("fullscreenControl");
    map.controls.remove("rulerControl");

    map.behaviors.enable(["scrollZoom", "multiTouch"]);
    map.controls.add("zoomControl", {
        position: {
            right: 10,
            top: 10,
        },
    });
}


function pickupInitMap() {
    hideAndRemoveRequiredFields();
    const map = initMap("map", [52.097621, 23.734051], 10);

    const addressesContainer = document.getElementById("warehouse-addresses");
    addressesContainer.innerHTML = "";

    const pickupForm = document.getElementById("pickupForm");
    const hiddenAddressInput = document.createElement("input");
    hiddenAddressInput.type = "hidden";
    hiddenAddressInput.name = "selected_address";
    pickupForm.appendChild(hiddenAddressInput);

    const placemarks = [];

    function clearSelectedOptions() {
        const optionDivs = addressesContainer.querySelectorAll(".pickup-option");
        optionDivs.forEach(div => div.classList.remove("bg-gray-100"));
    }

    BX.ready(function () {
        BX.ajax.runComponentAction('shelton:address', 'getWarehouses', {
            mode: 'class'
        }).then(function (response) {
            const pickupPoints = response.data;

            pickupPoints.forEach(function (point, index) {
                const optionContainer = document.createElement("div");
                optionContainer.className = "pickup-option mb-2 p-2 border rounded cursor-pointer flex items-center";

                const radioElem = document.createElement("input");
                radioElem.type = "radio";
                radioElem.name = "pickup_selected";
                radioElem.id = `pickup-option-${index}`;
                radioElem.value = point.id;
                radioElem.className = "cursor-pointer";

                const radioLabel = document.createElement("label");
                radioLabel.htmlFor = `pickup-option-${index}`;
                radioLabel.textContent = point.label;
                radioLabel.className = "ml-2 cursor-pointer";

                optionContainer.appendChild(radioElem);
                optionContainer.appendChild(radioLabel);
                addressesContainer.appendChild(optionContainer);

                const placemark = new ymaps.Placemark(point.coords, {
                    balloonContent: point.label
                }, {
                    preset: "islands#icon",
                    iconColor: "#0095b6"
                });

                map.geoObjects.add(placemark);
                placemarks.push(placemark);

                placemark.events.add("click", function () {
                    map.setCenter(point.coords, 14);
                    radioElem.checked = true;
                    clearSelectedOptions();
                    optionContainer.classList.add("bg-gray-100");
                    hiddenAddressInput.value = point.label;
                });

                radioElem.addEventListener("change", function () {
                    map.setCenter(point.coords, 14);
                    placemark.balloon.open();
                    clearSelectedOptions();
                    optionContainer.classList.add("bg-gray-100");
                    hiddenAddressInput.value = point.label;
                });

                if (index === 0) {
                    radioElem.checked = true;
                    optionContainer.classList.add("bg-gray-100");
                    map.setCenter(point.coords, 10);
                    hiddenAddressInput.value = point.label;
                }

                optionContainer.addEventListener("click", function () {
                    radioElem.checked = true;
                    radioElem.dispatchEvent(new Event("change", { bubbles: true }));
                });
            });
        }).catch(function (err) {
            console.error("Ошибка загрузки складов:", err);
        });
    });
}
