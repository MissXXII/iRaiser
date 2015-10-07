// Control if the start date is higher than the end date
function datepickerControl() {

    $("#submit-bt").click(function (event) {
        var end = $("#endDate").val();
        var start = $("#startDate").val();
        if (start > end) {
            $("#alert-zone .alert").addClass('alert-warning');
            $("#alert-zone").show();
            $("#alert-msg").text("La date de début doit être inférieure à la date de fin");
            event.preventDefault();
        }
    });
    $(".datepickers").change(function () {
        var end = $("#endDate").val();
        var start = $("#startDate").val();
        
        if (start < end) {
            $("#alert-zone").hide();
            $("#alert-zone > .alert").removeClass('alert-warning');
            $("#alert-msg").text("");
        }
    });
}

$(document).ready(function () {
    datepickerControl();
});






