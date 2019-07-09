
    <div id="{{ isset($id) ? $id : 'ctiExceptionDialog' }}" class="modal fade container cti-exception-dialog">

        <!-- BEGIN MODAL DIALOG HEADER -->
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">{{ isset($title) ? $title : 'Exception Details' }}
                {!! isset($subtitle) ? ('<span id="modal_sub_title">'. $subtitle . '</span>') : '' !!}
            </h4>
        </div>
        <!-- BEGIN MODAL DIALOG HEADER -->

        <!-- BEGIN MODAL DIALOG BODY CONTENT -->
        <div class="modal-body">
        </div>
        <!-- END MODAL DIALOG BODY CONTENT -->

        <!-- BEGIN MODAL DIALOG FOOTER -->
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
        </div>
        <!-- BEGIN MODAL DIALOG FOOTER -->

    </div>
