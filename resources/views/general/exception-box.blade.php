
<div id="{{ isset($id) ? $id : 'ctiExceptionBox' }}" class="alert alert-danger display-hide cti-exception-box">
    <button class="close" style="margin-top:-41px;" data-close="alert"></button>
    <span id="exception_info">{{ isset($msg) ? $msg : 'Something worng happened !!!' }}</span>
</div>
