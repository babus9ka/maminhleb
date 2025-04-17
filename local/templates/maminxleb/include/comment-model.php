<div id="commentModal" class=" mfp-hide">
    <div id="reka-dialog-content-v-5-0-2" role="dialog" aria-describedby="reka-dialog-description-v-5-0-6"
        aria-labelledby="reka-dialog-title-v-5-0-5" tabindex="-1"
        class="relative m-auto flex w-full min-w-0 flex-col gap-4 overflow-hidden rounded-lg bg-white shadow-md focus:outline-hidden dark:bg-black p-5 max-w-lg">
        <h2 id="reka-dialog-title-v-5-0-5" class="pr-6 text-lg leading-none font-bold">
            Комментарий к заказу
        </h2>

        <div id="reka-dialog-description-v-5-0-6" class="space-y-4">
            <div class="space-y-4">
                <textarea id="commentTextArea"
                    class="focus:border-primary focus:ring-primary/30 w-full resize-y rounded-md border border-solid border-gray-200 bg-white px-5 py-2 transition placeholder:text-gray-400 focus:ring-4 focus:outline-hidden dark:border-gray-800 dark:bg-gray-950 dark:placeholder:text-gray-500"
                    placeholder="Что-то хотите уточнить?"></textarea>

                <button type="button" id="saveCommentBtn"
                    class="flex w-full bg-primary focus-visible:ring-primary/30 border-transparent text-white disabled:cursor-not-allowed cursor-pointer items-center justify-center rounded-md border border-solid px-4 py-3 text-center leading-none transition focus-visible:ring-4 focus-visible:outline-hidden disabled:opacity-50"
                    data-v-wave-boundary="true">
                    <div class="w-full">Сохранить</div>
                    <span class="iconify i-ri:loader-4-line icon absolute animate-spin" aria-hidden="true"
                        style="display: none;"></span>
                </button>
            </div>
        </div>

        <button type="button" id="closeCommentModal" class="absolute top-3 right-3 outline-hidden">
            <span class="iconify i-ri:close-fill icon text-gray-500 dark:text-gray-500" aria-hidden="true"></span>
        </button>
    </div>
</div>