
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Process List</a></li>
        <li><a href="#tab_2" data-toggle="tab">Result</a></li>
        <li><a href="#tab_3" data-toggle="tab">Finish</a></li>
        <li><a href="#tab_4" data-toggle="tab">Members</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">  
          <div class="table-responsive">
            @if($surveys->first())     
            <table id="table_edm" class="table table-hover table-condensed" data-toggle="table" data-click-to-select="true">
              <thead>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Analyze</th>
                  <th>More</th>
              </thead>
              <tbody>
                  @foreach($surveys as $survey)
                      <tr>
                        <td>
                          <div>
                              <p>
                                {{$survey->process}}
                              </p>
                          </div>
                        </td>
                        <td>
                        @if((explode('-',$survey->status))[0] >= 4)
                          <span class="status_survey text-green" data-toggle="tooltip" data-placement="bottom" title="Proses sudah diisi oleh Assessor">{{ $survey->type }}</span>
                        @else
                          <span class="status_survey" data-toggle="tooltip" data-placement="bottom" title="Proses belum diisi oleh Assessor">{{ $survey->type }}</span>
                        @endif
                        </td>
                        <td class="text-center">
                        @if((explode('-',$survey->status))[0] >= 4)
                          <a href="{{route('survey.analyze',['id'=> $survey_id,'inputans'=> $survey_id.'-'.$survey->process ])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="Proses bisa dianalisa, sudah diisi oleh Assessor"><i class="fa fa-bar-chart"></i></a>
                        @else
                          <a class="btn btn-default btn-sm adisabled" data-toggle="tooltip" data-placement="bottom" title="Proses tidak bisa dianalisa, harus diisi oleh Assessor terlebih dahulu"><i class="fa fa-bar-chart"></i></a>
                        @endif
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            <!-- <a class="btn btn-danger btn-sm"><i class="fa fa-trash fa-fw"></i></a> -->
                            <a class="o_m_e_process btn btn-info btn-sm" data-process="{{ $survey->process }}" data-targetlevel="{{ $survey->target_level }}" data-toggle="tooltip" data-placement="bottom" title="Edit Target Level"><i class="fa fa-edit"></i></a>
                          </div>
                        </td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
            @else     
            <table class="table table-hover table-condensed" data-toggle="table" data-click-to-select="true">
              <thead>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Analyze</th>
                  <th>More</th>
              </thead>
              <tbody>
                <tr>
                  <td colspan="4" class="text-center">No Pending Process Available</td>
                </tr>
              </tbody>
            </table>
            @endif
          </div>
        </div>
        <div class="tab-pane" id="tab_2">
          @include('survey.survey-aggregation')
        </div>
        <div class="tab-pane" id="tab_3">  
          <div class="table-responsive">
            @if($surveys_done->first())  
            <table id="table_done" class="table table-hover table-condensed" data-toggle="table" data-click-to-select="true">
              <thead>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Analyze</th>
                  <th>More</th>
              </thead>
              <tbody>
                  @foreach($surveys_done as $survey)
                    <tr>
                      <td>
                        <div>
                            <p>
                              {{$survey->process}}
                            </p>
                        </div>
                      </td>
                      <td>
                        <span class="status_survey text-green" data-toggle="tooltip" data-placement="bottom" title="Proses sudah selesai dianalisa">{{ $survey->type }}</span>
                      </td>
                      <td class="text-center">
                        <a href="{{route('survey.analyze.doneView',['id'=>$survey_id,'inputans'=> $survey_id.'-'.$survey->process ])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="Proses sudah selesai dianalisa"><i class="fa fa-bar-chart"></i></a>
                      </td>
                      <td class="text-center">
                        <div class="btn-group">
                          <a class="btn btn-danger btn-sm"><i class="fa fa-trash fa-fw"></i></a>
                          <a class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                        </div>
                      </td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
            @else     
            <table class="table table-hover table-condensed" data-toggle="table" data-click-to-select="true">
              <thead>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Analyze</th>
                  <th>More</th>
              </thead>
              <tbody>
                <tr>
                  <td colspan="4" class="text-center">No Finished Process Available</td>
                </tr>
              </tbody>
            </table>
            @endif
          </div>
        </div>
        <div class="tab-pane" id="tab_4">  
          <div class="table-responsive">
            @if($survey_members[0])  
            <table id="table_members" class="table table-hover table-condensed" data-toggle="table" data-click-to-select="true">
              <thead>
                  <th>Username</th>
                  <th>Role</th>
                  <th>More</th>
              </thead>
              <tbody>
                  @foreach($survey_members as $survey_member)
                    <tr>
                      <td>
                        <p>
                          {{$survey_member->username}}
                        </p>
                      </td>
                      <td>
                        <span class="status_survey">{{ explode('-',$survey_member->role)[1] }}</span>
                      </td>
                      <td class="text-center">
                        @if(explode('-',$survey_member->role)[0] > 0)
                        <div class="btn-group">
                          <a data-url="{{route('survey.deleteMember',['id' => $survey_id, 'user_id' => $survey_member->user])}}" class="b_del_user btn btn-danger btn-sm"><i class="fa fa-trash fa-fw" data-toggle="tooltip" data-placement="bottom" title="Delete"></i></a>
                          <a data-username="{{$survey_member->username}}" data-id="{{$survey_member->user}}" data-role="{{$survey_member->role}}" class="o_m_e_members btn btn-info btn-sm"><i class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" title="Edit"></i></a>
                        </div>
                        @endif
                      </td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
            @else     
            <table class="table table-hover table-condensed" data-toggle="table" data-click-to-select="true">
              <thead>
                  <th>Username</th>
                  <th>Role</th>
                  <th>More</th>
              </thead>
              <tbody>
                <tr>
                  <td colspan="3" class="text-center">No Members Available</td>
                </tr>
              </tbody>
            </table>
            @endif
          </div>
        </div>
      </div>
    </div>

  <div class="modal fade" id="m_e_members">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;Edit User</h4>
        </div>
        <div class="modal-body">
          <form name="form_e_members" id="form_e_members" method="POST" action="{{route('survey.editMember',['id' => $survey_id])}}">
            @csrf
            <input type="hidden" name="user_id" id="user_id" style="color: #fff;">
            <div class="form-group">
              <label for="i_username" class="control-label">Username</label>
              <input id="i_username" name="i_username" type="text" class="form-control" readonly="true">
            </div>
            <div class="form-group">
              <label for="i_role" class="control-label">Role</label>
              <select id="i_role" name="i_role" class="form-control select2" data-placeholder="Edit Role" style="width: 100%;" >
                  <option value=""></option>
                  @foreach($survey_roles as $survey_role)
                  <option value="{{$survey_role->id}}">{{$survey_role->name}}</option>
                  @endforeach
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i></button>
          <button type="submit" form="form_e_members" class="btn btn-primary"><i class="fa fa-check"></i></button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <div class="modal fade" id="m_e_process">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;Edit Process</h4>
        </div>
        <div class="modal-body">
          <form name="form_e_process" id="form_e_process" method="POST" action="{{route('survey.editProcessLevel',['id' => $survey_id])}}">
            @csrf
            <div class="form-group">
              <label for="i_process" class="control-label">Process</label>
              <input id="i_process" name="i_process" type="text" class="form-control" readonly="true">
            </div>
            <div class="form-group">
              <label for="i_target_level" class="control-label">Target Level</label>
              <select id="i_target_level" name="i_target_level" class="form-control select2" data-placeholder="Edit Target Level" style="width: 100%;" >
                  <option value=""></option>
                  @foreach($levels as $level)
                  <option value="{{$level->level}}">{{$level->level}}</option>
                  @endforeach
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i></button>
          <button type="submit" form="form_e_process" class="btn btn-primary"><i class="fa fa-check"></i></button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>