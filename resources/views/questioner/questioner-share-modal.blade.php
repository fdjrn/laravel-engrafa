<div class="modal fade" id="modal-share-questioner">
  <!-- <div> -->
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Share Quisioner</h4>
      </div>
      <div class="modal-body">
        <!-- 
        <form name="form_c_qeustioner" action="{{url('quisioner/create')}}" method="post" id="form_c_qeustioner" class="form-horizontal"> 
        {{ csrf_field() }}
        -->
        <!-- <form name="form_c_qeustioner" id="form_c_qeustioner" class="form-horizontal"> -->

          
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label for="c_qeustioner_name" class="col-sm-4 control-label" style="text-align:left;">Quisioner Name</label>
                <div class="col-sm-8">
                  <input type="text" id="modal-qeustionername" name="modal-qeustionername" class="form-control" placeholder="New Quisioner Name">
                  <!-- <span class="error" id="error_name">This field is required</span> -->
                </div>
              </div>
            </div>
          </div>

          <div class="row" style="padding-top:10px;">
            <div class="col-lg-12">
              <div class="form-group">
                <label for="c_qeustioner_category" class="col-sm-4 control-label" style="text-align:left;">Share To</label>
                <div class="col-sm-8">
                  <select id="c_qeustioner_category" name="c_qeustioner_category" class="form-control select2" data-placeholder="Quisioner Category"
                          style="width: 100%;">
                    <option value=""></option>
                    <option value="1">Community</option>
                    <option value="2">Education</option>
                    <option value="3">Event</option>
                    <option value="4">Other</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          
          <!-- </div> -->
        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><!--<i class="fa fa-times"></i>--> Cancel</button>
        <button class="btn btn-primary" id="btn_save_share_quisioner"><!--<i class="fa fa-check"></i>-->Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
  $('#modal-share-questioner').on('shown.bs.modal', function(){
    var el = $('');
  });
</script>>