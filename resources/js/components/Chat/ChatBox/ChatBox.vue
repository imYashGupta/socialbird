<template>
<div class="chatapp-right" style="left: 0;right:0;">
	<template v-if="chatLoaded">
		<chat-header :user="user"></chat-header>
		<chat-body :chat="chat" :chatuser="user"></chat-body>
		<message-composer :user="user"></message-composer>
	</template>
	<template v-else>
		<div class="text-center">
			<div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
	</template>
</div>
</template>
<script>
	import { eventBus } from '../../../app'; 

	import ChatHeader from './ChatHeader.vue';
	import ChatBody from './ChatBody.vue';
	import MessageComposer from './MessageComposer.vue';
	export default{
		data(){
			return{
				chatLoaded:false,
				id:this.$route.params.id,
				chat:null,
				user:null,
			}
		},
		components:{
			ChatHeader,ChatBody,MessageComposer
		},
		created(){
			
			
			//console.log('class remove')
			var username=this.$route.params.id;
			axios.post('/api/chat.conversation',{username})
			.then(response => {
				$("#wrap").addClass('chatapp-slide');
				this.user=response.data.user;
				this.chat=response.data.conversation;
				this.chatLoaded=true;
				//console.log(response.data.conversation)
	
			})
			.catch(er => {
				//this.$router.push('/404')
			})


		}
	}
</script>
<style type="text/css" scoped="">
	.text-center{
		margin-top: 250px;
	}
</style>