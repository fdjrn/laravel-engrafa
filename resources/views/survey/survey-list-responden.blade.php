
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Pending Survey</a></li>
        <li><a href="#tab_2" data-toggle="tab">Done</a></li>
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
                <th>Start</th>
              </tr>
            </thead>
            <tbody>
              @foreach($surveys as $survey)
                <tr>
                  <td><input type="checkbox"></td>
                  <td>
                    <div>
                      <a href="{{route('survey.answer',['id'=> $survey_id, 'itrelatedgoal' => $survey->it_related_goal, 'process' => $survey->process ])}}">
                        <p>
                          {{$survey->process}}
                        </p>
                      </a>
                    </div>
                  </td>
                  <td class="text-center">
                    <a href="{{route('survey.choose.answer',['id'=> $survey_id, 'itrelatedgoal' => $survey->it_related_goal, 'process' => $survey->process ])}}" class="btn btn-info btn-sm"><i class="fa fa-play fa-fw"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
        <div class="tab-pane" id="tab_2">
          Done
        </div>
      </div>
    </div>