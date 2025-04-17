document.addEventListener("DOMContentLoaded", function () {
    $(function () {
        // Логика для комментариев
        $('#saveCommentBtn').on('click', function () {
            var commentValue = $('#commentTextArea').val().trim();
            $('#orderCommentHidden').val(commentValue);
            $.magnificPopup.close();
        });

        // Инициализация Magnific Popup для комментариев
        $('.popup-comment').magnificPopup({
            type: 'inline',
            removalDelay: 300,
            mainClass: 'mfp-fade',
            closeBtnInside: true
        });
        $('#closeCommentModal').on('click', function () {
            $.magnificPopup.close();
        });
    });

    $(function () {
        // Логика для выбора даты/времени
        $('#closeDateTimeModal').on('click', function () {
            $.magnificPopup.close();
        });

        let selectedDate = null;
        const saveBtn = $('#saveDateTimeBtn');
        const container = $('#dateSwiper');
        const dateHiddenInput = $('#orderDateHidden');

        container.on('click', 'swiper-slide', function () {
            container.find('swiper-slide').removeClass('active');
            $(this).addClass('active');
            selectedDate = $(this).text().trim();
            saveBtn.prop('disabled', false);
        });

        let asapActive = false;
        $('#asapBtn').on('click', function () {
            asapActive = !asapActive;
            if (asapActive) {
                $(this).attr('data-state', 'on').attr('aria-pressed', 'true');
                selectedDate = 'Как можно скорее';
                container.find('swiper-slide').removeClass('active');
                saveBtn.prop('disabled', false);
            } else {
                $(this).attr('data-state', 'off').attr('aria-pressed', 'false');
                selectedDate = null;
                saveBtn.prop('disabled', true);
            }
        });

        saveBtn.on('click', function () {
            console.log('Выбрана дата:', selectedDate);
            dateHiddenInput.val(selectedDate);
            $.magnificPopup.close();
        });

        // Инициализация Magnific Popup для выбора даты/времени
        $('.popup-datetime').magnificPopup({
            type: 'inline',
            removalDelay: 300,
            mainClass: 'mfp-fade',
            closeBtnInside: true
        });
    });
});