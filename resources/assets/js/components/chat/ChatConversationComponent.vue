<template>
	<div class="direct-chat-messages" style="height: 510px" ref="chatConversation">
    <!-- Message. Default to the left -->
    <div v-for="chat in chats">
      <div v-if="chat.created_by != user.id">
        <div class="direct-chat-msg">
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-name pull-left">{{chat.name}}</span>
            <span class="direct-chat-timestamp pull-right">{{chat.created_at}}</span>
          </div>
          <!-- /.direct-chat-info -->
          <span class="direct-chat-img bg-blue">
              <i class="fa fa-user" style="padding: 13px 15px;"></i><!-- /.direct-chat-img -->
          </span>
          <!-- /.direct-chat-img -->
          <div class="direct-chat-text">
            {{chat.chat_text}}
          </div>
          <!-- /.direct-chat-text -->
        </div>
        <!-- /.direct-chat-msg -->
      </div>
      <div v-else>
        <div class="direct-chat-msg right">
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-name pull-right">{{chat.name}}</span>
            <span class="direct-chat-timestamp pull-left"> {{chat.created_at}}</span>
          </div>
          <!-- /.direct-chat-info -->
          <span class="direct-chat-img bg-blue">
              <i class="fa fa-user" style="padding: 13px 15px;"></i><!-- /.direct-chat-img -->
          </span>
          <!-- /.direct-chat-img -->
          <div class="direct-chat-text">
            {{chat.chat_text}}
          </div>
          <!-- /.direct-chat-text -->
        </div>
        <!-- /.direct-chat-msg -->
      </div>
    </div>
    
  </div>
  <!--/.direct-chat-messages-->
</template>

<script >
	export default{
    props : {
      chats : {
        type : Array,
        default : []
      },
      user : {
        type : Object,
        required : true
      },
      message : {
        type : Object,
        default : ""
      },
      chatRoom: {
        type : Object
      }
    },
		mounted(){
		},
    methods : {
      scrollToBottom(){
        setTimeout(() => {
          var chatConversation = this.$refs.chatConversation;
          chatConversation.scrollTop = chatConversation.scrollHeight - chatConversation.clientHeight;
        }, 50);
      }
    },
    watch : {
      chats(val){
        this.scrollToBottom();
      },
      message(val){
        this.chats.push(val);
      },
      chatRoom(val){
        // console.log(this.chats);
      }
    }
	}
</script>