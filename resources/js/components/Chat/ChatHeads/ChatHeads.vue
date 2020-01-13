<template>
<div class="chatapp-left" style="min-height: -webkit-fill-available;
    background: #fff;">
	<header class="text-center">
 
		<h3 align="center" class="text-primary">Chats  </h3>
 
	</header>
	<form role="search" class="chat-search">
		<div class="input-group">
			<div class="input-group-prepend">
				<i class="fas fa-search"></i>
			</div>
			<input type="text" class="form-control" placeholder="Search">
		</div>
	</form>
	<div class="chatapp-users-list">
		<chats-user v-for="user,index in chats" :key="index" :user="user" @click="userclick"></chats-user>
	</div>
</div>
</template>
<script type="text/javascript">
	import { eventBus } from '../../../app'; 
	import ChatsUser from './ChatsUser.vue';
	export default{
		components:{
			ChatsUser 
		},
		props:['chatheads'],
		data(){
			return{
				chats:null,
			}
		},
		methods:{
			toggleclass(){
				eventBus.$emit('toggle');
			},
			userclick(){
				//console.log('s')
				
			}
		},
		created(){
			if (this.$store.state.chats==null) {
				this.$store.dispatch('chats')
				.then(chats => {
					this.chats=chats.data;
				})
			}else{
				this.chats=this.$store.state.chats;
			}
				

			eventBus.$on('refreshChatHeads',msg => {
				this.$store.dispatch('chats')
				.then(chats => {
					this.chats=chats.data;
				})
			})
		}
	}
</script>