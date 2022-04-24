$(function () {
    $('#videoFile').change(function (ev) {
        $(ev.target).closest('form').trigger('submit');
    })
});