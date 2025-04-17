document.addEventListener('DOMContentLoaded', function () {
    $(function () {
        var $buttons = $(".payment-option");
        var $changeBlock = $("#change_block");
        var $changeInput = $("#change_amount");
        var $paymentType = $("#payment_type");

        function updatePayment($button) {
            $buttons.removeClass("active");
            $buttons.find(".indicator").removeClass("bg-primary");
            $button.addClass("active");
            $button.find(".indicator").addClass("bg-primary");
            $paymentType.val($button.val());
            if ($button.val() === "2") {
                $changeBlock.show();
                $changeInput.prop("disabled", false).attr("required", true);
            } else {
                $changeBlock.hide();
                $changeInput.prop("disabled", true).removeAttr("required");
            }
        }

        $buttons.on("click", function () {
            updatePayment($(this));
        });

        var initialPayment = $paymentType.val();
        if (initialPayment === "2") {
            updatePayment($("#payment_cod"));
        } else {
            updatePayment($("#payment_card"));
        }
    });
});

