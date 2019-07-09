<template>	
	<span class="pull-right" >
	  <i class="label bg-green">{{this.unread}}</i>
	</span>
</template>

<script>
	export default{
		props : {
			user : {
		        type : Object,
		        required : true
		    },
		    surveyId : {
		        type : Number,
		        required : true
		    }
		},
		data(){
	      return {
	        chatRoom : Object,
	        unread : 0,
	      }
	    },
	    mounted(){

	    	Echo.private('chat.'+this.user.id)
	        .listen('NewMessage', (e) => {
	          var chat = e.chat;
	          var chatMember  = e.chatMember;
	          
	            if(this.chatRoom.id == chatMember.chat_room){
	              this.chatRoom.updated_at = chatMember.updated_at;
	              this.unread = chatMember.unread_messages;
	              
	            }
	        });

	        axios.get('/assessment/getChatRoom/'+this.surveyId)
	          .then((response) => {
	          	// console.log(response)
	          	this.chatRoom = response.data[0];
	          	this.unread = this.chatRoom.unread_messages;
	          	console.log(this.chatRoom);
	              // for (var i = this.chatRoom.length - 1; i >= 0; i--) {
	              	// console.log(this.chatRoom[i])
	              // }
	          });
	    }
    }
</script>
