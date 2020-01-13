<template>
<div>
	<router-link @click="selectUser(chatUser.senderInfo)" :to="'/chats/'+chatUser.senderInfo.user.username"   class="media">
		<div class="media-img-wrap">
			<div class="avatar">
				<img v-if="chatUser.senderInfo.user.images!=null" :src="chatUser.senderInfo.user.images" alt="user" class="avatar-img rounded-circle">
				<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+chatUser.senderInfo.user.avatar">
					<span class="initial-wrap">
						<span>{{ chatUser.senderInfo.user.firstname.charAt(0)+chatUser.senderInfo.user.lastname.charAt(0) }}</span>
					</span>
				</span>
			</div>
			<span class="badge badge-warning badge-indicator"></span>
		</div>
		<div class="media-body">
			<div>
				<div class="user-name">{{ chatUser.senderInfo.user.fullname }}</div>
				<div class="user-last-chat">
					<span style="font-size: 12px;" class="mr-5">
						<i :class="chatUser.senderInfo.sender ? 'fas fa-arrow-left text-primary' : 'fas fa-arrow-right text-success'"></i>
					</span>
				 {{ chatUser.text }}</div>
			</div>
			<div>
				<div class="last-chat-time block">{{ chatUser.created_at }}</div>
				<!-- <div class="badge badge-success badge-pill">15</div> -->
			</div>
		</div>
	</router-link>
	<div class="chat-hr-wrap">
		<hr>
	</div>
</div>
</template>
<script >
	import { eventBus } from '../../../app'; 

	export default{
		props:['user'],
		data(){
			return {
				chatUser:this.user
			}
		},
		methods:{
			selectUser(convoID){
			 
			 
				eventBus.$emit('userSelected');
			}
		},
		created(){
	 		 
			eventBus.$on('sent_'+this.chatUser.senderInfo.user.username,msg => {
				let message=msg.message
			 
				this.chatUser=message;
			});

			eventBus.$on('rec_'+this.chatUser.senderInfo.user.username,msg => {
				let message=msg.message
				this.chatUser.text=message.text;
				this.chatUser.senderInfo.sender=false;
		 

			});
		}
	}
</script>