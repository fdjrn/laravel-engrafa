Dropzone.autoDiscover = false;

function bookmarkFile(id) {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "/index/bookmark-file/" + id ,
        type: "POST",
        data : {'_token' : csrf_token},
        success: function(response) {
            swal({
                title: 'Bookmark Success!',
                text: response.data.name + ", " + response.message,
                type: 'success',
                timer: '2000'
            })
        },
        error : function(data) {
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
        type:"GET",
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
    var currentFolderId = 0;
    var closeModalInterval;
    var f_id = $('input:hidden[name = f_id]').val();

    var dtMain = $("#dt-file-exp-table-index").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/index/list-all/" + f_id,
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
                    if (sData !== null){
                        $(nTd).html("<a class='btn btn-outline-warning btn-xs' onclick='setComment(" + oData.id +")'>" +
                            "<span><i class='fa fa-comment fa-2x'></i></span></a> " + sData);

                    } else {
                        $(nTd).html("<a class='btn btn-outline-warning btn-xs' onclick='setComment(" + oData.id +")'>" +
                            "<span><i class='fa fa-comment fa-2x'></i></span></a> ");
                    }
                }
            },
            { data: "action", name: "action", orderable: false, searchable: false}
        ],
        columnDefs: [{
            targets: [0, 1, 2, 3, 4, 5],
            className: "mdl-data-table__cell--non-numeric"
        }],
        "fnDrawCallback": function () {
            var api = this.api();
            var json = api.ajax.json();
            rootFolderId = json.mainRootFolderId;
            rootFolderName = json.mainRootFolderName;
            $("#root-folder-name").text(rootFolderName);
        }
    });

    var dtFolder = $("#dt-list-folder-table-index").DataTable({
        processing: true,
        serverSide: true,
        "bPaginate": false,
        "bInfo": false,
        "dom": "<fl<t>ip>",
        ajax: "/index/list-folder/" + f_id,
        columns: [{
            data: "name",
            "fnCreatedCell": function (nTd, sData, oData) {
                $(nTd).html("<i class='fa fa-folder fa-lg'></i><span>&nbsp; " + sData +
                    "</span> <span class='pull-right'>" +
                    "<small class='label bg-yellow'>"+ oData.child_count +"</small></span>"
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
        currentFolderId = id;
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
            getCurrentMainFolderDetail(currentFolderId);
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

    $('#dt-file-exp-table-index tbody').on('click', 'tr', function () {
        var data = dtMain.row( this ).data();

        if ($(this).hasClass('is-selected')) {
            $(this).removeClass('is-selected');
        } else {
            dtMain.$('tr.is-selected').removeClass('is-selected');
            $(this).addClass('is-selected');
        }

        $('#file-descr-id').val(data.id);
        $('.file-descr-name').html(
            '<i class="fa fa-usb fa-fw"></i> '+ data.name +
            '<span class="pull-right">' +
            '   <i class="fa fa-angle-double-right"></i>' +
            '</span>'
        );
        $('#file-descr-text').text(data.description);
    });

    $("#file-exp-select-all").on("click", function () {
        var rows = dtMain.rows({"search": "applied"}).nodes();
        $('input[type="checkbox"]', rows).prop("checked", this.checked);
    });

    dtMain.on("dblclick", "tr", function () {
        var rootId = dtMain.row(this).data().id;
        if (dtMain.row(this).data().is_file === 0) {
            getCurrentMainFolderDetail(rootId);
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
        $('#btn-create-folder').click();
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

    $('#btn-create-folder').on('click', function () {
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
                $('#file-descr-text').text(response.data.description);
                //dtMain.$('tr.is-selected').removeClass('is-selected');

                swal({
                    title: 'Success!',
                    text: response.message,
                    type: 'success',
                    timer: '1500'
                });
            },
            error: function (response) {
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

    $('#upload-file-form').submit(function (e) {
        e.preventDefault();
        $('#btnUpload').click();
    });

    myDropzone.on("sending", function (file, xhr, formData) {
        // Will send the filesize along with the file as POST data.
        formData.append("filesize", file.size);
        formData.append("folderId", currentFolderId);
    });

    myDropzone.on("complete", function (file) {
        myDropzone.removeFile(file);
    });

    $('#upload-file-form').on('hidden.bs.modal', function () {
        myDropzone.complete();
        getCurrentMainFolderDetail(rootFolderId);
    });

    $('#edit-file-descr').on('click',function (e) {
        let fId = $('#file-descr-id').val();
        e.preventDefault();
        $.ajax({
            url: "/index/get-file/" + fId,
            type:"GET",
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
    })
});