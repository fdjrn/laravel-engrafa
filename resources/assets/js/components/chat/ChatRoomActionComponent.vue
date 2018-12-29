<template>
	<div>
		<button type="button" class="btn btn-app btn-primary" @click="InviteUser" data-toggle="modal" data-target="#inviteModal">
			<i class="fa fa-user-plus"></i> Undang
		</button>
		<button type="button" class="btn btn-app btn-primary" data-toggle="modal" href="#groupInviteModal" @click="InviteGroup">
			<i class="fa fa-users"></i> Buat Grup Baru
		</button>
	</div>
</template>

<script>
	export default {
		mounted(){
			
		},
		methods: {
			InviteUser() {
				this.$emit('InviteUser');
			},
			InviteGroup(){
				this.$emit('InviteGroup');	
			}
		}	
	}
</script>