<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>


<?php if (!$arResult['IS_OPEN']): ?>
    <div class="space-y-4 text-black empty:hidden" >

        <div class="flex items-center gap-4 rounded-lg p-2 shadow-md bg-amber-200" >
            <span style="margin-left: 10px" class="iconify i-ri:time-line icon" aria-hidden="true"></span>
            <div >
                <div class="whitespace-pre-wrap leading-none" >Сейчас магазин не работает</div>
            </div>
        </div>

    </div>
<?php endif; ?>