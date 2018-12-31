<template>
	<div class="row">
    <div class="col-md-8">
      <chat-component :user="this.user" :selectedChatRoom="this.selectedChatRoom"></chat-component>
    </div>
    <!-- col-md-9 -->

    <div class="col-md-4">
      <chat-room-component :user="this.user" @chatRoomClicked="charRoomClicked"></chat-room-component>
    </div>
    <!-- col-md-3 -->
  </div>
</template>

<script>
	export default{
		props: {
			user: {
				type : Object,
				required : true
			}
		},
		data() {
			return {
				selectedChatRoom : null,
			}	
		},
		mounted(){
			
		},
		methods : {
			charRoomClicked(selectedChatRoom){
				this.selectedChatRoom = selectedChatRoom;
			}
		}
	}
</script>