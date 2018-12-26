Dropzone.autoDiscover = false;
var csrf_token = $('meta[name="csrf-token"]').attr('content');

function bookmarkFile(id) {
    $.ajax({
        url: "/index/bookmark-file/" + id,
        type: "POST",
        data: {'_token': csrf_token},
        success: function (response) {
            swal({
                title: 'Bookmark Success!',
                text: response.data.name + ", " + response.message,
                type: 'success',
                timer: '2000'
            })
        },
        error: function (data) {
            swal({
                title: 'Bookmark Failed!',
                text: data.responseJSON.data.name + ", " + data.responseJSON.message,
                type: 'error',
                timer: '2000'
            })
        }
    });
}

function downloadFile(id) {
    $.get({
        url: '/index/download-file/' + id,
        success: function (response) {
            if (response.status === 'failed') {
                swal({
                    title: 'Download Failed!!',
                    text: 'Allowed download tiype is file only',
                    type: 'error',
                    timer: '2000'
                })
            }
        }

    })
}

function setComment(id) {
    $.ajax({
        url: "/index/get-file/" + id,
        type: "GET",
        success: function (data) {
            $('#comment-modals').modal('show');
            if (data.is_file === 0) {
                $('#modal-caption').html('<i class="fa fa-folder"></i><span> Add/Update Comments</span>');
                $('#file-name-modal').text('Folder Name: ' + data.name);
            } else {
                $('#modal-caption').html('<i class="fa fa-file"></i><span> Add/Update Comments</span>');
                $('#file-name-modal').text('File Name: ' + data.name);
            }

            $('#label-file-comments').text('Comment: ');
            $('#comment-modals .file-comment').val(data.comment ? data.comment : "");
            $('#fileCommentId').val(data.id);
            $('#fieldName').val('comment');
        },
        error: function (response) {
            console.log(response);
        }
    })
}

$(document).ready(function () {
    var rootFolderId = 0;
    var rootFolderName = "";
    var closeModalInterval;
    var filesId = $('input:hidden[name = f_id]').val();

    var dtMain = $("#dt-file-exp-table-index").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/index/list-all/" + filesId,
            error: function (xhr, status, err) {
                if (err === 'Unauthorized') {
                    window.location.href = '/login';
                }
            }
        },
        columns: [
            {data: "checkbox", name: "file-exp-checkbox", orderable: false, searchable: false},
            {
                data: "name",
                "fnCreatedCell": function (nTd, sData, oData) {

                    if (oData.is_file === '1') {
                        $(nTd).html("<span><i class='fa fa-file fa-lg'></i></span>&nbsp; " + sData);
                    } else {
                        $(nTd).html("<span><i class='fa fa-folder fa-lg'></i></span>&nbsp; " + sData);
                    }
                }
            },
            {data: "updated_at"},
            {data: "owner"},
            {
                data: "comment",
                "fnCreatedCell": function (nTd, sData, oData) {
                    if (sData !== null) {
                        $(nTd).html("<a class='btn btn-outline-warning btn-xs' onclick='setComment(" + oData.id + ")'>" +
                            "<span><i class='fa fa-comment fa-2x'></i></span></a> " + sData);

                    } else {
                        $(nTd).html("<a class='btn btn-outline-warning btn-xs' onclick='setComment(" + oData.id + ")'>" +
                            "<span><i class='fa fa-comment fa-2x'></i></span></a> ");
                    }
                }
            },
            {data: "action", name: "action", orderable: false, searchable: false}
        ],
        columnDefs: [{
            targets: [0, 1, 2, 3, 4, 5],
            className: "mdl-data-table__cell--non-numeric header-cursor"
        }],
        "fnDrawCallback": function () {
            var api = this.api();
            var json = api.ajax.json();

            rootFolderId = json.mainRootFolderId;
            rootFolderName = json.mainRootFolderName;
            $("#root-folder-name").text(rootFolderName);

            filesId = json.mainRootFolderId;
        }
    });

    var dtFolder = $("#dt-list-folder-table-index").DataTable({
        processing: true,
        serverSide: true,
        "bPaginate": false,
        "bInfo": false,
        "dom": "<fl<t>ip>",
        ajax: "/index/list-folder/" + filesId,
        columns: [{
            data: "name",
            "fnCreatedCell": function (nTd, sData, oData) {
                $(nTd).html("<i class='fa fa-folder fa-lg'></i><span>&nbsp; " + sData +
                    "</span> <span class='pull-right'>" +
                    "<small class='label bg-yellow'>" + oData.child_count + "</small></span>"
                );
            }
        }],

        "fnDrawCallback": function () {
            var api = this.api();
            var json = api.ajax.json();

            rootFolderId = json.rootFolderId;
            rootFolderName = json.rootFolderName;
            $(api.column(0).header()).html($.fn.dataTable.render.text().display(json.rootFolderName));
        }
    });

    function getCurrentMainFolderDetail(id) {
        dtMain.ajax.url("/index/list-all/" + id).load();
        dtFolder.ajax.url("/index/list-folder/" + id).load();
    }

    function getCurrentFolderDetail(id) {
        dtMain.ajax.url("/index/list-all/" + id).load();
        dtFolder.ajax.url("/index/list-folder/" + id).load();
        filesId = id;
    }

    function goPreviousMainFolder() {
        if (rootFolderId > 0) {
            dtMain.ajax.url("/index/list-all-previous/" + rootFolderId).load();
            dtFolder.ajax.url("/index/list-folder-previous/" + rootFolderId).load();
        }
    }

    $('#file-descr-id').val('');

    var myDropzone = new Dropzone('#upload-file-form', {
        paramName: "file",
        url: '/index/upload-files',
        method: 'POST',
        maxFilesize: 25,
        maxFiles: 4,
        parallelUploads: 4,
        uploadMultiple: true,
        autoProcessQueue: false,
        //acceptedFiles: '.txt, .doc, .docx, .xls, .xlsx, .png, .jpeg, .jpg, .bmp, .pdf',
        addRemoveLinks: true,
        dictFileTooBig: 'Max file size is 25MB',
        dictMaxFilesExceeded: 'Max files uploaded is 4',
        success: function () {
            getCurrentMainFolderDetail(filesId);
        }
    });

    $("#dt-file-exp-table-index tbody").on("change", "input[type='checkbox']", function () {
        // If checkbox is not checked
        if (!this.checked) {
            var el = $("#file-exp-select-all").get(0);
            if (el && el.checked && ("indeterminate" in el)) {
                el.indeterminate = true;
            }
        }
    });

    function setFilesProperties(data,status){
        if (status === true) {
            $('#file-descr-id').val(data.id);
            $('.file-descr-name').html(
                '<i class="fa fa-usb fa-fw"></i> ' + data.name +
                '<span class="pull-right">' +
                '   <i class="fa fa-angle-double-right"></i>' +
                '</span>'
            );
            $('#file-descr-text').text(data.description);
        } else {
            $('#file-descr-id').val('');
            $('.file-descr-name').html(
                '<i class="fa fa-usb fa-fw"></i> ' +
                '<span class="pull-right">' +
                '   <i class="fa fa-angle-double-right"></i>' +
                '</span>'
            );
            $('#file-descr-text').text('');
        }
    }

    $('#dt-file-exp-table-index tbody').on('click', 'tr', function () {
        var data = dtMain.row(this).data();

        if ($(this).hasClass('is-selected')) {
            $(this).removeClass('is-selected');
            setFilesProperties(data, false);
        } else {
            dtMain.$('tr.is-selected').removeClass('is-selected');
            $(this).addClass('is-selected');
            setFilesProperties(data, true);
        }
    });

    $("#file-exp-select-all").on("click", function () {
        var rows = dtMain.rows({"search": "applied"}).nodes();
        $('input[type="checkbox"]', rows).prop("checked", this.checked);
    });

    dtMain.on("dblclick", "tr", function () {
        var rootId = dtMain.row(this).data().id;
        if (dtMain.row(this).data().is_file === 0) {
            getCurrentMainFolderDetail(rootId);
        } else {
            window.location.href = '/index/detail/' + rootId;
        }
    });

    dtFolder.on("dblclick", "tr", function () {
        if (dtFolder.row(this).index() >= 0) {
            var currentId = dtFolder.row(this).data().id;
            getCurrentFolderDetail(currentId);
        }
    });

    $("#main-back").click(function () {
        goPreviousMainFolder();
    });

    $("#root-folder-name").click(function () {
        goPreviousMainFolder();
    });

    $('#create-new-folder-form').submit(function (e) {
        e.preventDefault();
        var formData = $('#create-new-folder-form').serialize();
        $('#folder-name-error').html("");

        $.ajax({
            url: '/index/create-new-folder/' + rootFolderId,
            type: 'POST',
            data: formData,
            success: function (data) {
                if (data.errors) {
                    if (data.errors.folderName) {
                        $('#folder-name-error').text(data.errors.folderName[0]);
                    }
                } else if (data.success) {
                    $('#success-msg').removeClass('hide');
                    getCurrentFolderDetail(rootFolderId);
                    closeModalInterval = setInterval(function () {
                        $('#create-new-folder-modal').modal('hide');
                    }, 1000);
                }
            }
        });
    });

    $('#create-new-folder-modal').on('shown.bs.modal', function () {
        $('#folderName').focus();
    });

    $('#create-new-folder-modal').on('hidden.bs.modal', function () {
        $('#folderName').val("");
        $('#success-msg').addClass('hide');
        $('#folder-name-error').html("");
        clearInterval(closeModalInterval);
    });

    $('#btn-save-comment').on('click', function () {
        var formData = $('#comments-form').serialize();
        var fileId = $('#fileCommentId').val();

        $.ajax({
            url: '/index/update-file/' + fileId,
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#comment-modals').modal('hide');
                dtMain.ajax.url("/index/list-all/" + response.data.folder_root).load();
                if (response.tipe === 'description'){
                    $('#file-descr-text').text(response.data.description);
                    setFilesProperties(response.data, true);
                } else {
                    setFilesProperties(null, false);
                }

                swal({
                    title: 'Success!',
                    text: response.message,
                    type: 'success',
                    timer: '1500'
                });
            },
            error: function () {
                swal({
                    title: 'Error!',
                    text: "Something went wrong",
                    type: 'error',
                    timer: '1500'
                });
            }
        });
    });

    $('#btn-upload-files').on('click', function () {
        myDropzone.processQueue();
    });

    myDropzone.on("sending", function (file, xhr, formData) {
        // formData.append("filesize", file.size);
        formData.append("folderId", filesId);
        console.log(file.type);
    });

    myDropzone.on("complete", function (file) {
        myDropzone.removeFile(file);
    });

    $('#edit-file-descr').on('click', function (e) {
        e.preventDefault();
        let id = $('#file-descr-id').val();

        if (id === ''){
            swal("Warning!!!",
                'No files/folder selected',
                'warning');
            return;
        }

        $.ajax({
            url: "/index/get-file/" + id,
            type: "GET",
            success: function (data) {
                $('#comment-modals').modal('show');
                if (data.is_file === 0) {
                    $('#modal-caption').html('<i class="fa fa-folder"></i><span> Add/Update Description</span>');
                    $('#file-name-modal').text('Folder Name: ' + data.name);
                } else {
                    $('#modal-caption').html('<i class="fa fa-file"></i><span> Add/Update Description</span>');
                    $('#file-name-modal').text('File Name: ' + data.name);
                }

                $('#label-file-comments').text('Description: ');
                $('#comment-modals .file-comment').val(data.description ? data.description : "");
                $('#fileCommentId').val(data.id);
                $('#fieldName').val('description');
            },
            error: function (response) {
                console.log(response);
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
                            getCurrentMainFolderDetail(filesId);
                            setFilesProperties(null, false);
                            Swal({
                                title: 'Success!',
                                text: response.message,
                                type: 'success',
                                timer: '2000'
                            });
                        }
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
});