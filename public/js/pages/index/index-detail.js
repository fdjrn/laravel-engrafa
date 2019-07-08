$(document).ready( function () {

    var dtHistory = $("#file-history-table").DataTable({
        processing: true,
        serverSide: true,
        "searching": false,
        // "dom": "<fl<t>ip>",
        ajax: "/index/file-history/" + $('#file-descr-id').val(),
        columns: [
            { data: "name" },
            { data: "created_at" },
            { data: "size_in_kb" },
            {data: "action", name: "action", orderable: false, searchable: false}
        ],
        columnDefs: [{
            targets: [0, 1, 3],
            className: "mdl-data-table__cell--non-numeric header-cursor"
        }]
    });

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
    });

    $('#file-detail-related').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            url: "/index/get-file/" + $('#file-descr-id').val(),
            type: 'GET',
            success: function (result) {
                $('.bs-modal-file-history').modal('show');
                $('#modal-history-caption').text(result.name);
                $('#fileHistoryId').val(result.id);

                let Id = (result.file_root == 0) ? result.id : result.file_root;
                dtHistory.ajax.url("/index/file-history/" + Id).load();
            },
            error: function (err) {
                console.log(err);
            }

        });

    })
});