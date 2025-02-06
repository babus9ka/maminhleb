$(function () {
  $(document).ready(function () {
    $(".authModalButton").magnificPopup({
      type: "inline",
      preloader: false,
      focus: "#username",
      modal: true,
    });

    $(document).on("click", ".closeAuthModalButton", function (e) {
      e.preventDefault();
      $.magnificPopup.close();
    });
  });
});

$(function () {
  $(document).ready(function () {
    $(".show-popup").magnificPopup({
      type: "inline",
      preloader: false,
      focus: "#username",
      modal: true,
      removalDelay: 500, // delay removal by X to allow out-animation
      callbacks: {
        beforeOpen: function () {
          this.st.mainClass = this.st.el.attr("data-effect");
        },
      },
      midClick: true, // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
    });

    $(document).on("click", ".fff", function (e) {
      e.preventDefault();
      $.magnificPopup.close();
    });
  });
});
