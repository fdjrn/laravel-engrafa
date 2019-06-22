$(document).ready(function(){
  var rootFolderId = 0;
  var rootFolderName = "";
  var currentFolderId = 0;
  var closeModalInterval;
  var q_asking = "#q_asking";
  var next = 1;
  var countQuis = 0;
  var formId = '#form_edit_questioner';
  var formId2 = '#form_answer_questioner';

  $(q_asking).hide();
  $(".error").remove();

  $(formId).validate({
      doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
      errorElement: 'span', //default input error message container
      errorClass: 'help-block help-block-error', // default input error message class
      focusInvalid: true, // do not focus the last invalid input
      rules : {
        c_questioner_name: {
          required: true,
        },
        c_questioner_category: {
          required: true,
        },
      },

      messages : {
        c_quesioner_name: {
          required: "Questioner name is required",
        },
        c_quesioner_category: {
          required: "Questioner category is required",
        },
      },

      highlight: function (element) { // hightlight error inputs
                $(element)
          .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
      },

      unhighlight: function (element) { // revert the change done by hightlight
          $(element)
            .closest('.form-group').removeClass('has-error'); // set error class to the control group
      }
  });
  
  var dtMain = $("#dt-questioner-preview-table-index").DataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      ajax: "/quisioner/list-all",
      columns: [
          //{data: "checkbox", name: "file-exp-checkbox", orderable: false, searchable: false},
          // {
          //     data: "name",
          //     "fnCreatedCell": function (nTd, sData, oData) {
          //         if (oData.is_file === '1'){
          //             $(nTd).html("<span><i class='fa fa-file fa-lg'></i></span>&nbsp; " + sData);
          //         } else {
          //             $(nTd).html("<span><i class='fa fa-folder fa-lg'></i></span>&nbsp; " + sData );
          //         }
          //     }
          // },
          {data: "rownum"},
          {
            data: "name",
            render: function (data, type, val, meta){
              return '<a href="'+window.location.origin+'/quisioner/preview/detail/'+val.id+'">'+val.name+'</a>';
            }
          },
          {data: "category_name"}
          // {data: "Responses"},
          // {data: "comment"}
      ],
      columnDefs: [{
              //targets: [0, 1, 2, 3, 4],
              targets: [0, 1, 2],
              className: "mdl-data-table__cell--non-numeric"
      }]
  });

  var dtMain2 = $("#dt-questioner-table-index").DataTable({
    destroy: true,
    processing: true,
    serverSide: true,
    ajax: "/quisioner/list-all",
    columns: [
        //{data: "checkbox", name: "file-exp-checkbox", orderable: false, searchable: false},
        // {
        //     data: "name",
        //     "fnCreatedCell": function (nTd, sData, oData) {
        //         if (oData.is_file === '1'){
        //             $(nTd).html("<span><i class='fa fa-file fa-lg'></i></span>&nbsp; " + sData);
        //         } else {
        //             $(nTd).html("<span><i class='fa fa-folder fa-lg'></i></span>&nbsp; " + sData );
        //         }
        //     }
        // },
        {data: "rownum"},
        {
          data: "name",
          render: function (data, type, val, meta){
            if(val.quisioner_filled == 1){
              return val.name;
            }else{
              return '<a href="'+window.location.origin+'/quisioner/view/'+val.id+'">'+val.name+'</a>';
            }
          }
        },
        {data: "category_name"},
        {data: "action", orderable: false, searchable: false}
        // {data: "Responses"},
        // {data: "comment"}
    ],
    columnDefs: [{
            //targets: [0, 1, 2, 3, 4],
            targets: [0, 1, 2],
            className: "mdl-data-table__cell--non-numeric"
    }]
  });

  //main modal create quisioner
  $("#mn_create_new_questioner").click(function(){
    $(".error").remove();
    $('#modal-n-questioner').modal('show');
  });

  var handlingProccess = function(form){
    var base_url = window.location.origin;

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: base_url+"/quisioner/saveedit",
      type: "POST",
      dataType: 'json', // what type of data do we expect back from the server
      encode: true,
      data: form.serialize(),
      success: function (response) {
        if(response.status == 1){
          swal({
              type: "success",
              title: "Success",
              text: 'Quisioner Has Been Updated',
              timer: 2000
          }).then(function() {
              $("#btn_save_edit_quisioner").button('reset');
              $('.form-control').removeAttr('disabled');
              window.location.href = base_url+'/quisioner';
          });

          //window.location.href = base_url+'/quisioner';

          // $("#btn_save_edit_quisioner").button('reset');
          // $('.form-control').removeAttr('disabled');
        }else{
          //toastr.error(response.message,'Error');
          swal({
              type: "error",
              title: "Error",
              text: response.message,
              timer: 2000
          });
        }
        
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
          //toastr.error("Internal Server Error",'Error');
          swal({
              type: "error",
              title: "Error",
              text: "Internal Server Error",
              timer: 2000
          });
          $("#btn_save_edit_quisioner").button('reset');
          $('.form-control').removeAttr('disabled');
      }
    });

  }

  $(formId).submit(function(e){
    if($(this).valid()){
        $("btn_save_edit_quisioner").button('loading');
        handlingProccess($(this));
        $('.form-control').attr('disabled','disabled');

    }
    e.preventDefault();
  });

  $('#btn_cancel_edit').click(function(){
    window.location.href = window.location.origin + '/quisioner';
  });

  
  //edit proses
  var editProcess = function(){
    for(var i=0; i<QUESTIONER_DETAIL.question.length; i++){
      // console.log(QUESTIONER_DETAIL.question[i].id_question_type);
      if(QUESTIONER_DETAIL.question[i].id_question_type == 1){
        countQuis = countQuis + 1;
        createQuisCategoryEdit(QUESTIONER_DETAIL.question[i]);
      }else if(QUESTIONER_DETAIL.question[i].id_question_type == 2){
        countQuis = countQuis + 1;
        createQuisCategoryEdit(QUESTIONER_DETAIL.question[i]);
      }else if(QUESTIONER_DETAIL.question[i].id_question_type == 3){
        countQuis = countQuis + 1;
        createQuisCategoryEdit(QUESTIONER_DETAIL.question[i]);
      }else if(QUESTIONER_DETAIL.question[i].id_question_type == 4){
        countQuis = countQuis + 1;
        createQuisCategoryEdit(QUESTIONER_DETAIL.question[i]);
      }
    }
  };

  var createQuisCategoryEdit = function (arrParams){
    var elCat = '<div id="quis_'+countQuis+'">'+
                  '<div class="row form-group">' +
                    '<label for="c_qeustion_category" class="col-sm-3 control-label" style="text-align:left;">Question '+countQuis+'</label>' +
                    '<div class="col-sm-4" id="quis_question_'+countQuis+'">' +
                      '<input type="text" id="c_question_'+countQuis+'" name="c_question_name['+(countQuis-1)+']" value="'+arrParams.question+'" class="form-control" placeholder="Enter your question" style="width: 100%;">' +
                      '<input type="hidden" id="c_question_id_'+countQuis+'" name="c_question_id['+(countQuis-1)+']" value="'+arrParams.id+'" class="form-control" placeholder="Enter your question" style="width: 100%;">' +
                      '<input type="hidden" id="c_question_category_old_'+countQuis+'" name="c_question_category_old['+(countQuis-1)+']" value="'+arrParams.id_question_type+'" class="form-control" placeholder="Enter your question" style="width: 100%;">' +
                    '</div>' +
                    '<div class="col-sm-4" id="quis_cat_'+countQuis+'">' +
                      '<select id="c_question_category_'+countQuis+'" name="c_question_category['+(countQuis-1)+']" class="form-control select2" data-placeholder="Question Category" '+
                            'style="width: 100%;">' +
                        '<option value=""></option>';
                        if(arrParams.id_question_type == 1){
                          elCat = elCat + '<option value="1" selected>Asking</option>'+
                                          '<option value="2">Slider</option>' +
                                          '<option value="3">Star Rating</option>' +
                                          '<option value="4">Checkboxes</option>';
                        }else if(arrParams.id_question_type == 2){
                          elCat = elCat + '<option value="1">Asking</option>' +
                                          '<option value="2" selected>Slider</option>' +
                                          '<option value="3">Star Rating</option>' +
                                          '<option value="4">Checkboxes</option>';
                        }else if(arrParams.id_question_type == 3){
                          elCat = elCat + '<option value="1">Asking</option>' +
                                          '<option value="2">Slider</option>' +
                                          '<option value="3" selected>Star Rating</option>' +
                                          '<option value="4">Checkboxes</option>';
                        }else if(arrParams.id_question_type == 4){
                          elCat = elCat + '<option value="1">Asking</option>' +
                                          '<option value="2">Slider</option>' +
                                          '<option value="3">Star Rating</option>' +
                                          '<option value="4" selected>Checkboxes</option>';
                        }

                      elCat = elCat + '</select>' +
                    '</div>' +
                    '<span class="help-block"> </span>' +
                  '</div>' +
                  '<div id="choise_answer_question_'+countQuis+'">' +
                  '</div>' +
                '</div>';

    $("#box-body").append(elCat);
    //$("#quis_"+countQuis).prepend(elCat);
    $('#c_question_category_'+countQuis).select2();

    if(arrParams.id_question_type == 1){
      // console.log('test=');
      // console.log(arrParams.choise_asking[0].id);
      for(var i=0; i<arrParams.choise_asking.length; i++){
        handlingQeustionCategoryEdit(countQuis, arrParams.choise_asking);
        addRulesValidation('#c_question_'+countQuis,'Question');
        addRulesValidation('#c_question_category_'+countQuis,'Question Category');
      }
      handlingQeustionCategory(countQuis);
    }else if(arrParams.id_question_type == 2){
      // console.log('test=');
      // console.log(arrParams.slider);
      handlingQeustionCategoryEdit(countQuis, arrParams.slider);
      addRulesValidation('#c_question_'+countQuis,'Question');
      addRulesValidation('#c_question_category_'+countQuis,'Question Category');
      handlingQeustionCategory(countQuis);
    }else if(arrParams.id_question_type == 3){
      // console.log('test=');
      // console.log(arrParams.rating);
      handlingQeustionCategoryEdit(countQuis, arrParams.rating);
      addRulesValidation('#c_question_'+countQuis,'Question');
      addRulesValidation('#c_question_category_'+countQuis,'Question Category');
      handlingQeustionCategory(countQuis);
    }else if(arrParams.id_question_type == 4){
      // console.log('test=');
      // console.log(arrParams.choise_asking[0].id);
      for(var i=0; i<arrParams.choise_checkbox.length; i++){
        handlingQeustionCategoryEdit(countQuis, arrParams.choise_checkbox);
        addRulesValidation('#c_question_'+countQuis,'Question');
        addRulesValidation('#c_question_category_'+countQuis,'Question Category');
      }
      handlingQeustionCategory(countQuis);
    }

    // handlingQeustionCategory(countQuis);
    // addRulesValidation('#c_question_'+countQuis,'Question');
    // addRulesValidation('#c_question_category_'+countQuis,'Question Category');
  }

  var handlingQeustionCategoryEdit = function(cntQuis, arrParams){
    $("#choise_answer_question_"+cntQuis).html('');

    if($('#c_question_category_'+cntQuis).val() == 1){
      for(var i=0; i<arrParams.length; i++){
        if(i == 0){
          createAskingQuestionEdit(cntQuis,'', arrParams[i].question_asking_answer, false);
        }else if(i == arrParams.length-1){
          createAskingQuestionEdit(cntQuis, i+1, arrParams[i].question_asking_answer, true);
        }else{
          createAskingQuestionEdit(cntQuis, i+1, arrParams[i].question_asking_answer, false);
        }
      }
      handlingAddMoreAskingEdit(cntQuis);
    }
    
    if($('#c_question_category_'+cntQuis).val() == 2){
      createSliderQuestionEdit(arrParams.min_value, arrParams.max_value, cntQuis);
    }

    if($('#c_question_category_'+cntQuis).val() == 3){
      createStarRatingQuestionEdit(arrParams.number_of_stars, cntQuis);
    }

    if($('#c_question_category_'+cntQuis).val() == 4){
      for(var i=0; i<arrParams.length; i++){
        if(i == 0){
          createCheckboxQuestionEdit(cntQuis,'', arrParams[i].question_checkbox_answer, false);
        }else if(i == arrParams.length-1){
          createCheckboxQuestionEdit(cntQuis, i+1, arrParams[i].question_checkbox_answer, true);
        }else{
          createCheckboxQuestionEdit(cntQuis, i+1, arrParams[i].question_checkbox_answer, false);
        }
      }
      handlingAddMoreCheckboxEdit(cntQuis);

      // createCheckboxQuestion(cntQuis);
      // handlingAddMoreCheckbox(cntQuis);
    } 
  }

  var handlingAddMoreAskingEdit = function(cntQuis){

    $(document).on('click', '.add-more-asking', function (e) {
      // your function here
      e.stopPropagation();
      e.stopImmediatePropagation();
      var addto = "#field" + next;

      var cntQuis = $(this).attr('data-count-quis');
      var next = $(this).attr('data-id-next');
      var removeBtn = '<button id="remove_asking_'+ cntQuis + '_' + (next) + '" data-count-quis="'+cntQuis+'" data-id-next="'+(next)+'" class="btn btn-default remove-asking" type="button" style="margin-left:3px; margin-bottom:3px; width:7%; height:35px;">-</button>';
      var idField = '#field_asking_'+cntQuis+'_'+next;
      var buttonAdd = '#b_asking_'+cntQuis+'_'+next;
      
      $(buttonAdd).remove();
      $(idField).append(removeBtn);

      next++;

      createAskingQuestionEdit(cntQuis,next,'',true);

    });

    $(document).on('click', '.remove-asking', function (e) {
      // your function here
      e.stopPropagation();
      e.stopImmediatePropagation();
  
      var cntQuis = $(this).attr('data-count-quis');
      var next = $(this).attr('data-id-next');
  
      var field = "#quis_asking_" + cntQuis + '_' + next;
      $(field).remove();
  
    });
    
  }

  var handlingAddMoreCheckboxEdit = function(cntQuis){
    $(document).on('click', '.add-more-checkbox', function (e) {
      // your function here
      e.stopPropagation();
      e.stopImmediatePropagation();
      //var addto = "#field" + next;

      var cntQuis = $(this).attr('data-count-quis');
      var next = $(this).attr('data-id-next');
      var removeBtn = '<button id="remove_checkbox_'+ cntQuis + '_' + (next) + '" data-count-quis="'+cntQuis+'" data-id-next="'+(next)+'" class="btn btn-default remove-checkbox" type="button" style="margin-left:3px; margin-bottom:3px; width:7%; height:35px;">-</button>';
      var idField = '#field_checkbox_'+cntQuis+'_'+next;
      var buttonAdd = '#b_checkbox_'+cntQuis+'_'+next;
      
      $(buttonAdd).remove();
      $(idField).append(removeBtn);

      next++;

      createCheckboxQuestion(cntQuis,next)

    });

    $(document).on('click', '.remove-checkbox', function (e) {
      // your function here
      e.stopPropagation();
      e.stopImmediatePropagation();
  
      var cntQuis = $(this).attr('data-count-quis');
      var next = $(this).attr('data-id-next');
  
      var field = "#quis_checkbox_" + cntQuis + '_' + next;
      $(field).remove();
  
    });
  };

  var createAskingQuestionEdit = function (cntQuis, next='', questionName='', isLast=false){
    if(isLast == false){
      var elAsking = '<div class="row form-group" id="quis_asking_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                      '<div class="col-sm-offset-3 col-sm-8 control-group" id="fields_asking_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                          '<div class="controls" id="profs_asking_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                              '<div class="input-append" id="field_asking_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                                '<input type="radio" id="fieldRadio_asking_'+cntQuis+((next)?'_'+next:'_1')+'" value="" checked="true" style="margin-right:7px;" disabled>' +
                                '<input autocomplete="off" class="input form-control" id="fields_asking_'+cntQuis+((next)?'_'+next:'_1')+'" name="choise_asking_question['+(cntQuis-1)+']['+((next)?next-1:'0')+']" value="'+questionName+'" type="text" style="width:87%; display:inline-block; margin-right:5px;"/>' +
                                '<button id="remove_asking_'+ cntQuis + '_' + (next) + '" data-count-quis="'+cntQuis+'" data-id-next="'+(next)+'" class="btn btn-default remove-asking" type="button" style="margin-left:3px; margin-bottom:3px; width:7%; height:35px;">-</button>' +
                              '</div>' +
                          '</div>' +
                      '</div>' +
                      '<span class="help-block"></span>'+
                    '</div>';
    }else{
      var elAsking = '<div class="row form-group" id="quis_asking_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                      '<div class="col-sm-offset-3 col-sm-8 control-group" id="fields_asking_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                          '<div class="controls" id="profs_asking_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                              '<div class="input-append" id="field_asking_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                                '<input type="radio" id="fieldRadio_asking_'+cntQuis+((next)?'_'+next:'_1')+'" value="" checked="true" style="margin-right:7px;" disabled>' +
                                '<input autocomplete="off" class="input form-control" id="fields_asking_'+cntQuis+((next)?'_'+next:'_1')+'" name="choise_asking_question['+(cntQuis-1)+']['+((next)?next-1:'0')+']" value="'+questionName+'" type="text" style="width:87%; display:inline-block; margin-right:5px;"/>' +
                                '<button id="b_asking_'+cntQuis+((next)?'_'+next:'_1')+'" class="btn btn-default add-more-asking" data-count-quis="'+cntQuis+'" data-id-next="'+((next)?next:'1')+'" type="button" style="margin-left:3px; margin-bottom:3px; width:7%; height:35px;">+</button>' +
                              '</div>' +
                          '</div>' +
                      '</div>' +
                      '<span class="help-block"></span>'+
                    '</div>';
    }

    $("#choise_answer_question_"+cntQuis).append(elAsking);
    addRulesValidationArray('choise_asking_question',cntQuis-1,((next)?next-1:0),'Asking Question');
  }

  var createCheckboxQuestionEdit = function(cntQuis, next='', questionName='', isLast=false){
    if(isLast == false){
      var elCheckbox = '<div class="row form-group" id="quis_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                      '<div class="col-sm-offset-3 col-sm-8 control-group" id="fields_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                          '<div class="controls" id="profs_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                              '<div class="input-append" id="field_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                                '<input type="checkbox" id="fieldCheckbox_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'" value="" checked="true" style="margin-right:7px;" disabled>' +
                                '<input autocomplete="off" class="input form-control" id="fields_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'" name="choise_checkbox_question['+(cntQuis-1)+']['+((next)?next-1:'0')+']" value="'+questionName+'" type="text" style="width:87%; display:inline-block; margin-right:5px;"/>' +
                                '<button id="remove_checkbox_'+ cntQuis + '_' + (next) + '" data-count-quis="'+cntQuis+'" data-id-next="'+(next)+'" class="btn btn-default remove-checkbox" type="button" style="margin-left:3px; margin-bottom:3px; width:7%; height:35px;">-</button>' +
                              '</div>' +
                          '</div>' +
                      '</div>' +
                      '<span class="help-block"></span>'+
                    '</div>';
    }else{
      var elCheckbox = '<div class="row form-group" id="quis_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                      '<div class="col-sm-offset-3 col-sm-8 control-group" id="fields_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                          '<div class="controls" id="profs_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                              '<div class="input-append" id="field_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                                '<input type="checkbox" id="fieldCheckbox_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'" value="" checked="true" style="margin-right:7px;" disabled>' +
                                '<input autocomplete="off" class="input form-control" id="fields_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'" name="choise_checkbox_question['+(cntQuis-1)+']['+((next)?next-1:'0')+']" value="'+questionName+'" type="text" style="width:87%; display:inline-block; margin-right:5px;"/>' +
                                '<button id="b_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'" class="btn btn-default add-more-checkbox" data-count-quis="'+cntQuis+'" data-id-next="'+((next)?next:'1')+'" type="button" style="margin-left:3px; margin-bottom:3px; width:7%; height:35px;">+</button>' +
                              '</div>' +
                          '</div>' +
                      '</div>' +
                      '<span class="help-block"></span>'+
                    '</div>';  
    }

    $("#choise_answer_question_"+cntQuis).append(elCheckbox);
    addRulesValidationArray('choise_checkbox_question',cntQuis-1,((next)?next-1:0),'Checkbox Question');
  }

  var createSliderQuestionEdit = function(minVal, maxVal, cntQuis,next=''){
    var elSlider = '<div class="row form-group" id="quis_slider_min_value_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                        '<label for="field_slider_min_value_'+cntQuis+((next)?'_'+next:'_1')+'" class="col-sm-3 col-sm-offset-3 control-label" style="text-align:left;">Minimal Value</label>' +
                        '<div class="col-sm-5">'+
                          '<input type="number" id="field_slider_min_value_'+cntQuis+((next)?'_'+next:'_1')+'" min="0" name="slider_min_value['+(cntQuis-1)+']" value="'+minVal+'" class="form-control" placeholder="Min Value">'+
                        '</div>'+
                        '<span class="help-block"></span>'+
                    '</div>'+
                    '<div class="row form-group" id="quis_slider_max_value_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                        '<label for="field_slider_max_value_'+cntQuis+((next)?'_'+next:'_1')+'" class="col-sm-3 col-sm-offset-3 control-label" style="text-align:left;">Maximal Value</label>' +
                        '<div class="col-sm-5">'+
                          '<input type="number" id="field_slider_max_value_'+cntQuis+((next)?'_'+next:'_1')+'" min="0" name="slider_max_value['+(cntQuis-1)+']" value="'+maxVal+'" class="form-control" placeholder="Max Value">'+                          
                        '</div>'+
                        '<span class="help-block"></span>'+
                    '</div>';

    $("#choise_answer_question_"+cntQuis).append(elSlider);
    addRulesValidation('#field_slider_min_value_'+cntQuis+((next)?'_'+next:'_1'),'Slider Minimal Value');
    addRulesValidation('#field_slider_max_value_'+cntQuis+((next)?'_'+next:'_1'),'Slider Maximal Value');
  }

  var createStarRatingQuestionEdit = function(jmlStar, cntQuis,next){
    var elStarRating = '<div class="row form-group" id="quis_star_rating_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                        '<label for="field_star_rating_value_'+cntQuis+((next)?'_'+next:'_1')+'" class="col-sm-3 col-sm-offset-3 control-label" style="text-align:left;">Number of Stars</label>' +
                        '<div class="col-sm-5">'+
                          '<input type="number" id="field_star_rating_value_'+cntQuis+((next)?'_'+next:'_1')+'" name="star_rating_value['+(cntQuis-1)+']" value="'+jmlStar+'" class="form-control" min="2" placeholder="Number of Stars">'+
                        '</div>'+
                        '<span class="help-block"></span>'+
                    '</div>';

    $("#choise_answer_question_"+cntQuis).append(elStarRating);
    
    addRulesValidation('#field_star_rating_value_'+cntQuis+((next)?'_'+next:'_1'),'Number of Stars');
  }


  
  //create process
  //add new element
  $("#btn_add_question").click(function(e){
    //$(q_asking).show();
    e.preventDefault();
    countQuis = countQuis + 1;
    createQuisCategory();
  });

  var createQuisCategory = function (){
    var elCat = '<div id="quis_'+countQuis+'">'+
                  '<div class="row form-group">' +
                    '<label for="c_qeustion_category" class="col-sm-3 control-label" style="text-align:left;">Question '+countQuis+'</label>' +
                    '<div class="col-sm-4" id="quis_question_'+countQuis+'">' +
                      '<input type="text" id="c_question_'+countQuis+'" name="c_question_name['+(countQuis-1)+']" class="form-control" placeholder="Enter your question" style="width: 100%;">' +
                    '</div>' +
                    '<div class="col-sm-4" id="quis_cat_'+countQuis+'">' +
                      '<select id="c_question_category_'+countQuis+'" name="c_question_category['+(countQuis-1)+']" class="form-control select2" data-placeholder="Question Category" '+
                            'style="width: 100%;">' +
                        '<option value=""></option>' +
                        '<option value="1">Asking</option>' +
                        '<option value="2">Slider</option>' +
                        '<option value="3">Star Rating</option>' +
                        '<option value="4">Checkboxes</option>' +
                        //'<option value="5">Ranking</option>' +
                        //'<option value="6">Image</option>' +
                        //'<option value="7">Multiple Choice</option>' +
                      '</select>' +
                    '</div>' +
                    '<span class="help-block"> </span>' +
                  '</div>' +
                  '<div id="choise_answer_question_'+countQuis+'">' +
                  '</div>' +
                '</div>';

    $("#box-body").append(elCat);
    //$("#quis_"+countQuis).prepend(elCat);
    $('#c_question_category_'+countQuis).select2();
    handlingQeustionCategory(countQuis);
    addRulesValidation('#c_question_'+countQuis,'Question');
    addRulesValidation('#c_question_category_'+countQuis,'Question Category');
  }

  var createStarRatingQuestion = function(cntQuis,next){
    var elStarRating = '<div class="row form-group" id="quis_star_rating_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                        '<label for="field_star_rating_value_'+cntQuis+((next)?'_'+next:'_1')+'" class="col-sm-3 col-sm-offset-3 control-label" style="text-align:left;">Number of Stars</label>' +
                        '<div class="col-sm-5">'+
                          '<input type="number" id="field_star_rating_value_'+cntQuis+((next)?'_'+next:'_1')+'" name="star_rating_value['+(cntQuis-1)+']" class="form-control" min="2" placeholder="Number of Stars">'+
                        '</div>'+
                        '<span class="help-block"></span>'+
                    '</div>';

    $("#choise_answer_question_"+cntQuis).append(elStarRating);
    
    addRulesValidation('#field_star_rating_value_'+cntQuis+((next)?'_'+next:'_1'),'Number of Stars');
  }

  var createAskingQuestion = function (cntQuis,next=''){
    var elAsking = '<div class="row form-group" id="quis_asking_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                      '<div class="col-sm-offset-3 col-sm-8 control-group" id="fields_asking_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                          '<div class="controls" id="profs_asking_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                              '<div class="input-append" id="field_asking_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                                '<input type="radio" id="fieldRadio_asking_'+cntQuis+((next)?'_'+next:'_1')+'" value="" checked="true" style="margin-right:7px;" disabled>' +
                                '<input autocomplete="off" class="input form-control" id="fields_asking_'+cntQuis+((next)?'_'+next:'_1')+'" name="choise_asking_question['+(cntQuis-1)+']['+((next)?next-1:'0')+']" type="text" style="width:87%; display:inline-block; margin-right:5px;"/>' +
                                '<button id="b_asking_'+cntQuis+((next)?'_'+next:'_1')+'" class="btn btn-default add-more-asking" data-count-quis="'+cntQuis+'" data-id-next="'+((next)?next:'1')+'" type="button" style="margin-left:3px; margin-bottom:3px; width:7%; height:35px;">+</button>' +
                              '</div>' +
                          '</div>' +
                      '</div>' +
                      '<span class="help-block"></span>'+
                    '</div>';

    $("#choise_answer_question_"+cntQuis).append(elAsking);
    addRulesValidationArray('choise_asking_question',cntQuis-1,((next)?next-1:0),'Asking Question');
  }

  var createSliderQuestion = function(cntQuis,next=''){
    var elSlider = '<div class="row form-group" id="quis_slider_min_value_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                        '<label for="field_slider_min_value_'+cntQuis+((next)?'_'+next:'_1')+'" class="col-sm-3 col-sm-offset-3 control-label" style="text-align:left;">Minimal Value</label>' +
                        '<div class="col-sm-5">'+
                          '<input type="number" id="field_slider_min_value_'+cntQuis+((next)?'_'+next:'_1')+'" min="0" name="slider_min_value['+(cntQuis-1)+']" class="form-control" placeholder="Min Value">'+
                        '</div>'+
                        '<span class="help-block"></span>'+
                    '</div>'+
                    '<div class="row form-group" id="quis_slider_max_value_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                        '<label for="field_slider_max_value_'+cntQuis+((next)?'_'+next:'_1')+'" class="col-sm-3 col-sm-offset-3 control-label" style="text-align:left;">Maximal Value</label>' +
                        '<div class="col-sm-5">'+
                          '<input type="number" id="field_slider_max_value_'+cntQuis+((next)?'_'+next:'_1')+'" min="0" name="slider_max_value['+(cntQuis-1)+']" class="form-control" placeholder="Max Value">'+                          
                        '</div>'+
                        '<span class="help-block"></span>'+
                    '</div>';

    $("#choise_answer_question_"+cntQuis).append(elSlider);
    addRulesValidation('#field_slider_min_value_'+cntQuis+((next)?'_'+next:'_1'),'Slider Minimal Value');
    addRulesValidation('#field_slider_max_value_'+cntQuis+((next)?'_'+next:'_1'),'Slider Maximal Value');
  }

  var createCheckboxQuestion = function(cntQuis,next=''){
    var elCheckbox = '<div class="row form-group" id="quis_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                      '<div class="col-sm-offset-3 col-sm-8 control-group" id="fields_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                          '<div class="controls" id="profs_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                              '<div class="input-append" id="field_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'">' +
                                '<input type="checkbox" id="fieldCheckbox_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'" value="" checked="true" style="margin-right:7px;" disabled>' +
                                '<input autocomplete="off" class="input form-control" id="fields_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'" name="choise_checkbox_question['+(cntQuis-1)+']['+((next)?next-1:'0')+']" type="text" style="width:87%; display:inline-block; margin-right:5px;"/>' +
                                '<button id="b_checkbox_'+cntQuis+((next)?'_'+next:'_1')+'" class="btn btn-default add-more-checkbox" data-count-quis="'+cntQuis+'" data-id-next="'+((next)?next:'1')+'" type="button" style="margin-left:3px; margin-bottom:3px; width:7%; height:35px;">+</button>' +
                              '</div>' +
                          '</div>' +
                      '</div>' +
                      '<span class="help-block"></span>'+
                    '</div>';

    $("#choise_answer_question_"+cntQuis).append(elCheckbox);
    addRulesValidationArray('choise_checkbox_question',cntQuis-1,((next)?next-1:0),'Checkbox Question');
  }

  var handlingQeustionCategory = function(cntQuis){
    $('#c_question_category_'+cntQuis).on("change", function(e) {
      $("#choise_answer_question_"+cntQuis).html('');

      if($('#c_question_category_'+cntQuis).val() == 1){
        createAskingQuestion(cntQuis);
        handlingAddMoreAsking(cntQuis);
      }
      
      if($('#c_question_category_'+cntQuis).val() == 2){
        createSliderQuestion(cntQuis);
      }

      if($('#c_question_category_'+cntQuis).val() == 3){
        createStarRatingQuestion(cntQuis);
      }

      if($('#c_question_category_'+cntQuis).val() == 4){
        createCheckboxQuestion(cntQuis);
        handlingAddMoreCheckbox(cntQuis);
      }


    });  
  }

  var handlingAddMoreCheckbox = function(cntQuis){
    $(document).on('click', '.add-more-checkbox', function (e) {
      // your function here
      e.stopPropagation();
      e.stopImmediatePropagation();
      //var addto = "#field" + next;

      var cntQuis = $(this).attr('data-count-quis');
      var next = $(this).attr('data-id-next');
      var removeBtn = '<button id="remove_checkbox_'+ cntQuis + '_' + (next) + '" data-count-quis="'+cntQuis+'" data-id-next="'+(next)+'" class="btn btn-default remove-checkbox" type="button" style="margin-left:3px; margin-bottom:3px; width:7%; height:35px;">-</button>';
      var idField = '#field_checkbox_'+cntQuis+'_'+next;
      var buttonAdd = '#b_checkbox_'+cntQuis+'_'+next;
      
      $(buttonAdd).remove();
      $(idField).append(removeBtn);

      next++;

      createCheckboxQuestion(cntQuis,next)

    });

    $(document).on('click', '.remove-checkbox', function (e) {
      // your function here
      e.stopPropagation();
      e.stopImmediatePropagation();
  
      var cntQuis = $(this).attr('data-count-quis');
      var next = $(this).attr('data-id-next');
  
      var field = "#quis_checkbox_" + cntQuis + '_' + next;
      $(field).remove();
  
    });
  };

  var handlingAddMoreAsking = function(cntQuis){

    $(document).on('click', '.add-more-asking', function (e) {
      // your function here
      e.stopPropagation();
      e.stopImmediatePropagation();
      //var addto = "#field" + next;

      var cntQuis = $(this).attr('data-count-quis');
      var next = $(this).attr('data-id-next');
      var removeBtn = '<button id="remove_asking_'+ cntQuis + '_' + (next) + '" data-count-quis="'+cntQuis+'" data-id-next="'+(next)+'" class="btn btn-default remove-asking" type="button" style="margin-left:3px; margin-bottom:3px; width:7%; height:35px;">-</button>';
      var idField = '#field_asking_'+cntQuis+'_'+next;
      var buttonAdd = '#b_asking_'+cntQuis+'_'+next;
      
      $(buttonAdd).remove();
      $(idField).append(removeBtn);

      next++;

      createAskingQuestion(cntQuis,next);

    });

    $(document).on('click', '.remove-asking', function (e) {
      // your function here
      e.stopPropagation();
      e.stopImmediatePropagation();
  
      var cntQuis = $(this).attr('data-count-quis');
      var next = $(this).attr('data-id-next');
  
      var field = "#quis_asking_" + cntQuis + '_' + next;
      $(field).remove();
  
    });
    
  }

  var addRulesValidation = function(id,field){
    $(id).rules('add', {
      required: true,
      messages : {
        required : field + ' is required'
      }
    });
  }
  
  var addRulesValidationArray = function(name,index,next,field){

    $('input[name="'+name+'['+index+']['+next+']"]').rules("add", {
      required: true,
      messages: {
          required: field + " is required"
      }
    });
      
  }

  var handlingProccessAnswer = function(form){

    var base_url = window.location.origin;

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: base_url+"/quisioner/answer",
      type: "POST",
      dataType: 'json', // what type of data do we expect back from the server
      encode: true,
      data: form.serialize(),
      success: function (response) {
        if(response.status == 1){
          swal({
              type: "success",
              title: "Success",
              text: 'Quisioner answer has been saved',
              timer: 2000
          }).then(function() {
              window.location.href = base_url+'/quisioner';
          });
          //window.location.href = base_url+'/quisioner';
        }else{
          //toastr.error(response.message,'Error');
          swal({
              type: "error",
              title: "Error",
              text: 'Quisioner answer failed to be saved',
              timer: 2000
          });
        }
        $("#btn_save_edit_quisioner").button('reset');
        $('.form-control').removeAttr('disabled');
        $('.custom-control').removeAttr('disabled');
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
          //toastr.error("Internal Server Error",'Error');
          swal({
              type: "error",
              title: "Error",
              text: 'Internal Server Error',
              timer: 2000
          });
          $("#btn_save_edit_quisioner").button('reset');
          $('.form-control').removeAttr('disabled');
          $('.custom-control').removeAttr('disabled');
      }
    });

  }

  $(formId2).submit(function(e){
    if($(this).valid()){
      $("btn_save_answer_quisioner").button('loading');
      handlingProccessAnswer($(this));
      $('.form-control').attr('disabled','disabled');
      $('.custom-control').attr('disabled','disabled');
    }
    e.preventDefault();
  });

  var validateQuestionerQuestion = function(){

    $(formId2).validate({
      doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
      errorElement: 'span', //default input error message container
      errorClass: 'help-block help-block-error', // default input error message class
      focusInvalid: true, // do not focus the last invalid input
      highlight: function (element) { // hightlight error inputs
        $(element)
          .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
      },
      errorPlacement: function (error, element) { // render error placement for each input type               
                
        if (element.parents('.mt-checkbox-inline')[0]) {
            error.appendTo(element.parents('.mt-checkbox-inline')[0]);
        }
        else if (element.parents('.mt-radio-inline')[0]) {
            error.appendTo(element.parents('.mt-radio-inline')[0]);
        }
        else if (element.parents('.file-upload')[0]) {
            error.appendTo(element.parents('.file-upload')[0]);
        }
        else if (element.attr("data-error-container")) { 
            error.appendTo(element.attr("data-error-container"));
        } 
        else{
            error.insertAfter(element); // for other inputs, just perform default behavior
        }
      },
      unhighlight: function (element) { // revert the change done by hightlight
          $(element)
            .closest('.form-group').removeClass('has-error'); // set error class to the control group
      }
    });

    $('[name^="answer_asking"]').each(function(){
      $(this).rules('add', {
        required: true,
        messages: {
            required: "Please choise this answer",
        }
      });
    });

    $('[name^="answer_slider"]').each(function(){
      $(this).rules('add', {
        required: true,
        messages: {
            required: "Please slide value minimal is 0",
        }
      });
    });

    $('[name^="answer_rating"]').each(function(){
      $(this).rules('add', {
        required: true,
        min: 1,
        messages: {
            required: "Please rate minimal 1",
            min: "Please rate minimal 1",
        }
      });
    });

    $('[name^="answer_checkbox"]').each(function(){
      $(this).rules('add', {
        required: true,
        messages: {
            required: "Please choise this answer minimal 1",
        }
      });
    });

  }
  
  validateQuestionerQuestion();
  editProcess();

});