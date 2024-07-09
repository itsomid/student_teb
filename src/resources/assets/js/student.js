$(document).ready(function () {
    let apiUrl = $('#selectStudent').attr('src');
    let selectedIds = $('#selectStudent').data('selected');

    $('#selectStudent').select2({
        ajax: {
            url: apiUrl,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(function (user) {
                        return {
                            id: user.id,
                            text: user.name + ' | ' + user.mobile
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        placeholder: 'جهت انتخاب دانش آموز کلیک کنید',
        allowClear: true,
        language: {
            inputTooShort: function (args) {
                // args.minimum is the minimum required length
                // args.input is the user-typed text
                return "لطفا ۲ یا بیشتر کاراکتر وارد کن";
            },
            noResults: function() {
                return "نتیجه ای نداشت.";
            },
        }
    });

    if (selectedIds && selectedIds.length) {
        console.log(selectedIds,selectedIds.length )
        $.ajax({
            type: 'GET',
            url: apiUrl,
            dataType: 'json'
        }).then(function (data) {
            selectedIds.forEach(function(selectedIds) {
                // Find the user with the selectedId
                let selectedUser = data.find(user => user.id === selectedIds);


                // Create a new option element with the selected user's data
                let option = new Option(selectedUser.name || selectedUser.mobile, selectedUser.id, true, true);
                // Append it to the select element
                $('#selectStudent').append(option).trigger('change');
            });
        });
    }

});


