@if(explode("-",$status_ownership)[0] < 2)
<input type="hidden" id="s_id" value="{{$survey_id}}">
  <div class="modal fade" id="m_invite_user">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-user-plus"></i>&nbsp;Invite User</h4>
        </div>
        <div class="modal-body">
          <form name="form_i_user" id="form_i_user" method="POST" action="{{route('survey.invite',['id' => $survey_id])}}">
            @csrf
            <input type="hidden" name="user_id" id="user_id">
            <div class="form-group">
              <label for="inv_surveyor" class="control-label">Add Manager</label>
              <select id="inv_surveyor" name="inv_surveyor[]" class="form-control select2" multiple data-placeholder="Add Manager"
                      style="width: 100%;" >
              </select>
            </div>
            <div class="form-group">
              <label for="inv_responden" class="control-label">Add Assessor</label>
              <select id="inv_responden" name="inv_responden[]" class="form-control select2" multiple data-placeholder="Add Assessor"
                      style="width: 100%;" >
                    <option value=""></option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i></button>
          <button type="submit" form="form_i_user" class="btn btn-primary"><i class="fa fa-check"></i></button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endif