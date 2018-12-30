<template>
  <!-- <ul class="products-list product-list-in-box"> -->
  <div class="list-group">
    <a class="list-group-item" v-for="(chatRoom,index) in sortedChatRoom" href="#" v-bind:class="{active: isActive == chatRoom.id}" @click="chatRoomClicked(chatRoom, index)">
      <div class="product-img">
        <span class="direct-chat-img bg-blue">
          <i class="fa fa-user" style="padding: 13px 15px;"></i><!-- /.direct-chat-img -->
        </span>
      </div>
      <div style="margin-left: 50px">
        <h4 class="list-group-item-heading" style="font-family: unset;">
          <b>{{chatRoom.name}}</b>
          <span class="pull-right" v-if="chatRoom.unread_messages > 0 ">
            <i class="label bg-green">{{chatRoom.unread_messages}}</i>
          </span>
        </h4>
        <p class="list-group-item-text">{{chatRoom.updated_at}}</p>
      </div>
    </a>
    <!-- /.item -->
  </div>
</template>

<script>
  export default{
    props: {
      user : {
          type : Object,
          required : true
      },
      chatRoom : {
        type : Object
      },
      keyword : {
        type : String,
        default : ""
      }
    },
    data(){
      return {
        isActive : undefined,
        chatRooms : Array,
        selectedChatRoom : null
      }
    },
    mounted() {
      
      Echo.private('invitation.'+this.user.id)
        .listen('ChatInvitation', (e) => {
          var chatMember = e.chatMember;
          chatMember = Object.assign(chatMember, { name : e.chatRoom});
          chatMember = Object.assign(chatMember, { chat_type : e.chatType});
          if (e.chatType == '1-Personal') {chatMember.name = this.changeChatRoomName(chatMember);}
          this.chatRooms.unshift(chatMember);
          // this.$emit('chatRoomInvitation', chatMember);
        });

      Echo.private('chat.'+this.user.id)
        .listen('NewMessage', (e) => {
          var chat = e.chat;
          var chatMember  = e.chatMember;

          for (var i = this.chatRooms.length - 1; i >= 0; i--) {
            if(this.chatRooms[i].chat_room == chatMember.chat_room){
              this.chatRooms[i].updated_at = chatMember.updated_at;
              this.chatRooms[i].unread_messages = chatMember.unread_messages;
            }
          }

        });

      axios.get('/chat/getChatRoom',{
              chatRoom : ""
          })
          .then((response) => {
              this.chatRooms = response.data;
              for (var i = this.chatRooms.length - 1; i >= 0; i--) {
                  if(this.chatRooms[i].chat_type == '1-Personal'){
                      let name = this.changeChatRoomName(this.chatRooms[i]);
                      this.chatRooms[i].name = name;
                  }
              }
          });
    },
    methods : {
      chatRoomClicked: function(chatRoom, index){

        if (chatRoom.unread_messages > 0) {
          axios.post('/message/read/all',{
            id : chatRoom.id
          }).then(e => {
            this.chatRooms[index].unread_messages = 0;
          })
        }

        this.isActive = chatRoom.id;
        this.selectedChatRoom = chatRoom;
        this.$emit('chatRoomClicked',chatRoom);
      },
      changeChatRoomName(chatRoom){
          let name = "";
          if (chatRoom.chat_type == '1-Personal') {
              name = this.user.name;
              let names =  chatRoom.name.split("|");
              for (var i = names.length - 1; i >= 0; i--) {
                  if (names[i] != name) {
                      name = names[i];
                      return name;
                  }
              }
          }
          return name;
      }
    },
    watch : {
      chatRoom(val) {
        if (val.type == '1-Personal') {
          let name = this.changeChatRoomName(val.chatRoom);
          val.chatRoom.name = name;
          if(val.exist == 1){

          }else{
              this.chatRooms.unshift(val.chatRoom);
          }
        }else{
          this.chatRooms.unshift(val.chatRoom);
        }
      },
      keyword(val){
        axios.get('/chat/getChatRoom/'+val+"/")
        .then((response) => {
          this.chatRooms = response.data;
        });
      }
    },
    computed : {
      sortedChatRoom() {
        return _.sortBy(this.chatRooms, [(chatRoom) => {
          return chatRoom.updated_at;
        }]).reverse();
      }
    }
  }
</script>