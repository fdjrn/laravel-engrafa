<template>
	<div>
		<button type="button" class="btn btn-app btn-primary" @click="InviteUser" data-toggle="modal" data-target="#inviteModal">
			<i class="fa fa-user-plus"></i> Undang
		</button>
		<a class="btn btn-app btn-primary" data-toggle="modal" href="#groupInviteModal">
			<i class="fa fa-users"></i> Buat Grup Baru
		</a>
	</div>
</template>

<script>
	export default {
		mounted(){
			
		},
		methods: {
			InviteUser() {
				console.log("invite user");
				this.$emit('InviteUser');
			}
		}	
	}
</script>