$(document).ready(function () {
  
      $(".with-lable  input, .with-lable  textarea").on("focusout", function () {
         if ($(this).val() != "") {
            $(this).addClass("has-content");
            $(this)
            .find(".focus-border")
            .addClass("w-100");
            $(".card-popup .disable").removeClass("disabled");
         } else {
            $(this).removeClass("has-content");
            $(this)
            .find(".focus-border")
            .removeClass("w-100");
            $(".card-popup  .disable").addClass("disabled");
         }
      });
   });