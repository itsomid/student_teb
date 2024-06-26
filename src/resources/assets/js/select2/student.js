$(document).ready(function() {
    let apiUrl = $('#selectStudent').attr('src');
    $('#selectStudent').select2({
        ajax: {
            url: apiUrl,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(function(user) {
                        return {
                            id: user.id,
                            text: user.name +' | '+ user.mobile
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 1,
        placeholder: 'جهت انتخاب دانش آموز کلیک کنید',
        allowClear: true
    });
});
