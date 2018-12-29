<template>
	<!-- PRODUCT LIST -->
      <div class="box box-primary" >
        <div class="box-header with-border">
          <chat-room-search-component @searchRooms="searchRooms"></chat-room-search-component>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="height: 460px; overflow-y: scroll;">
          <chat-room-list-component :user="this.user" :chatRoom="this.chatRoom" :keyword="this.searchKeyWord" @chatRoomClicked="chatRoomClicked"></chat-room-list-component>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          <chat-room-action-component @InviteUser="InviteUserModal" @InviteGroup=""></chat-room-action-component>
        </div>
        <!-- /.box-footer -->
        <chat-room-invitation-component @createPersonalChatRoom="createPersonalChatRoom"></chat-room-invitation-component>
        <chat-room-group-invitation-component @createGroupChatRoom="createGroupChatRoom"></chat-room-group-invitation-component>
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
                chatRoom : null,
                searchKeyWord : null
            };
        },
        mounted() {
            
        },
        methods: {
        	InviteUserModal: function(){
        		// this.$refs.modal.show();
        	},
            InviteGroupModal: function(){
                // this.$refs.modal.show();
            },
            createPersonalChatRoom: function(ChatRoom,exist){

                this.chatRoom = {chatRoom : ChatRoom, exist : exist, type : '1-Personal'};
            },
            createGroupChatRoom: function(ChatRoom){
                this.chatRoom = {chatRoom : ChatRoom, type : '2-Group'};
            },
            searchRooms(keyword){
                console.log('search chat room with name ' + keyword);
                this.searchKeyWord = keyword;
            },
            chatRoomClicked(chatRoom){
                this.$emit('chatRoomClicked', chatRoom);
            },
            chatRoomInvitation(chatMember){
                console.log('change name invitation');
                console.log(chatMember);
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