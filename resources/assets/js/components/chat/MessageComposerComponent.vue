<template>
  <div class="form-group">
    <!-- <span class="input-group-btn">
      <button type="button" class="btn btn-primary btn-flat">
        <i class="fa fa-plus"></i>
      </button>
      <button type="button" class="btn btn-primary btn-flat">
        <i class="fa fa-smile-o"></i>
      </button>
      <button type="button" class="btn btn-primary btn-flat">
        <i class="fa fa-microphone"></i>
      </button>
    </span> -->
    
    <input type="text" name="sendMessage" @keyup.enter="sendMessage" v-model="message" class="form-control" placeholder="Type Message ...">
  </div>
</template>

<script>
  export default {
    props : {
      chatRoom : {
        type : Object
      }
    },
    data() {
      return {
        message : "",
        messageSend : null
      }
    },
    mounted(){

    },
    methods : {
      sendMessage(){
        if (this.message && this.chatRoom) {
          axios.post('/message',{
            'chatRoomId' : this.chatRoom.chat_room,
            'chatRoomMemberId' : this.chatRoom.id,
            'message' : this.message
          })
          .then(response => {
            this.messageSend = response.data;

            this.$emit('sendMessage', this.messageSend);
            
            this.message = "";
          });
        }
      }
    }
  }
</script>