$(document).ready( function () {
    $('#link-to-index').on('click', function (e) {
        e.preventDefault();
        $('#frm-index_detail').submit();
    });

    $('#file_detail-print').on('click', function (e) {
        let ifr = document.getElementById("index-detail-iframe");
        let urlTarget = ifr.src;
        window.open(urlTarget, "_blank");
        window.print();
        window.close();
    });

    $('#edit-file').on('click', function (e) {
        e.preventDefault();
        let id = $('#file-descr-id').val();
        let csrf_token = $('meta[name="csrf-token"]').attr('content');

        Swal({
            title: 'Update File Description',
            input: 'text',
            inputPlaceholder: 'Enter your new file description'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/index/update-file/' + id,
                    type: 'POST',
                    data: {
                        '_method': 'POST',
                        '_token': csrf_token,
                        'fieldName': 'description',
                        'filecomment': result.value
                    },
                    success: function (response) {
                        Swal({
                            title: 'Success!',
                            text: response.message,
                            type: 'success',
                            timer: '2000'
                        });
                        $('#index-detail-descr').text(response.data.description);
                    },
                    fail: function () {
                        Swal({
                            title: 'Failure!',
                            text: 'Your file description has not been updated.',
                            type: 'error',
                            timer: '2000'
                        });
                    }
                });
            }
        })
    });

    $('#delete-file').on('click', function (e) {
        e.preventDefault();
        let id = $('#file-descr-id').val();
        let csrf_token = $('meta[name="csrf-token"]').attr('content');

        if (id === ''){
            swal("Warning!!!",
                'No files/folder selected',
                'warning');
            return;
        }

        Swal({
            title: 'Are you sure?',
            text: '"' + $('#file-descr-name').text() + '" will be deleted. You won\'t be able to revert this!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/index/delete-file/' + id,
                    type: 'POST',
                    data: {'_method': 'DELETE', '_token': csrf_token},
                    success: function (response) {
                        if (response.success) {
                            Swal({
                                title: 'Success!',
                                text: response.message,
                                type: 'success',
                                timer: '2000'
                            });
                        }
                        $('#link-to-index').click();
                    },
                    fail: function () {
                        Swal({
                            title: 'Failure!',
                            text: 'Your file/folder has not been deleted.',
                            type: 'error',
                            timer: '2000'
                        });
                    }


                });
            }
        });
    });

    $('#file_detail-download').on('click', function (e) {
        e.preventDefault();
        let url = '/index/download-file/' + $('#file-descr-id').val();
        $(location).attr('href',url);
    })
});