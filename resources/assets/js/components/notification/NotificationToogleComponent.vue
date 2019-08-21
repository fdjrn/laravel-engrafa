<template>
	<li class="treeview" data-toggle="control-sidebar">  
	    <a href="#control-sidebar-notification-tab" data-toggle="tab">
	        <i class="fa fa-bell"></i>
	        <span>Notifications</span>
	        <span class="pull-right-container">
	          <small class="label pull-right bg-green">{{this.unread}}</small>
	        </span>
	    </a>
	</li>
</template>	

<script>
	export default {
		props : {
			user : {
				type : Object,
				required : true
			}
		},
		data (){
			return {
				unread : 0
			}
		},
		mounted(){
			
			this.getUnreadNotification();

			Echo.private(`ReadNotification.${this.user.id}`)
				.listen('ReadNotification', e => {
					
					if(e.readType == 'read'){
						this.unread--;
					}else{
						this.unread = 0;
					}
				});

			Echo.private(`notification.${this.user.id}`)
				.listen('NewNotification', (e) => {
					this.unread++;
				})
		},
		methods : {
			getUnreadNotification() {
				axios.get(`/notification/getUnreadNotification`)
				.then((response) => {
					this.unread = response.data
				});
			}
		}
	}
</script>