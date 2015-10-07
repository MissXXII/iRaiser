
// Control if the start date is higher than the end date
var creationFormControl = function () {
    var i = 1;
    // Clone a row of statistics inputs and set attributes
    $('#btn-creation-add').click(i, function () {
        i++;
        console.log("incrément i = " + i);
        $('#stat1').clone().appendTo('#stat-inputs').attr('id', 'stat' + i);
        $('#stat' + i + ' strong').text('Statistique ' + i + ' :');
        $('#stat' + i + ' #color').attr('name', 'color-stat[' + i + ']');
        $('#stat' + i + ' #label').attr('name', 'label-stat[' + i + ']');
        $('#stat' + i + ' button').attr('id', 'btn-creation-delete' + i);
        $('#btn-creation-delete' + (i - 1)).attr('style', 'visibility:hidden');
        $('#btn-creation-delete' + i).attr('style', 'visibility:show').click(deleteStatRow());
    });


    var deleteStatRow = function () {
        $('#btn-creation-delete' + i).click(function () {
            $(this).closest('p').remove();
            if (i > 1) {
                if (i > 2) {
                    $('#btn-creation-delete' + (i - 1)).attr('style', 'visibility:show');
                }
                i--;
                console.log("décrement i = " + i);
            }
        });
    };
};





$(document).ready(function () {
    creationFormControl();
});

