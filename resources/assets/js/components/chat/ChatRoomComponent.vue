<template>
	<!-- PRODUCT LIST -->
      <div class="box box-primary" >
        <div class="box-header with-border">
          <chat-room-search-component></chat-room-search-component>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <chat-room-list-component :users="this.users"></chat-room-list-component>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          <chat-room-action-component @InviteUser="InviteUserModal"></chat-room-action-component>
        </div>
        <!-- /.box-footer -->
        <chat-room-invitation-component></chat-room-invitation-component>
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
        data(){
            return {
                users : null
            };
        },
        mounted() {
            axios.get('/chat/getUser')
            .then((response) => {
                this.users = response.data;
            });
        },
        methods: {
        	InviteUserModal: function(){
        		// this.$refs.modal.show();
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