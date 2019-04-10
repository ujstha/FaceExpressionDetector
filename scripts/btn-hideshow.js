$(document).ready(function() {
    $('.personal-detail input').keyup(function() {

        var empty = false;
        $('.personal-detail input').each(function() {
            if ($(this).val().length == 0) {
                empty = true;
            }
        });

        if (empty) {
            $('#submitsnap').attr('disabled', 'disabled');
        } else {
            $('#submitsnap').attr('disabled', false);
        }
    });
});