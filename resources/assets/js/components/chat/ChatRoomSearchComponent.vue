<template>
	<div class="input-group">
		<input type="text" name="search" @keyup.enter="search" v-model="chatRoomName" class="form-control" placeholder="Search...">
		<span class="input-group-btn">
			<button type="submit" name="search" id="search-btn" class="btn btn-flat">
				<i class="fa fa-search"></i>
			</button>
		</span>
	</div>
</template>

<script>
	export default{
		data() {
			return {
				chatRoomName : "",
				chatRooms : null
			}
		},
		mounted(){
			console.log("search mounted");
		},
		methods : {
			search(){
				this.$emit('searchRooms',this.chatRoomName);
			}
		}
	}
</script>