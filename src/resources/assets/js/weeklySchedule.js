$(document).ready(function() {
    // Set up AJAX with CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Listen for changes in the textarea
    $('.studio-description-textarea').on('keyup', function() {
        let urlHref = window.location.href;
        let urlObject = new URL(urlHref);

        let domain = urlObject.hostname;
        domain = domain.replace(/^www\./, ''); // Remove 'www.' if it exists

        const protocol = urlObject.protocol;
        const port = urlObject.port ? `:${urlObject.port}` : ''; // Add port if it exists

        let textarea = $(this);
        let description = textarea.val();
        let classId = textarea.data('class-id');
        let courseId = textarea.data('course-id');
        let url = `${protocol}//${domain}${port}` + '/admin/courses/{course}/classes/{classes}/update_studio_description';

        url = url.replace('{course}', courseId).replace('{classes}', classId);

        // AJAX POST request
        $.ajax({
            url: "" + url,
            type: 'PATCH',
            data: {
                studio_description: description
            },
            success: function(response) {
                // Optionally display a success message
                console.log('Studio description updated successfully.');
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error updating studio description:', error);
                alert('An error occurred while updating the description. Please try again.');
            }
        });
    });

    // Listen for changes in the status select dropdown
    $('.status-select').on('change', function() {
        let urlHref = window.location.href;
        let urlObject = new URL(urlHref);

        let domain = urlObject.hostname;
        domain = domain.replace(/^www\./, ''); // Remove 'www.' if it exists

        const protocol = urlObject.protocol;
        const port = urlObject.port ? `:${urlObject.port}` : ''; // Add port if it exists


        let select = $(this);
        let classId = select.data('class-id');
        let courseId = select.data('course-id');
        let status = select.val();

        let url = `${protocol}//${domain}${port}` + '/admin/courses/{course}/classes/{classes}/update_status';
        url = url.replace('{course}', courseId).replace('{classes}', classId);

        // AJAX PATCH request
        $.ajax({
            url: url,
            type: 'PATCH',
            data: {
                status: status
            },
            success: function(response) {
                // Optionally display a success message
                console.log('Class status updated successfully.');
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error updating class status:', error);
                alert('An error occurred while updating the class status. Please try again.');
            }
        });
    });
});
