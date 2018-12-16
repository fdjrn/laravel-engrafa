
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>
          <i class="fa fa-files-o fa-fw"></i>
          Survey
        </h4>
      </div>
      <div class="box-body">
        <ul class="list-group" data-widget="tree" style="list-style: none;">
          <li class="">
            <a href="#">
              <h4><i class="fa fa-comment-o"></i>&nbsp;<span>Chat</span></h4>
            </a>
          </li>
          <li class="">
            <a href="{{route('survey.task',['id'=> $survey_id])}}">
              <h4><i class="fa fa-check-square-o"></i>&nbsp;<span>Task</span></h4>
            </a>
          </li>
          <li class="">
            <a href="{{route('survey',['id'=> $survey_id])}}">
              <h4><i class="fa fa-files-o"></i>&nbsp;<span>Survey</span></h4>
            </a>
          </li>
        </ul>
      </div>
      <!-- /.box-body -->
      @if($status_ownership != 'RESPONDEN')
        <div class="box-footer text-center">
          <h4><a id="o_invite_user" href="#"><i class="fa fa-user-plus"></i>&nbsp;<span>Invite</span></a></h4>
        </div>
      @endif
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
  