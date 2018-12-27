<template>
	<!-- PRODUCT LIST -->
      <div class="box box-primary" >
        <div class="box-header with-border">
          <chat-room-search-component></chat-room-search-component>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="height: 460px; overflow-y: scroll;">
          <chat-room-list-component :chatRooms="this.chatRooms"></chat-room-list-component>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          <chat-room-action-component @InviteUser="InviteUserModal"></chat-room-action-component>
        </div>
        <!-- /.box-footer -->
        <chat-room-invitation-component @createPersonalChatRoom="createPersonalChatRoom"></chat-room-invitation-component>
        <chat-room-group-invitation-component></chat-room-group-invitation-component>
      </div>
      <!-- /.box -->
</template>

<script>
	import ChatRoomListComponent from './ChatRoomListComponent';
	import ChatRoomSearchComponent from './ChatRoomSearchComponent';
	import ChatRoomActionComponent from './ChatRoomActionComponent';
	import ChatRoomInvitationComponent from './ChatRoomInvitationComponent';
    import ChatRoomGroupInvitationComponent from './ChatRoomGroupInvitationComponent';
	export default {
        props : {
            user : {
                type : Object,
                required : true
            }
        },
        data(){
            return {
                chatRooms : null
            };
        },
        mounted() {
            axios.get('/chat/getChatRoom')
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
        methods: {
        	InviteUserModal: function(){
        		// this.$refs.modal.show();
        	},
            createPersonalChatRoom: function(ChatRoom,exist){
                let name = this.changeChatRoomName(ChatRoom);
                ChatRoom.name = name;
                if(exist == 1){

                }else{
                    this.chatRooms.unshift(ChatRoom);
                }
            },
            changeChatRoomName(chatRoom){
                if (chatRoom.chat_type == '1-Personal') {
                    let name = this.user.name;
                    let names =  chatRoom.name.split("|");
                    for (var i = names.length - 1; i >= 0; i--) {
                        if (names[i] != this.user.id) {
                            name = names[i];
                            return name;
                        }
                    }
                    return name;
                }
            }
        },
        components: {
        	ChatRoomListComponent,
        	ChatRoomSearchComponent,
        	ChatRoomActionComponent,
        	ChatRoomInvitationComponent,
            ChatRoomGroupInvitationComponent
        }
    }
</script>