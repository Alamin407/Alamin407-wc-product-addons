jQuery(document).ready(function ($) {
  // Add new addon field
  $("#add-addon-button").on("click", function () {
    const addonRowHtml = `
          <div class="addon-field-row">
              <p class="form-field">
                  <label>Addon Title</label>
                  <input type="text" name="addon_titles[]" class="short" placeholder="Enter title" />
              </p>
              <p class="form-field">
                  <label>Addon Price</label>
                  <input type="number" step="0.01" name="addon_prices[]" class="short" placeholder="Enter price" />
              </p>
              <button type="button" class="button remove-addon-button">Remove Addon</button>
          </div>`;
    $("#addon-fields-container").append(addonRowHtml);
  });

  // Remove addon field
  $(document).on("click", ".remove-addon-button", function () {
    $(this).closest(".addon-field-row").remove();
  });
});
