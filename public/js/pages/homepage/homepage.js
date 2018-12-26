Dropzone.autoDiscover = false;
$(document).ready(function () {
    var closeModalInterval;

    var dtList = $("#recentListTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/homepage/list-all",
            error: function (xhr, status, err) {
                if (err === 'Unauthorized') {
                    window.location.href = '/login';
                }
            }
        },
        order: [[2,"desc"]],
        columns: [
            {
                data: "name",
                "fnCreatedCell": function (nTd, sData, oData) {
                    if (oData.is_file === '1'){
                        $(nTd).html("<span><i class='fa fa-file fa-lg'></i></span>&nbsp; " + sData);
                    } else {
                        $(nTd).html("<span><i class='fa fa-folder fa-lg'></i></span>&nbsp; " + sData );
                    }
                }
            },
            {data: "owner"},
            {data: "updated_at"},
            {data: "size"}
        ],
        columnDefs: [{
                targets: [0, 1, 2 ],
                className: "mdl-data-table__cell--non-numeric"
        }]
    });

    var homePageDropzone = new Dropzone('.upload-file-form', {
        paramName: "file",
        url: '/homepage/upload-files',
        method: 'POST',
        maxFilesize: 25,
        maxFiles: 4,
        parallelUploads: 4,
        uploadMultiple: true,
        autoProcessQueue: false,
        // acceptedFiles: '.txt, .doc, .docx, .xls, .xlsx, .png, .jpeg, .jpg, .bmp, .pdf',
        addRemoveLinks: true,
        dictFileTooBig: 'Max file size is 25MB',
        dictMaxFilesExceeded: 'Max files uploaded is 4',
        success: function (file,response) {
            dtList.ajax.url("/homepage/list-all").load();
            $('.latest-file-name').html(response.result.name);
            $("input[name='file_id']").val(response.result.id);
        }
    });

    $('#create-new-folder-form').submit(function (e) {
        e.preventDefault();
        var formData = $('#create-new-folder-form').serialize();
        $('#folder-name-error').html("");

        $.ajax({
            url:'/homepage/create-new-folder',
            type:'POST',
            data: formData,
            success: function (data) {
                if(data.errors){
                    if (data.errors.folderName){
                        $('#folder-name-error').text(data.errors.folderName[0]);
                    }
                } else if (data.success) {
                    $('#success-msg').removeClass('hide');
                    dtList.ajax.url('/homepage/list-all').load();
                    $('.latest-folder-name').html(data.result.name);
                    $("input[name='folder_id']").val(data.result.id);
                }

                closeModalInterval = setInterval(function(){
                    $('#create-new-folder-modal').modal('hide');
                }, 1000);
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

    $('#btn-upload-files').on('click', function(){
        homePageDropzone.processQueue();
    });

    $('#upload-file-form').submit(function (e) {
        e.preventDefault();
        $('#btn-upload-files').click();
    });

    homePageDropzone.on("sending", function(file, xhr, formData) {
        formData.append("filesize", file.size);
    });

    homePageDropzone.on("complete", function(file) {
        homePageDropzone.removeFile(file);
    });

    $(".latest-folder-url").on("click", function (e) {
        $('#frm-last-folder').submit();
    })

    $(".latest-file-url").on("click", function (e) {
        e.preventDefault();
        let id = $("input[name='file_id']").val();
        if (id > 0)
            window.location.href = "/index/detail/" + id;
    })

    $(".latest-survey").on("click", function (e) {
        e.preventDefault();
        window.location.href = "/survey/" + $("input[name='survey_id']").val();
    })
});