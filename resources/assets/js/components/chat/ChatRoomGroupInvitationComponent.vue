<template>
	<div>
		<div class="modal fade" id="groupInviteModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Group Invitation
					</div>
					<div class="modal-body">
						<div class="form-group">
							<input class="form-control" type="text" name="groupName" id="groupName" placeholder="Group Name" v-model="name">
						</div>
						<div class="form-group">
							<select id="users" name="users" class="form-control " multiple="multiple" data-placeholder="User" v-model="selectedUser"  
                      style="width: 100%;" >
                      			<option v-for="user in users" :value="user.id">{{user.name}}</option>
          					</select>
						</div>
					</div>  
					<div class="modal-footer justify-content-start" style="text-align:center;">
						<button class="btn btn-primary" @click="createGroupChatRoom">Create Group</button>
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
				users : null,
				name : "",
				selectedUser : []
			}
		},
		ready: function(){
			$('#users').select2({  dropdownCssClass: 'custom-dropdown' });
			$('#users').on('select2:open', function(e){
			    $('.custom-dropdown').parent().css('z-index', 99999);
			});
		},
		mounted(){
			console.log('invitation mounted');
			axios.get('/chat/getUserAvailable')
			.then((response) => {
				this.users = response.data;
			})

		},
		methods : {
			createGroupChatRoom(){

				// if (this.selectedUser.length <= 1) {
				// 	swal("Error", "Select At Least 2 User", "error");
				// 	return;
				// }


				if (this.name == "") {
					swal("Error", "Group Name Cannot Be Empty", "error");
					return;
				}

				let chatType = "2-Group";
				axios.post('/chat/invite/group',{
					'userId' : this.selectedUser,
					'chatType' : "2-Group",
					'name' : this.name
				})
				.then(response => {
					this.$emit('createGroupChatRoom',response.data.chatRoom);
					this.selectedUser = [];
					this.name = "";
					$('#groupInviteModal').modal('hide');
					$('.modal-backdrop').remove();
				});
			}
		}, 
		bind: function () {
        $(this.el)
            .chosen({
                inherit_select_classes: true,
                width: '30%',
                disable_search_threshold: 999
            })
            .change(function(ev) {
                // two-way set
                this.set(this.el.value);
            }.bind(this));
	    },
	    update: function(nv, ov) {
	        // note that we have to notify chosen about update
	        $(this.el).trigger("chosen:updated");
	    }
	}
</script>