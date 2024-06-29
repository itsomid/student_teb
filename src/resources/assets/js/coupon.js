$( document ).ready(function() {
    $('#coupon-count-field-group').hide();
    $('#coupon-code-field-group').hide();

    $('#is_mass_field').on("change", function (e) {
        if (e.target.value === "-1") {
            $('#coupon-count-field-group').hide();
            $('#coupon-code-field-group').hide();
        }
        if (e.target.value === "0") {
            $('#coupon-count-field-group').hide();
            $('#coupon-code-field-group').show();
        }
        if (e.target.value === "1") {
            $('#coupon-count-field-group').show();
            $('#coupon-code-field-group').hide();
        }
    });
});
