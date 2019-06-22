<div {!! isset($alert_box_id) ? 'id="' . $alert_box_id . '"' : '' !!} class="alert alert-danger display-hide">
    <button class="close" data-close="alert"></button>
    <span id="exception_info">{{ isset($alert_box_msg) ? $alert_box_msg : 'Something worng happened !!!' }}</span>
</div>