<div {!! isset($modal_dialog_id) ? 'id="' . $modal_dialog_id . '"' : 'id="main_form_confirmation_dialog"' !!} class="confirmation-modal-dialog modal modal-bootstrap container fade" data-backdrop="static" data-keyboard="false">

    <div class="modal-content">
        <!-- BEGIN MODAL DIALOG HEADER -->
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">{{ isset($modal_dialog_title) ? $modal_dialog_title : 'Are you sure?' }}
                {!! isset($modal_dialog_subtitle) ? ('<span id="modal_sub_title">'. $modal_dialog_subtitle . '</span>') : '' !!}
            </h4>
        </div>
        <!-- BEGIN MODAL DIALOG HEADER -->

        <!-- BEGIN MODAL DIALOG BODY CONTENT -->
        <div class="modal-body"></div>
        <!-- END MODAL DIALOG BODY CONTENT -->

        <!-- BEGIN MODAL DIALOG FOOTER -->
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="no-btn btn btn-outline">No</button>
            <button type="button" data-dismiss="modal" class="yes-btn btn green">Yes</button>
        </div>
        <!-- BEGIN MODAL DIALOG FOOTER -->
    </div>
</div>
