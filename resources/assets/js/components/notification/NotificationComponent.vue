<template>
	<div class="tab-pane" id="control-sidebar-notification-tab">
	  <h3 class="control-sidebar-heading">
	    <i class="fa fa-bell fa-fw"></i>
	    <span>&nbsp;</span>
	    <span> Notification</span>
	    <a @click="ReadAllNotification">
		    <span class="pull-right">
		      <i class="fa fa-book fa-fw"></i>
		    </span>
	    </a>
	  </h3>
	  
	  <ul class="control-sidebar-menu" v-for="(notification, index) in this.notifications">
	    <li>
	      <a href="#" v-bind:style="notification.is_read == 0 ? {'background-color':'#2c3b41'} : {'background-color':'#222d32'}" @click="NotificationClicked(notification, index)">
	        <i class="menu-icon fa fa-user bg-red"></i>
	        <div class="menu-info">
	          <h4 class="control-sidebar-subheading">
	            {{ notification.notif_creator }}
	          </h4>
	          <p>{{ notification.created_at }}</p>
	          <p>{{ notification.notification_text }}</p>
	        </div>
	      </a>
	    </li>
	  </ul>

	  <a href="#" @click="ShowMoreNotification">
	  	<span style="text-align: center; ">
		  <h3 class="control-sidebar-heading">
		    <b style="color: #3c8dbc">Show More Notifications</b>  
		  </h3>
		</span>
	  </a>
	</div>
	<!-- tab-pane -->
</template>

<script>
	export default{
		props : {
			user :{
				type : Object,
				required : true
			}
		},
		data(){
			return {
				date : Date,
				notifications : [],
				notification : null,
				lastId : null
			}
		},
		mounted(){
			this.date = new Date();
			this.getNotification();

			Echo.private(`notification.${this.user.id}`)
				.listen('NewNotification', (e) => {
					this.NewNotification(e.notification, e.notificationReveiver, e.user);
				})
		},
		methods : {
			NotificationClicked(notification, index){


				if (notification.is_read == 0) {
					axios.post('/notification/read',{
		           'id' : notification.notif_receiver_id
			        })
					.then(e => {
						if (e.data.is_read == 1) {
							notification.is_read = 1;
							this.$set(this.notifications, index, notification);
						}
					});
				}

				let url = "javascript:void(0)";
				if(notification.modul == '1-Chat'){
					url = "/chat/";
					window.location.href = url;
				}else if(notification.modul == '2-Survey'){
					url = "/assessment/";
					window.location.href = url+notification.modul_id;
				}else if(notification.modul == '3-Quisioner'){

				}else if(notification.modul == '4-Schedule'){
					url = "/calendar/";
					window.location.href = url;
				}else if(notification.modul == '5-Task'){
					url = "/assessment/";
					window.location.href = url+notification.modul_id+"/task";
				}
			},
			ReadAllNotification(){
				axios.post('/notification/read/all',{
	           	'userId' : this.user.id
		        })
				.then(e => {
					// console.log(e.data.notification_readed);
					if (e.data.notification_readed > 0) {
						for (var i = this.notifications.length - 1; i >= 0; i--) {
							if(this.notifications[i].is_read==0){
								this.notifications[i].is_read = 1;
							}
						}
					}

				});
			},
			ShowMoreNotification(){
				this.getNotification();
			},
			getNotification(){
				let dateString = `${1900+this.date.getYear()}-${this.date.getMonth()+1}-${this.date.getDate()} ${this.date.getHours('HH')}:${this.date.getMinutes()}:${this.date.getSeconds()}`;

				axios.get(`/notification/getNotification/${dateString}/`)
					.then((response) => {
						if (this.notifications.length <= 0) {
							this.notifications = response.data;
						} else {
							this.notifications = this.notifications.concat(response.data);
						}

						if(this.notifications.length > 0){
							
							var tmp = this.notifications[this.notifications.length-1];
							this.date = new Date(tmp.created_at);
						}
					});
			},
			NewNotification(notification, notificationReceiver, user){
				var notification = {
					created_at : notificationReceiver.created_at,
					is_read : notificationReceiver.is_read,
					modul : notification.modul,
					modul_id : notification.modul_id,
					notif_creator : user.name,
					notif_id : notification.id,
					notif_receiver_id : notificationReceiver.id,
					notification_text : notification.notification_text
				}

				this.notifications.unshift(notification);
			}
		}
	}
</script>