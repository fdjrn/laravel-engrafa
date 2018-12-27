<template>
	<div class="box box-primary direct-chat direct-chat-primary">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- Conversations are loaded here -->
          <chat-conversation-component></chat-conversation-component>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <message-composer-component></message-composer-component>
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
			}
		},
        mounted() {
        },
        component: {
        	MessageComposerComponent,
        	ChatConversationComponent
        }
    }
</script>