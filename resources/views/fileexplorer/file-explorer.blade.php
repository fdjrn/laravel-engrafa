@extends('layouts.template')

@section('doc_title', isset($documentTitle) ? $documentTitle : 'Document Title')

@section('doc_desc', isset($documentDescription) ? $documentDescription : 'Document Description')

@section('global-mandatory-styles')
@stop

@section('page-level-plugin-styles')
@stop

@section('theme-global-styles')
@stop

@section('page-level-styles')
<style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
  </style>
@stop

@section('theme-layout-styles')
@stop

@section('custom-scripts')
@stop

@section('page-header') 
  <h1>File Explorer</h1>
@stop

@section('page-breadcrumb')
  <li><a class="active" href="#"><i class="fa fa-file"></i> File Explorer</a></li>
@stop


@section('body-inner-content')
<div class="row">
  <div class="col-md-3">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>
          <i class="fa fa-cube fa-fw"></i>
          Dev Team
          <span class="pull-right">
            <i class="fa fa-sort-amount-asc"></i>
          </span>
        </h4>
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </div>
      <div class="box-body">
        
        <ul class="list-group" data-widget="tree" style="list-style: none;">
          <li class="treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span> Some Text</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-folder"></i> <span>Some Text</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                  <ul class="treeview-menu">
                    <li>
                      <a href="#">
                        <i class="fa fa-folder"></i> Some Text</a>
                    </li>
                    <li><a href="#"><i class="fa fa-folder"></i> Some Text</a></li>
                  </ul>
              </li>
              <li><a href="#"><i class="fa fa-folder"></i> Some Text</a></li>
            </ul>
          </li>
        </ul>
        
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-primary ">
      <div class="box-header with-border">
        <h4>
          <i class="fa fa-angle-left fa-fw"></i>
          Some Text
          <span class="pull-right">
            <i class="fa fa-list fa-fw"></i>
            <i class="fa fa-clone"></i>
          </span>
        </h4>
      </div>
      <div class="box-body">
        <table id="table1" class="table table-bordered table-hover" data-toggle="table" data-click-to-select="true">
          <thead>
          <tr>
            <th data-field="state" data-checkbox="true" data-formatter="stateFormatter">
              <input type="checkbox">
            </th>
            <th>Name</th>
            <th>Date Modified</th>
            <th>Creator</th>
            <th>Comment</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td><input type="checkbox"></td>
            <td>
              <i class="fa fa-folder fa-fw"></i>
              <span>Some Text</span>
            </td>
            <td>Some Text</td>
            <td>Some Text</td>
            <td>
              <i class="fa fa-comment fa-fw"></i>
              <span>Some Text</span>
            </td>
          </tr>
          <tr>
            <td><input type="checkbox"></td>
            <td>
              <i class="fa fa-folder fa-fw"></i>
              <span>Some Text</span>
            </td>
            <td>Some Text</td>
            <td>Some Text</td>
            <td>
              <i class="fa fa-comment fa-fw"></i>
              <span>Some Text</span>
            </td>
          </tr>
          <tr>
            <td><input type="checkbox"></td>
            <td>
              <i class="fa fa-usb fa-fw"></i>
              <span>Some Text</span>
            </td>
            <td>Some Text</td>
            <td>Some Text</td>
            <td>
              <i class="fa fa-comment fa-fw"></i>
              <span>Some Text</span>
            </td>
          </tr>
          <tfoot>
            <tr>
              <th data-field="state" data-checkbox="true" data-formatter="stateFormatter">
                <input type="checkbox">
              </th>
              <th>Name</th>
              <th>Date Modified</th>
              <th>Creator</th>
              <th>Comment</th>
            </tr>
            </tfoot>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>
          <i class="fa fa-usb fa-fw"></i>
          Some File
          <span class="pull-right">
            <i class="fa fa-angle-double-right"></i>
          </span>
        </h4>
      </div>
      <div class="box-body">
        
          <div class="box box-primary">
            <div class="box-header with-border">
              <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#file-group" href="#collapseOne">
                  Description
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="collapse in">
              <div class="box-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
              </div>
              <div class="box-footer">
                <span class="pull-left">
                  <a href="">
                    <i class="fa fa-eye fa-fw"></i>
                  </a>
                  <a href="" data-toggle="tooltip" title="edit">
                    <i class="fa fa-edit fa-fw"></i>
                  </a>
                  <a href="" data-toggle="tooltip" title="share">
                    <i class="fa fa-share fa-fw"></i>
                  </a>
                  <a href="" data-toggle="tooltip" title="delete">
                    <i class="fa fa-trash fa-fw"></i>
                  </a>
                </span>
              </div>
            </div>
          </div>

          <div class="box box-primary">
            <div class="box-header with-border">
              <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#file-group" href="#collapseTwo">
                  Contributor
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="collapse in">
              <div class="box-body">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <i class="fa fa-user fa-fw"></i>
                    Creator
                  </li>
                  <li class="list-group-item">
                    <i class="fa fa-user fa-fw"></i>
                    Editor
                  </li>
                  <li class="list-group-item">
                    <i class="fa fa-user fa-fw"></i>
                    Validator
                  </li>
                </ul>
              </div>
              <div class="box-footer">
              </div>
            </div>
          </div>

          <div class="box box-primary">
            <div class="box-header with-border">
              <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#file-group" href="#collapseThree">
                  Modified By
                </a>
              </h4>
            </div>
            <div id="collapseThree" class="collapse in">
              <div class="box-body">
                <table id="table1" class="table table-bordered table-hover" data-toggle="table" data-click-to-select="true">
                  <thead>
                  <tr>
                    <th>File</th>
                    <th>Modified By</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>
                      <i class="fa fa-usb fa-fw"></i>
                      <span>Some Text</span>
                    </td>
                    <td>
                      <i class="fa fa-fw fa-user"></i>
                      <span>
                        Some Text
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <i class="fa fa-usb fa-fw"></i>
                      <span>Some Text</span>
                    </td>
                    <td>
                      <i class="fa fa-fw fa-user"></i>
                      <span>
                        Some Text
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <i class="fa fa-usb fa-fw"></i>
                      <span>Some Text</span>
                    </td>
                    <td>
                      <i class="fa fa-fw fa-user"></i>
                      <span>
                        Some Text
                      </span>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="box-footer">
              </div>
            </div>

        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer text-center">
        <div class="btn-group">
          <button type="button" class="btn btn-flat">
            <i class="fa fa-plus-o"></i>
          </button>
          <button type="button" class="btn btn-flat">
            <i class="fa fa-plus-o"></i>
          </button>
        </div>
        <!-- btn-group -->
      </div>
      <!-- box-footer -->
    </div>
  </div>
</div>
@stop

@section('body-modals')
@stop

@section('core-plugins')
@stop

@section('page-level-plugins')
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop