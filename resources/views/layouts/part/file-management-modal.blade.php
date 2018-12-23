<!--
 Created by PhpStorm.
 User: fadjrin
 Date: 05/12/18
 Time: 15:41
-->

<!-- Create Folder Bootsrap Modal -->
<div class="modal eng-modal fade" id="create-new-folder-modal" tabindex="-1" role="dialog"
     aria-labelledby="createFolderModalLabel">
    <div class="modal-dialog eng-modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close pull-right fa fa-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&nbsp;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-folder"></i><span> Create New Folder</span></h4>
            </div>
            {{ Form::open(['id'=>'create-new-folder-form']) }}
            @csrf
            <div class="modal-body">
                <div id="success-msg" class="hide">
                    <div class="alert alert-info alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>Success!</strong> Folder has been created.
                    </div>
                </div>
                <div class="form-group has-feedback">
                    {!! Form::label('label-new-folder-name','New Folder Name: ',['class'=>'control-label', 'for'=>'folderName']) !!}
                    <input type="text" class="form-control" id="folderName" name="folderName">
                    <span class="text-danger">
                            <strong id="folder-name-error"></strong>
                        </span>
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::button('Close', ['class' => 'btn btn-default','data-dismiss'=>'modal']) !!}
                {!! Form::button('Create', ['class' => 'btn btn-info','id'=>'btn-create-folder']) !!}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<!-- Upload files Bootsrap Modal -->
<div class="modal eng-modal fade" id="upload-files-modal" tabindex="-1" role="dialog"
     aria-labelledby="uploadFilesModalLabel">
    <div class="modal-dialog eng-modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close pull-right fa fa-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&nbsp;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-file"></i><span> Upload Files</span></h4>
            </div>
            <div class="modal-body">
                <div class="form-group has-feedback">
                    <form class="dropzone upload-file-form" id="upload-file-form" method="POST" enctype="multipart/form-data" action="">
                        @csrf
                        <div class="fallback">
                            <input type="file" name="file"/>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::button('Close', ['class' => 'btn btn-default','data-dismiss'=>'modal', 'id'=>'btn-close-modal']) !!}
                {!! Form::submit('Upload', ['class' => 'btn btn-info','id'=>'btn-upload-files']) !!}
            </div>
        </div>
    </div>
</div>

<!-- File Comment/Description Modal -->
<div class="modal eng-modal fade" id="comment-modals" tabindex="-1" role="dialog" aria-labelledby="createFolderModalLabel">
    <div class="modal-dialog eng-modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close pull-right fa fa-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&nbsp;</span>
                </button>
                <h4 id="modal-caption" class="modal-title"></h4>
            </div>
            {{ Form::open(['id'=>'comments-form','method' => 'POST']) }}
            @csrf
            <div class="modal-body">
                <input type="hidden" id="fileCommentId" name="fileCommentId">
                <input type="hidden" id="fieldName" name="fieldName">
                {!! Form::label('file-name-modal','',['class'=>'control-label', 'id'=>'file-name-modal']) !!}
                <hr/>
                <div class="form-group has-feedback">
                    {!! Form::label('label-file-comments','Comments: ',['class'=>'control-label', 'for'=>'filecomment', 'id'=>'label-file-comments']) !!}
                    <textarea id="filecomment" name="filecomment" class="file-comment" style="width: -moz-available; font-weight: normal;" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::button('Close', ['class' => 'btn btn-default','data-dismiss'=>'modal']) !!}
                {!! Form::button('Save', ['class' => 'btn btn-info','id'=>'btn-save-comment']) !!}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>