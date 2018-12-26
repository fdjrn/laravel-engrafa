
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">List EDM</a></li>
        <li><a href="#tab_2" data-toggle="tab">Aggregation</a></li>
        <li><a href="#tab_3" data-toggle="tab">Done</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">  
          <div class="table-responsive">     
            <table id="table_edm" class="table table-hover table-condensed" data-toggle="table" data-click-to-select="true">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Type</th>
                  <!-- <th>Date Modified</th> -->
                  <th>Analyze</th>
                  <th>More</th>
                </tr>
              </thead>
              <tbody>
                @if($surveys->first())
                  @foreach($surveys as $survey)
                      <tr>
                        <td>
                          <div>
                              <p>
                                {{$survey->process}}
                              </p>
                          </div>
                        </td>
                        <!-- <td>@{{@$survey->updated_at}}</td> -->
                        <td>
                        @if((explode('-',$survey->status))[0] >= 4)
                          <span class="status_survey text-green" title="Survey has been done">{{ explode("-",$survey->PP)[1] }}</span>
                        @else
                          <span class="status_survey" title="Survey hasn't been done">{{ explode("-",$survey->PP)[1] }}</span>
                        @endif
                        </td>
                        <td class="text-center">
                        @if((explode('-',$survey->status))[0] >= 4)
                          <a href="{{route('survey.analyze',['id'=> $survey_id,'inputans'=> $survey_id.'-'.$survey->it_related_goal.'-'.$survey->process ])}}" class="btn btn-success btn-sm" title="Survey can be analyzed"><i class="fa fa-bar-chart"></i></a>
                        @else
                          <a class="btn btn-default btn-sm adisabled" title="Survey can't be analyzed"><i class="fa fa-bar-chart"></i></a>
                        @endif
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            <a class="btn btn-danger btn-sm"><i class="fa fa-trash fa-fw"></i></a>
                            <a class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                          </div>
                        </td>
                      </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="4" class="text-center">No Survey Available</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane" id="tab_2">
          @include('survey.survey-aggregation')
        </div>
        <div class="tab-pane" id="tab_3">  
          <div class="table-responsive">  
            <table id="table_done" class="table table-hover table-condensed" data-toggle="table" data-click-to-select="true">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Type</th>
                  <!-- <th>Date Modified</th> -->
                  <th>Analyze</th>
                  <th>More</th>
                </tr>
              </thead>
              <tbody>
                @if($surveys_done->first())
                  @foreach($surveys_done as $survey)
                    <tr>
                      <td>
                        <div>
                            <p>
                              {{$survey->process}}
                            </p>
                        </div>
                      </td>
                      <!-- <td>@{{@$survey->updated_at}}</td> -->
                      <td>
                        <span class="status_survey text-green" title="Survey has been analyzed">{{ explode("-",$survey->PP)[1] }}</span>
                      </td>
                      <td class="text-center">
                        <a href="{{route('survey.analyze.doneView',['id'=>$survey_id,'inputans'=> $survey_id.'-'.$survey->it_related_goal.'-'.$survey->process ])}}" class="btn btn-success btn-sm" title="Survey has been analyzed"><i class="fa fa-bar-chart"></i></a>
                      </td>
                      <td class="text-center">
                        <div class="btn-group">
                          <a class="btn btn-danger btn-sm"><i class="fa fa-trash fa-fw"></i></a>
                          <a class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="4" class="text-center">No Done Analyzed Survey Available</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>