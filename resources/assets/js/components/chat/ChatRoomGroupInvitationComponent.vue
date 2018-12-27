<template>
	<div>
		<div class="modal fade" id="groupInviteModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Group Invitation
					</div>
					<div class="modal-body">
					</div>  
					<div class="modal-footer justify-content-start" style="text-align:center;">
					</div>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
	</div>
<!-- /.modal-content -->
</template>

<script>
	export default{
		data() {
			return {
				showModal : false
			}
		},
		mounted(){
			console.log('invitation mounted');
		},
		methods : {
			show() {
				console.log("show invitation modal");
				this.showModal = true
			},
			hide() {
				this.showModal = false
			}
		}
	}
</script>