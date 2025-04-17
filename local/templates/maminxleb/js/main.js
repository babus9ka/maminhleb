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
      removalDelay: 500,
      callbacks: {
        beforeOpen: function () {
          this.st.mainClass = this.st.el.attr("data-effect");
        },
      },
      midClick: true,
    });

    $(document).on("click", ".fff", function (e) {
      e.preventDefault();
      $.magnificPopup.close();
    });
  });
});


$(document).ready(function () {
  $('#orderButton').on('click', function (e) {
    e.preventDefault();
    $.magnificPopup.open({
      items: {
        src: '#address',
        type: 'inline'
      },
      modal: true,     

      midClick: true,
      callbacks: {
        beforeOpen: function () {
        }
      }
    });
  });

  $(document).on('click', '#closedOrderContainer', function (e) {
    e.preventDefault();
    $.magnificPopup.close();
  });
});