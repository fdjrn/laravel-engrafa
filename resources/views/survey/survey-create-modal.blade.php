<div class="modal fade" id="modal-n-survey">
  <!-- <div> -->
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Create New Assessment</h4>
      </div>
      <div class="modal-body">
        <form name="form_n_survey" action="{{url('surveyrs')}}" method="post" id="form_n_survey" class="form-horizontal">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <div class="col-sm-12">
                  <div class='input-group'>
                    <input type="text" id="i_n_name_survey" name="i_n_name_survey" class="form-control" placeholder="New Assessment Name" >
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
                <label for="i_n_surveyor" class="col-sm-4 control-label">Invite Manager</label>

                <div class="col-sm-8">
                  <select id="i_n_surveyor" name="i_n_surveyor[]" class="form-control select2" multiple data-placeholder="Add Manager"
                          style="width: 100%;" >
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="i_n_client" class="col-sm-4 control-label">Invite Assessor</label>

                <div class="col-sm-8">
                  <select id="i_n_client" name="i_n_client[]" class="form-control select2" multiple data-placeholder="Add Assessor"
                          style="width: 100%;" >
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label for="i_n_survey_type" class="col-sm-2 control-label">Drivers</label>

                <div class="col-sm-2">
                  <input name="drivers_purpose" id="drivers_purpose" value="Purpose" style="vertical-align:middle" type="checkbox">&nbsp;Purpose
                  <br>
                  <input name="drivers_pain" id="drivers_pain" value="Pain Point" style="vertical-align:middle" type="checkbox">&nbsp;Pain Point
                  <!-- <select id="i_n_survey_type" name="i_n_survey_type" class="form-control select2" data-placeholder="Drivers"
                          style="width: 100%;" >
                    <option value=""></option>
                    <option value="1-Purpose">Purpose</option>
                    <option value="2-Pain">Pain Point</option>
                  </select> -->
                </div>
                <div class="col-sm-4">
                  <div class="box box-default" style="overflow-x:hidden; overflow-y: auto; max-height: 250px;">
                    <div class="box-header">
                      <a href="#" data-widget="collapse">
                        <h5 style="margin:2px 0px;">Purpose</h5>
                      </a>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body">
                      @foreach($dataItGoal as $datait)
                        @if($datait->pp == '1-Purpose')
                          <div class="list-itgoal-purpose">
                            <label style="display:block">
                              <input name="i_itgoal[]" class="c_itgoal" value="{{$datait->id}}" style="vertical-align:middle" type="checkbox" >
                              <span  style="vertical-align:middle; padding-top: 4px;">{{$datait->name}}</span>
                            </label>
                          </div>
                        @endif
                      @endforeach
                    </div>
                  </div>
                  <div class="box box-default" style="overflow-x:hidden; overflow-y: auto; max-height: 250px;">
                    <div class="box-header">
                      <a href="#" data-widget="collapse">
                        <h5 style="margin:2px 0px;">Pain Point</h5>
                      </a>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body">
                      @foreach($dataItGoal as $datait)
                        @if($datait->pp == '2-Pain')
                          <div class="list-itgoal-pain">
                            <label style="display:block">
                              <input name="i_itgoal[]" class="c_itgoal" value="{{$datait->id}}" style="vertical-align:middle" type="checkbox">
                              <span  style="vertical-align:middle; padding-top: 4px;">{{$datait->name}}</span>
                            </label>
                          </div>
                        @endif
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="box box-default" id="list-itgoal" style="overflow-x:hidden; overflow-y: auto; max-height: 520px;">
                    <div class="box-header">
                      <a href="#" data-widget="collapse">
                        <h5 style="margin:2px 0px;">Process List</h5>
                      </a>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body">
                      <p class="l_process_list text-center">Loading...</p>
                      <div id="d_process_list">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label for="i_n_expire" class="col-sm-2 control-label">Assessment Expiration</label>

                <div class="col-sm-4">
                  <div class='input-group date'>
                      <input name="i_n_expire" id='i_n_expire' type='text' class="form-control" />
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