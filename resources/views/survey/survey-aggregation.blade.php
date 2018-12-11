<input type="hidden" name="surveyId" id="surveyId" value="{{ $survey_id }}">
<div style="margin: 0 auto; width:50%;"><canvas id="processChart" width="400" height="400"></canvas></div>

<div class="box box-primary">
  <div class="box-header">
    <div class="box-title">
      Summary
    </div>
  </div>
  <div class="box-body">
    <table class="table table-bordered">
      <tr>
        <th style="width: 10px">1</th>
        <th>Total Process</th>
        <th id="totalProcess"></th>
      </tr>
      <tr>
        <th style="width: 10px">2</th>
        <th>Process yang telah mencapai target</th>
        <th id="processCapaiTarget"></th>
      </tr>
      <tr>
        <th style="width: 10px">3</th>
        <th>Process yang belum mencapai target</th>
        <th id="processBelumCapaiTarget"></th>
      </tr>
    </table>
  </div>
</div>

<div class="box box-primary">
  <div class="box-header">
    <div class="box-title">
      Detail Pencapaian
    </div>
  </div>
  <div class="box-body">
    <table class="table table-bordered" id="table-detail-process">
      <thead>
        <tr >
          <div style="text-align: center; vertical-align: middle;">
            <th style="width: 10px; text-align: center; vertical-align: middle;" rowspan="2">No</th>
            <th style="text-align: center; vertical-align: middle;" rowspan="2">Process Name</th>
            <th style="text-align: center; vertical-align: middle;" colspan="5">Capability Level</th>
          </div>
        </tr>
        <tr >
          <div style="text-align: center; vertical-align: middle;">
            <th >Level 1</th>
            <th >Level 2</th>
            <th >Level 3</th>
            <th >Level 4</th>
            <th >Level 5</th>
          </div>
        </tr>
      </thead>
      <tbody id="data-detail-process">
        <!-- <div id="data-detail-process" name="data-detail-process">
          
        </div> -->
      </tbody>
    </table>
  </div>
</div>