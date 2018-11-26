
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
                @if($survey->status == "1-Waiting" || $survey->status == "2-Process Survey")
                <tr>
                  <td><input type="checkbox"></td>
                  <td>
                    <div>
                      <a href="{{ route('survey.choose.answer') }}">
                        <p>
                          {{$survey->process}}
                        </p>
                        <!-- <h6>Created @{{@$survey->created_ats}}</h6> -->
                      </a>
                    </div>
                  </td>
                  <!-- <td>@{{@$survey->updated_at}}</td> -->
                  <td>{{ explode("-",$survey->PP)[1] }}</td>
                  <td class="text-center">
                    <a href="{{$survey->id}}" class="btn btn-default btn-sm"><i class="fa fa-bar-chart"></i></a>
                  </td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="{{$survey->id}}" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-fw"></i></a>
                      <a href="{{$survey->id}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    </div>
                  </td>
                </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="tab-pane" id="tab_2">
          Aggregation
        </div>
        <div class="tab-pane" id="tab_3">
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
                @if($survey->status == "3-Done Survey")
                <tr>
                  <td><input type="checkbox"></td>
                  <td>
                    <div>
                      <a href="{{ route('survey.choose.answer') }}">
                        <p>
                          {{$survey->process}}
                        </p>
                        <!-- <h6>Created @{{@$survey->created_ats}}</h6> -->
                      </a>
                    </div>
                  </td>
                  <!-- <td>@{{@$survey->updated_at}}</td> -->
                  <td>{{ explode("-",$survey->PP)[1] }}</td>
                  <td class="text-center">
                    <a href="{{$survey->id}}" class="btn btn-default btn-sm"><i class="fa fa-bar-chart"></i></a>
                  </td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="{{$survey->id}}" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-fw"></i></a>
                      <a href="{{$survey->id}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    </div>
                  </td>
                </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>