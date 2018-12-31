<template>
	<div class="box box-primary direct-chat direct-chat-primary">
        <div class="box-header with-border">
          <h3 class="box-title" ><label v-if="selectedChatRoom !== null">{{selectedChatRoom.name}}</label></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- Conversations are loaded here -->
          <chat-conversation-component :chats="this.chats" :user="this.user" :chatRoom="this.selectedChatRoom" :message="this.message"></chat-conversation-component>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <message-composer-component @sendMessage="sendMessage" :chatRoom="this.selectedChatRoom"></message-composer-component>
        </div>
        <!-- /.box-footer-->
      </div>
      <!--/.direct-chat -->
</template>

<script>
	import MessageComposerComponent from './MessageComposerComponent';
	import ChatConversationComponent from './ChatConversationComponent';

	export default {
		props: {
			user: {
				type : Object,
				required : true
			},
      selectedChatRoom: {
        type : Object
      }
		},
    data(){
      return {
        chats : null,
        message : null,
        activeChatRoom : null
      }
    },
    mounted() {

      this.changeChatRoom(this.selectedChatRoom);

      Echo.private('chat.'+this.user.id)
        .listen('NewMessage', (e) => {
          var chat = e.chat;
          var chatMember  = e.chatMember;
          // this.$emit('messageReceived', chat, chatMember);
          this.messageReceived(chat, chatMember);
        });
    },
    methods : {
      chatRoomClicked(){
        // console.log("test");
      },
      sendMessage(message){
        this.message = message;
      },
      messageReceived(chat, chatMember){

          if(this.selectedChatRoom && chatMember.chat_room == this.selectedChatRoom.chat_room){
            this.sendMessage(chat);
          }else{

          }
      },
      changeChatRoom(selectedChatRoom){
        if (selectedChatRoom == null) {return}

        // this.activeChatRoom = selectedChatRoom;
        axios.get("/chat/getChatHistory/"+selectedChatRoom.chat_room+"/")
        .then((response) => {
            this.chats = response.data;
        });
      }
    },
    component: {
    	MessageComposerComponent,
    	ChatConversationComponent
    },
    watch : {
      selectedChatRoom(selectedChatRoom){
        this.changeChatRoom(selectedChatRoom);
      }
    }
  }
</script>