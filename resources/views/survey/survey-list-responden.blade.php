
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Pending Survey</a></li>
        <li><a href="#tab_2" data-toggle="tab">Done</a></li>
        <!-- <li class="pull-right crud-button"><a href="#" id="b_create_new_team" class="text-success"><i class="fa fa-plus-circle"></i></a></li> -->
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="table-responsive">   
            <table id="table_edm" class="table table-bordered table-hover no-margin" data-toggle="table" data-click-to-select="true">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Start</th>
                </tr>
              </thead>
              <tbody>
                @if($surveys->first())
                  @foreach($surveys as $survey)
                    <tr>
                      <td>
                        <div>
                          <a href="{{route('survey.answer',['id'=>$survey_id, 'inputans'=> $survey_id.'-'.$survey->it_related_goal.'-'.$survey->process ])}}">
                            <p>
                              {{$survey->process}}
                            </p>
                          </a>
                        </div>
                      </td>
                      <td class="text-center">
                        @if($survey->status == '1-Waiting')
                          <a href="{{route('survey.answer',['id'=>$survey_id, 'inputans'=> $survey_id.'-'.$survey->it_related_goal.'-'.$survey->process ])}}" class="btn btn-info btn-sm" title="Waiting"><i class="fa fa-play fa-fw"></i></a>
                        @elseif($survey->status == '2-Process Survey')
                          <a href="{{route('survey.answer',['id'=>$survey_id, 'inputans'=> $survey_id.'-'.$survey->it_related_goal.'-'.$survey->process ])}}" class="btn btn-default btn-sm" title="Process"><i class="fa fa-ellipsis-h fa-fw"></i></a>
                        @elseif($survey->status == '3-On Save Survey')
                          <a href="{{route('survey.answer',['id'=>$survey_id, 'inputans'=> $survey_id.'-'.$survey->it_related_goal.'-'.$survey->process ])}}" class="btn btn-warning btn-sm" title="On Save"><i class="fa fa-pause fa-fw"></i></a>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="2" class="text-center">No Pending Survey Available</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane" id="tab_2">
          <div class="table-responsive">        
            <table id="table_done" class="table table-bordered table-hover" data-toggle="table" data-click-to-select="true">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Start</th>
                </tr>
              </thead>
              <tbody>
                @if($surveys_done->first())
                  @foreach($surveys_done as $survey)
                    <tr>
                      <td>
                        <div>
                          <a href="{{route('survey.answer.doneView',['id'=>$survey_id,'inputans'=> $survey_id.'-'.$survey->it_related_goal.'-'.$survey->process ])}}">
                            <p>
                              {{$survey->process}}
                            </p>
                          </a>
                        </div>
                      </td>
                      <td class="text-center">
                          <a href="{{route('survey.answer.doneView',['id'=>$survey_id,'inputans'=> $survey_id.'-'.$survey->it_related_goal.'-'.$survey->process ])}}" class="btn btn-success btn-sm" title="Done"><i class="fa fa-check fa-fw"></i></a>
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="2" class="text-center">No Done Survey Available</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>