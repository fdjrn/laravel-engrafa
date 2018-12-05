Dropzone.autoDiscover = false;
$(document).ready(function () {
    var rootFolderId = 0;
    var rootFolderName = "";
    var currentFolderId = 0;
    var closeModalInterval;

    var dtMain = $("#dt-file-exp-table-index").DataTable({
        processing: true,
        serverSide: true,
        ajax: "/index/list-all",
        columns: [
            {data: "checkbox", name: "file-exp-checkbox", orderable: false, searchable: false},
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
            {data: "updated_at"},
            {data: "owner"},
            {data: "comment"}
        ],
        columnDefs: [{
                targets: [0, 1, 2, 3, 4],
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
        "bPaginate":false,
        "bInfo":false,
        "dom": "<fl<t>ip>",
        ajax: "/index/list-folder",
        columns: [{
                data: "name",
                "fnCreatedCell": function (nTd, sData) {
                    $(nTd).html("<span><i class='fa fa-folder fa-lg'></i></span>&nbsp; " + sData);
                }}],
        "fnDrawCallback": function () {
            var api = this.api();
            var json = api.ajax.json();
            rootFolderId = json.rootFolderId;
            rootFolderName = json.rootFolderName;
            $(api.column(0).header()).html($.fn.dataTable.render.text().display(json.rootFolderName));
        }
    });

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
        success: function (file, response) {
            getCurrentMainFolderDetail(currentFolderId);
        }
    });


    $("#dt-file-exp-table-index tbody").on("change", "input[type='checkbox']", function(){
        // If checkbox is not checked
        if(!this.checked){
            var el = $("#file-exp-select-all").get(0);
            if(el && el.checked && ("indeterminate" in el)){
                el.indeterminate = true;
            }
        }
    });

    $("#file-exp-select-all").on("click", function(){
        var rows = dtMain.rows({ "search": "applied" }).nodes();
        $('input[type="checkbox"]', rows).prop("checked", this.checked);
    });

    function getCurrentMainFolderDetail(id) {
        dtMain.ajax.url("/index/list-all/"+id).load();
        dtFolder.ajax.url("/index/list-folder/"+id).load();
    }

    function getCurrentFolderDetail(id) {
        dtMain.ajax.url("/index/list-all/"+id).load();
        dtFolder.ajax.url("/index/list-folder/"+id).load();
        currentFolderId=id;
    }

    function goPreviousMainFolder(){
        if (rootFolderId > 0) {
            dtMain.ajax.url("/index/list-all-previous/"+ rootFolderId).load();
            dtFolder.ajax.url("/index/list-folder-previous/"+ rootFolderId).load();
        }
    }

    dtMain.on("click", "tr", function () {
        var rootId = dtMain.row( this ).data().id;
        if (dtMain.row( this ).data().is_file === 0) {
            getCurrentMainFolderDetail(rootId);
        }
    });

    dtFolder.on("click","tr", function () {
        if (dtFolder.row(this).index() >= 0) {
            var currentId = dtFolder.row(this).data().id;
            getCurrentFolderDetail(currentId);
        }
    });

    $("#main-back").click(function(){goPreviousMainFolder();});

    $("#root-folder-name").click(function(){goPreviousMainFolder();});

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
            url:'/index/create-new-folder/'+ rootFolderId,
            type:'POST',
            data: formData,
            success: function (data) {
                if(data.errors){
                    if (data.errors.folderName){
                        $('#folder-name-error').text(data.errors.folderName[0]);
                    }
                } else if (data.success) {
                    $('#success-msg').removeClass('hide');
                    getCurrentFolderDetail(rootFolderId);
                    closeModalInterval = setInterval(function(){
                        $('#create-new-folder-modal').modal('hide');
                    }, 1000);
                }
            }
        });
    });

    $('#btn-upload-files').on('click', function(){
        // console.log(rootFolderId);
        myDropzone.processQueue();
    });

    $('#upload-file-form').submit(function (e) {
        e.preventDefault();
        $('#btnUpload').click();
    });

    myDropzone.on("sending", function(file, xhr, formData) {
        // Will send the filesize along with the file as POST data.
        formData.append("filesize", file.size);
        formData.append("folderId", currentFolderId);
    });

    myDropzone.on("complete", function(file) {
        myDropzone.removeFile(file);
    });

    $('#upload-file-form').on('hidden.bs.modal', function () {
        myDropzone.complete();
        getCurrentMainFolderDetail(rootFolderId);
    });
});