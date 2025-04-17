<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>

<div id="address"
    class="mfp-with-anim mfp-hide fixed inset-0 z-20 flex items-center justify-center overflow-y-auto bg-black/50 p-4 dark:bg-white/20 dark:backdrop-brightness-50"
    style="pointer-events: auto;">

    <div class="relative m-auto flex w-full min-w-0 flex-col gap-4 overflow-hidden rounded-lg bg-white shadow-md data-[state=closed]:animate-fadeOut data-[state=open]:animate-contentShow focus:outline-none dark:bg-black max-w-[840px]"
        style="pointer-events: auto;">
        <h2 class="pr-6 text-lg font-bold leading-none hidden"></h2>
        <div id="reka-dialog-description-v-1" class="space-y-4">
            <div class="flex">
                <div class="flex h-[640px] w-[370px] shrink-0 flex-col space-y-4 p-4">

                    <div role="radiogroup" aria-required="false" dir="ltr" tabindex="0"
                        class="flex h-11 w-full rounded-md border bg-white dark:border-gray-800 dark:bg-gray-900 shrink-0"
                        style="outline: none;">
                        <button id="delivery-button" type="button"
                            class="h-full grow basis-0 truncate rounded-md bg-transparent px-2 leading-none text-gray-400 outline-1 outline-primary transition data-[state=checked]:border-transparent data-[state=checked]:bg-primary data-[state=checked]:text-white data-[state=checked]:outline dark:text-gray-300"
                            tabindex="0" data-active="true" data-reka-collection-item="" required="false">
                            <span>Доставка</span>
                        </button>
                        <button id="pickup-button" type="button"
                            class="h-full grow basis-0 truncate rounded-md bg-transparent px-2 leading-none text-gray-400 outline-1 outline-primary transition data-[state=checked]:border-transparent data-[state=checked]:bg-primary data-[state=checked]:text-white data-[state=checked]:outline dark:text-gray-300"
                            tabindex="-1" data-active="false" data-reka-collection-item="" required="false">
                            <span>Самовывоз</span>
                        </button>
                    </div>

                    <form id="deliveryForm" class="flex min-h-0 grow flex-col">

                        <div class="-m-1.5 space-y-4 overflow-y-auto p-1.5 scrollbar-thin">

                            <input type="hidden" name="delivery_service_id" value="2" id="deliveryServiceId">

                            <div dir="ltr" class="relative w-full">
                                <div class="relative flex items-center">
                                    <span style="top: 7px"
                                        class="iconify i-ri:map-pin-range-fill icon pointer-events-none absolute left-2 ml-px text-primary"
                                        aria-hidden="true">
                                    </span>

                                    <div class="search-bar">
                                        <input name="address" id="search-input" aria-disabled="false" type="text"
                                            aria-autocomplete="list" role="combobox" autocomplete="no"
                                            placeholder="Укажите адрес"
                                            class="flex h-11 w-full gap-2.5 truncate rounded-md border border-gray-200 bg-white px-10 placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                                            required="" value="" placeholder="Введите адрес...">
                                        <div id="suggestions" class="suggestions"></div>
                                    </div>

                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-x-3 gap-y-4">
                                <div class="relative w-full">
                                    <input name="entrance"
                                        class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                                        placeholder=" " autocomplete="entrance" id="entrance" required=""
                                        inputmode="numeric">
                                    <span
                                        class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">Подъезд</span>
                                </div>
                                <div class="relative w-full">
                                    <input name="intercom"
                                        class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                                        placeholder=" " autocomplete="doorphone" id="doorphone">
                                    <span
                                        class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">Домофон</span>
                                </div>
                                <div class="relative w-full">
                                    <input name="floor"
                                        class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                                        placeholder=" " autocomplete="floor" id="floor" required="" inputmode="numeric">
                                    <span
                                        class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">Этаж</span>
                                </div>
                                <div class="relative w-full">
                                    <input name="apartment"
                                        class="peer w-full rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-500 focus:border-primary focus:ring-4 focus:ring-primary/30 disabled:cursor-not-allowed dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                                        placeholder=" " autocomplete="flat" id="flat" required="" inputmode="numeric">
                                    <span
                                        class="pointer-events-none absolute -top-2 left-6 transform rounded bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent peer-placeholder-shown:px-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:peer-placeholder-shown:ml-1 dark:bg-gray-950 dark:text-gray-400 dark:peer-placeholder-shown:text-gray-500">Квартира</span>
                                </div>
                                <div id="privateHouseContainer" class="col-span-2 flex items-center gap-3">
                                    <input type="checkbox" name="private_house"
                                        class="h-5 w-5 rounded border-gray-300 text-primary transition focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/30 focus:ring-offset-0 dark:border-gray-800 dark:bg-gray-950"
                                        id="privateHouse">
                                    <label for="privateHouse">Частный дом</label>
                                </div>
                                <div class="col-span-2 space-y-1">
                                    <textarea name="address-comment"
                                        class="w-full resize-y rounded-md border border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-400 focus:border-primary focus:ring-4 focus:ring-primary/30 dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500 min-h-14"
                                        id="addressComment" autocomplete="addressComment"
                                        placeholder="Примечание к адресу"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="shrink-0 pt-4">
                            <button id="confirmAdress" type="button"
                                class="flex w-full border-transparent bg-primary text-white focus-visible:ring-primary/30 disabled:cursor-not-allowed items-center justify-center rounded-md border px-4 py-3 text-center leading-none transition focus-visible:outline-none focus-visible:ring-4 disabled:opacity-50"
                                data-v-wave-boundary="true">
                                <div class="w-full">Подтвердить адрес</div>
                                <span class="iconify i-ri:loader-4-line icon absolute animate-spin" aria-hidden="true"
                                    style="display: none;">
                                </span>
                            </button>
                        </div>

                        <div class="error"></div>

                    </form>

                    <form id="pickupForm" class="flex min-h-0 flex-col">
                        <div class="-m-1.5 space-y-4 overflow-y-auto p-1.5 scrollbar-thin">
                            <div id="warehouse-addresses" class="space-y-4 mb-4">
                                <input type="text" name="pickup_address" placeholder="Адрес пункта выдачи">
                            </div>
                        </div>
                        <div class="shrink-0 pt-4">
                            <button id="confirmPickup" type="button"
                                class="flex w-full border-transparent bg-primary text-white items-center justify-center rounded-md border px-4 py-3 text-center leading-none transition focus:outline-none focus:ring-4 disabled:opacity-50">
                                <div class="w-full">Подтвердить самовывоз</div>
                                <span class="iconify i-ri:loader-4-line icon absolute animate-spin" aria-hidden="true"
                                    style="display: none;"></span>
                            </button>
                        </div>
                    </form>

                </div>

                <div class="map-container">
                    <div id="map"></div>
                </div>

            </div>
        </div>
        <button id="closedOrderContainer" type="button" class="absolute right-3 top-3 outline-none">
            <div class="grid h-8 w-8 place-items-center rounded-full bg-white shadow">
                <span class="address__popup-closed conify i-ri:close-fill icon text-gray-800" aria-hidden="true"></span>
            </div>
        </button>

    </div>

</div>

<?
$this->addExternalJS(SITE_TEMPLATE_PATH . "/js/address/main.js");
$this->addExternalJS(SITE_TEMPLATE_PATH . "/js/address/ui.js");
$this->addExternalJS(SITE_TEMPLATE_PATH . "/js/address/map.js");
?>

<?php
if ($APPLICATION->GetCurDir() == SITE_DIR) {
    $this->addExternalJS(SITE_TEMPLATE_PATH . "/js/address/address-index.js");
} elseif ($APPLICATION->GetCurDir() == "/checkout/") {
    $this->addExternalJS(SITE_TEMPLATE_PATH . "/js/address/address-checkout.js");
}
?>