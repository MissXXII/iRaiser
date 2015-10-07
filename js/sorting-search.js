// Hide or show the premium and lowcost rows by clicking checkboxes
function sortingByVersion(version) {
    // Check if the 2 versions are displayed, if not no need checkboxes so hide them
    if (!$("#" + version + "charts").length || !$("#" + version + "charts").length) {
        $(".checkbox-version").hide();
    }
    ;
    // when checkboxes are checked or not toggle visiblity
    $("#" + version).change(function () {
        $("#" + version + "charts").toggle();
        // in case of the title has been hidden
        if ($("#" + version + "charts .chartContainer:visible").length !== 0) {
            $("#" + version + "charts > .title").show();
        }
        ;
    });
}
;

// Hide or show charts by typing in the search input
function searchByName() {
    $("#search").keyup(function () {
        // Get the value of the input
        var str = $(this).val().toLowerCase();
        // If input is empty
        if (str === "") {
            $("#premiumcharts > div").show();
            $("#lowcostcharts > div").show();
        } else {
            $(".chartContainer").each(function () {
                var id = $(this).attr('id').toLowerCase();
                // If id is not in the string get by the input hide the div
                (id.indexOf(str) < 0) ? $(this).hide() : $(this).show();
            });
            // if all div of a version are hidden so hide the title
            if ($("#premiumcharts .chartContainer:visible").length === 0) {
                $("#premiumcharts > .title").hide();
            } else {
                $("#premiumcharts > .title").show();
            }

            if ($("#lowcostcharts .chartContainer:visible").length === 0) {
                $("#lowcostcharts > .title").hide();
            } else {
                $("#lowcostcharts > .title").show();
            }
        }
        ;
    });
}
;

$(document).ready(function () {
    searchByName();
    sortingByVersion("premium");
    sortingByVersion("lowcost");
});