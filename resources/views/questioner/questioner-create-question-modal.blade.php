<div class="modal fade" id="modal-n-question">
  <!-- <div> -->
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Question </h4>
      </div>
      <div class="modal-body" style="max-height: 442px; overflow-y: auto;">
        <!-- 
        <form name="form_c_qeustioner" action="{{url('quisioner/create')}}" method="post" id="form_c_qeustioner" class="form-horizontal"> 
        {{ csrf_field() }}
        -->
        <!-- <form name="form_c_qeustioner" id="form_c_qeustioner" class="form-horizontal"> -->

          
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label for="c_qeustion_name" class="col-sm-2 control-label" style="text-align:left;">Question 1</label>
                <div class="col-sm-10" style="padding-bottom:10px;">
                  <!-- <div class="col-sm-6"> -->
                    <!-- <input type="text" id="c_qeustion_name" name="c_qeustion_name" class="form-control" placeholder="Enter Your Qeustion"> -->
                    <textarea id="c_qeustion_name" name="c_qeustion_name" class="form-control" placeholder="Enter Your Qeustion">

                    </textarea>
                  <!-- </div> -->
                  <!-- <div class="col-sm-6">
                    <select id="c_qeustion_category" name="c_qeustion_category" class="form-control select2" data-placeholder="Qeustion Category"
                          style="width: 100%;">
                      <option value=""></option>
                      <option value="1">Asking</option>
                      <option value="2">Slider</option>
                      <option value="3">Star Rating</option>
                      <option value="4">Checkboxes</option>
                      <option value="5">Ranking</option>
                      <option value="6">Image</option>
                      <option value="7">Multiple Choice</option>
                    </select>
                  </div> -->
                </div>

                <label for="c_qeustion_category" class="col-sm-2 control-label" style="text-align:left;">Question Category</label>
                <div class="col-sm-10">
                  <select id="c_qeustion_category" name="c_qeustion_category" class="form-control select2" data-placeholder="Qeustion Category"
                          style="width: 100%;">
                      <option value=""></option>
                      <option value="1">Asking</option>
                      <option value="2">Slider</option>
                      <option value="3">Star Rating</option>
                      <option value="4">Checkboxes</option>
                      <option value="5">Ranking</option>
                      <option value="6">Image</option>
                      <option value="7">Multiple Choice</option>
                  </select>
                </div>

              </div>
            </div>
          </div>

          <div class="row" id="q_radio_button" style="padding-top:10px;">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="col-sm-2 control-label" style="text-align:left;">Question Choice</label>
                <!-- <div class="col-sm-10"> -->
                  <input type="hidden" name="count" value="1" />
                  <div class="col-sm-10 control-group" id="fields" style="padding-left:20px;">
                    <div class="controls" id="profs"> 
                      <form class="input-append">
                        <div id="field">
                          <input type="radio" id="fieldRadio1" name="" value="" checked="true">
                          <input autocomplete="off" class="input form-control" id="field1" name="prof1" type="text" placeholder="" data-items="8" style="width:92%; display:inline-block;"/>
                          <button id="b1" class="btn btn-default add-more" type="button" style="margin-bottom:3px; width:5%; height:35px;">+</button>
                        </div>
                      </form>
                    </div>
                  </div>
                <!-- </div> -->
              </div>
            </div>
          </div>

          <!-- <div class="row" style="padding-top:10px;">
            <div class="col-lg-12">
              <div class="form-group">
                <label for="c_qeustioner_category" class="col-sm-4 control-label" style="text-align:left;">Quisioner Category</label>
                <div class="col-sm-8">
                  <select id="c_qeustioner_category" name="c_qeustioner_category" class="form-control select2" data-placeholder="Quisioner Category"
                          style="width: 100%;">
                    <option value=""></option>
                    <option value="1">Community</option>
                    <option value="2">Education</option>
                    <option value="3">Event</option>
                    <option value="4">Other</option>
                  </select>
                </div>
              </div>
            </div>
          </div> -->
          
          <!-- </div> -->
        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><!--<i class="fa fa-times"></i>--> Cancel</button>
        <button class="btn btn-primary" id="btn_save_new_quisioner"><!--<i class="fa fa-check"></i>-->Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>