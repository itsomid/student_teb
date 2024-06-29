$(document).ready(function() {
    let apiUrl     = $('#selectStudent').attr('src');
    let selectedId = $('#selectStudent').data('selected');

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

    if (selectedId) {
        $.ajax({
            type: 'GET',
            url: apiUrl,
            dataType: 'json'
        }).then(function (data) {
            // Find the user with the selectedId
            let selectedUser = data.find(user => user.id === selectedId);
            // Create a new option element with the selected user's data
            var option = new Option(selectedUser.name || selectedUser.mobile, selectedUser.id, true, true);
            // Append it to the select element
            $('#selectStudent').append(option).trigger('change');
        });
    }
});

