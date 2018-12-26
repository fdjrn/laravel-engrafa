  <div class="inside-sidemenu">
    <div class="box">
      <!-- <div class="box-header with-border">
        <h4>
          <i class="fa fa-files-o fa-fw"></i>
          Survey
        </h4>
      </div> -->
      <div class="box-body">
        <ul class="list-group inside-submenu no-margin" data-widget="tree" style="list-style: none;">
          <li class="">
            <a>
              <h4><i class="fa fa-comment-o"></i>&nbsp;&nbsp;<span>Chat</span></h4>
            </a>
          </li>
          <li class="">
            <a href="{{route('survey.task',['id'=> $survey_id])}}">
              <h4><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;<span>Task</span></h4>
            </a>
          </li>
          <li class="">
            <a href="{{route('survey',['id'=> $survey_id])}}">
              <h4><i class="fa fa-files-o"></i>&nbsp;&nbsp;<span>Survey</span></h4>
            </a>
          </li>
          <li class="list_user">
            <div id="carousel-example-multi" class="carousel carousel-multi slide" data-ride="carousel">
              <div class="carousel-inner" role="listbox">
                @foreach($survey_members as $index => $survey_member)
                  <div class="item {{ !$index ? 'active' : '' }}">
                    <div class="media media-card">
                      <div class="icon-user">
                        <i class="{{ $survey_member->role == '1-Surveyor' ? 'fa fa-user-secret' : 'fa fa-user' }}" title="{{ $survey_member->username }}"></i>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              <a class="right carousel-control" href="#carousel-example-multi" data-slide="next">
                <span class="fa fa-angle-right"></span>
              </a>
            </div>
          </li>
          @if($status_ownership != 'RESPONDEN')
          <li class="footer">
            <a id="o_invite_user">
              <h4><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<span>Invite</span></h4>
            </a>
          </li>
          @endif
        </ul>
      </div>
      <!-- /.box-body -->
<!--       <div class="box-footer text-center">
        <a href="">
          <i class="fa fa-plus-circle fa-fw"></i>
        </a>
        <a href="">
          <i class="fa fa-folder fa-fw"></i>
        </a>
        <a href="">
          <i class="fa fa-sticky-note-o fa-fw"></i>
        </a>
        <a href="">
          <i class="fa fa-upload fa-fw"></i>
        </a>
      </div> -->
    </div>
  </div>