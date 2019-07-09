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
            console.log(response.statusText);
        }
    })
}

function uploadNewVersion(id) {

    $.get({
        url: "/index/get-file/" + id,
        success: function (result) {
            $('#upload-files-new-version-modal').modal('show');
            $('#rootFileName').text(result.name);
            $('#fileRootId').val(result.id);
        },
        error: function (e) {
            console.log(e);
        }
    });
}

function seeFileHistory(id){
    var dtHistory = $("#file-history-table").DataTable();

    dtHistory.destroy();

    $.ajax({
        url: "/index/get-file/" + id,
        type: 'GET',
        success: function (result) {
            $('.bs-modal-file-history').modal('show');
            $('#modal-history-caption').text(result.name);
            $('#fileHistoryId').val(result.id);

            let fId = (result.file_root == 0) ? result.id : result.file_root;

            dtHistory = $("#file-history-table").DataTable({
                processing: true,
                serverSide: true,
                "searching": false,
                // "dom": "<fl<t>ip>",
                ajax: "/index/file-history/" + fId,
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

        },
        error: function (err) {
            console.log(err);
        }

    });
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

    var dzUploadFile = new Dropzone('#upload-file-form', {
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
        dictMaxFilesExceeded: 'Max files uploaded is 4'
    });

    dzUploadFile.on("sending", function (file, xhr, formData) {
        formData.append("folderId", filesId);
    });

    dzUploadFile.on("complete", function (file, xhr) {
        //console.log(file,xhr);
        if (file.status === "error") {
            swal({
                title: 'Error!',
                text: "Upload Files failed, please try again or refresh page ",
                type: 'error',
                timer: '2000'
            });
        } else {
            swal({
                title: 'Success!',
                text: "File uploaded",
                type: 'success',
                timer: '1500'
            });
            getCurrentMainFolderDetail(filesId);
        }
        dzUploadFile.removeFile(file);
    });

    dzUploadFile.on("canceled", function (file) {
        dzUploadFile.removeFile(file);
    });

    $('#btn-upload-files').on('click', function () {
        dzUploadFile.processQueue();
    });

    var dzUploadNewFile = new Dropzone('#upload-file-new-form', {
        paramName: "new-file-version",
        url: '/index/upload-new-version',
        method: 'POST',
        maxFilesize: 25,
        maxFiles: 1,
        parallelUploads: 1,
        uploadMultiple: true,
        autoProcessQueue: false,
        //acceptedFiles: '.txt, .doc, .docx, .xls, .xlsx, .png, .jpeg, .jpg, .bmp, .pdf',
        addRemoveLinks: true,
        dictFileTooBig: 'Max file size is 25MB',
        dictMaxFilesExceeded: 'Only 1 files allowed upload'
        /*success: function () {
            getCurrentMainFolderDetail(filesId);
        }*/
    });

    $('#upload-files-new-version-modal').on('show', function () {
        let rootFileName = $('#file-descr-name').text();
        $('#rootFileName').text(rootFileName);
    });


    dzUploadNewFile.on("sending", function (file, xhr, formData) {
        formData.append("fileroot", $('input:hidden[name="fileRootId"]').val());
        formData.append("folderId", filesId);
    });

    dzUploadNewFile.on("canceled", function (file) {
        dzUploadNewFile.removeFile(file);
    });

    dzUploadNewFile.on("complete", function (file, xhr) {
        if (file.status === "error") {
            swal({
                title: 'Error!',
                text: "Failed to upload new version, please try again or refresh page ",
                type: 'error',
                timer: '1500'
            });
        } else {
            swal({
                title: 'Success!',
                text: "New file version uploaded",
                type: 'success',
                timer: '2000'
            });
            getCurrentMainFolderDetail(filesId);
        }
        dzUploadNewFile.removeFile(file);
    });

    $('#btn-upload-new-files').on('click', function () {
        dzUploadNewFile.processQueue();
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
                '<i class="fa fa-usb fa-fw"></i> ' + data.name
            );
            $('#file-descr-text').text(data.description);
        } else {
            $('#file-descr-id').val('');
            $('.file-descr-name').html(
                '<i class="fa fa-usb fa-fw"></i> '
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
                    $("#btn-create-folder").attr("disabled", true);
                    getCurrentFolderDetail(rootFolderId);
                    /*closeModalInterval = setInterval(function () {
                        $('#create-new-folder-modal').modal('hide');
                    }, 1000);*/
                }
            }
        });
    });

    /*$('#create-new-folder-modal').on('shown.bs.modal', function () {
        $('#folderName').focus();
    });*/

    $('#create-new-folder-modal').on('hidden.bs.modal', function () {
        $('#folderName').val("");
        $('#success-msg').addClass('hide');
        $('#folder-name-error').html("");
        $("#btn-create-folder").removeAttr("disabled")
        /*clearInterval(closeModalInterval);*/
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

                if(response.is_error != true) {
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
                } else {
                    setFilesProperties(null, false);

                    swal({
                        title: 'Error!',
                        text: "Something went wrong, " + response.message,
                        type: 'error',
                        timer: '1500'
                    });
                }
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

    $('#view-file').on('click', function (e) {
        e.preventDefault();
        let id = $('#file-descr-id').val();

        if (id === ''){
            swal("Warning!!!",
                'No files/folder selected',
                'warning');
            return;
        };

        $.ajax({
            url: "/index/get-file/" + id,
            type: "GET",
            success: function (data) {

                if (data.is_file === 1) {
                    $('.bs-modal-view-file').modal('show');
                    $('#modal-view-caption').html('<i class="fa fa-file"></i><span> &nbsp;' + data.name +'</span>');
                    $('#iframe-view-file').attr('visibility','visible');
                    $('#iframe-view-file').attr('src', base_url  +"/storage/index/"+ data.url);
                }
            },
            error: function (response) {
                if (response.status === '401')
                    window.location.href = '/login';
            }
        })
    });

    $('.bs-modal-view-file').on('hidden.bs.modal', function (e) {
        $('#iframe-view-file').attr('src','');
    });

    $('.collapse-prop').on("click", function (e) {
        $(this).closest('.file-prop').fadeOut('slide',function(){
            $('.mini-submenu').fadeIn();
            $('.main-view').removeClass('col-md-6').addClass('col-md-9');
            $('#file-properties').removeClass('col-md-3');
            $('.main-view').css("padding-right","60px");
            /*$('#file-properties').css("padding-right","60px");*/

        });
    });

    $('.mini-submenu').on('click',function(){
        $('.file-prop').fadeIn();
        $('.mini-submenu').hide();
        $('#file-properties').addClass('col-md-3');
        $('.main-view').css("padding-right","0px");
        $('.main-view').removeClass('col-md-9').addClass('col-md-6');

    })

    $('.stretch-main-view').on('click', function (e) {
        // e.preventDefault();

        $('.file-prop').fadeOut('slide',function(){
            $('.mini-submenu').fadeIn();
            $('.main-view').removeClass('col-md-6').addClass('col-md-9');
            $('#file-properties').removeClass('col-md-3');
            $('.main-view').css("padding-right","60px");

        });

    })

});