<template>
	<div>
		<div class="modal fade" id="inviteModal">
			<div class="modal-dialog">
				<div class="modal-content">
						<div class="modal-header">
							Invite User
						</div>
						<div class="modal-body">
							
							<div class="form-group">
								<select id="users" name="users" class="form-control " data-placeholder="User" v-model="selectedUser" 
	                      style="width: 100%;" >
	                      			<option v-for="user in users" :value="user.id">{{user.name}}</option>
	          					</select>
							</div>
						</div>  
						<div class="modal-footer justify-content-start" style="text-align:center;">
							<button class="btn btn-primary" @click="createPersonalChatRoom">Invite</button>
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
				selectedUser : 3
			}
		},
		ready: function(){
			$('select').select2({  dropdownCssClass: 'custom-dropdown' });
			$('select').on('select2:open', function(e){
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
			createPersonalChatRoom(){
				let chatType = "1-Personal";
				axios.post('/chat/invite',{
					'userId' : this.selectedUser,
					'chatType' : "1-Personal"
				})
				.then(response => {
					this.$emit('createPersonalChatRoom',response.data.chatRoom,response.data.exist);
					$('#inviteModal').modal('hide');
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