jQuery(document).ready(function ($) {
  let basePrice = parseFloat(wc_addon_options.product_price);

  $(".addon-radio").on("change", function () {
    let addonPrice = parseFloat($(this).val());
    let newPrice = basePrice + addonPrice;

    $(".woocommerce-Price-amount").text(newPrice.toFixed(2));
  });
});
