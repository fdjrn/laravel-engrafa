
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">List EDM</a></li>
        <li><a href="#tab_2" data-toggle="tab">Aggregation</a></li>
        <li><a href="#tab_3" data-toggle="tab">Done</a></li>
        <!-- <li class="pull-right crud-button"><a href="#" id="b_create_new_team" class="text-success"><i class="fa fa-plus-circle"></i></a></li> -->
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <!-- search form -->
          <form action="#" method="get">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>          
          <table id="table1" class="table table-bordered table-hover" data-toggle="table" data-click-to-select="true">
            <thead>
              <tr>
                <th data-field="state" data-checkbox="true" data-formatter="stateFormatter">
                  <input type="checkbox">
                </th>
                <th>Name</th>
                <th>Type</th>
                <!-- <th>Date Modified</th> -->
                <th>Analyze</th>
                <th>More</th>
              </tr>
            </thead>
            <tbody>
              @foreach($surveys as $survey)
                <tr>
                  <td><input type="checkbox"></td>
                  <td>
                    <div>
                        <p>
                          {{$survey->process}}
                        </p>
                    </div>
                  </td>
                  <!-- <td>@{{@$survey->updated_at}}</td> -->
                  <td>
                  @if((explode('-',$survey->status))[0] >= "4")
                    <span class="status_survey text-green" title="Survey has been done">{{ explode("-",$survey->PP)[1] }}</span>
                  @else
                    <span class="status_survey" title="Survey hasn't been done">{{ explode("-",$survey->PP)[1] }}</span>
                  @endif
                  </td>
                  <td class="text-center">
                  @if((explode('-',$survey->status))[0] >= "4")
                    <a href="{{route('survey.analyze',['inputans'=> $survey_id.'-'.$survey->it_related_goal.'-'.$survey->process ])}}" class="btn btn-success btn-sm" title="Survey can be analyzed"><i class="fa fa-bar-chart"></i></a>
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
            </tbody>
          </table>
        </div>
        <div class="tab-pane" id="tab_2">
          Aggregation
        </div>
        <div class="tab-pane" id="tab_3">
        </div>
      </div>
    </div>