<div class="modal fade" id="modal-n-survey">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Create New Survey</h4>
      </div>
      <div class="modal-body">
        <form name="form_n_survey" action="{{url('surveyrs')}}" method="post" id="form_n_survey" class="form-horizontal">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <div class="col-sm-12">
                  <div class='input-group'>
                    <input type="text" id="i_n_name_survey" name="i_n_name_survey" class="form-control" placeholder="New Survey Name">
                      <span class="input-group-addon">
                        <select class="colorselector">
                          <option value="A0522D" data-color="#A0522D">sienna</option>
                          <option value="CD5C5C" data-color="#CD5C5C" selected="selected">indianred</option>
                          <option value="FF4500" data-color="#FF4500">orangered</option>
                          ...
                          <option value="DC143C" data-color="#DC143C">crimson</option>
                          <option value="FF8C00" data-color="#FF8C00">darkorange</option>
                          <option value="C71585" data-color="#C71585">mediumvioletred</option>
                        </select>
                      </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="i_n_surveyor" class="col-sm-4 control-label">Invite Surveyor</label>

                <div class="col-sm-8">
                  <select id="i_n_surveyor" name="i_n_surveyor[]" class="form-control select2" multiple="multiple" data-placeholder="Add Surveyor"
                          style="width: 100%;">
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="i_n_client" class="col-sm-4 control-label">Invite Client</label>

                <div class="col-sm-8">
                  <select id="i_n_client" name="i_n_client[]" class="form-control select2" multiple="multiple" data-placeholder="Add Client"
                          style="width: 100%;">
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label for="i_n_expire" class="col-sm-2 control-label">Survey Expiration</label>

                <div class="col-sm-4">
                  <div class='input-group date' id='i_n_expire'>
                      <input name="i_n_expire" type='text' class="form-control" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i></button>
        <button type="submit" form="form_n_survey" class="btn btn-primary"><i class="fa fa-check"></i></button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>