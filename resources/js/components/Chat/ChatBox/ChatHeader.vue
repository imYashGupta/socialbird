<template>
		<header>
		<a id="back_user_list" href="javascript:void(0)" @click="returnChats()" class="back-user-list">
			<i class="material-icons">
			arrow_back_ios
			</i>
		</a>
		<div class="media">
			<div class="media-img-wrap">
				<div class="avatar">
					<img v-if="chatUser.images!=null" :src="chatUser.images" alt="user" class="avatar-img rounded-circle">
					<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+chatUser.avatar">
						<span class="initial-wrap">
							<span>{{ chatUser.firstname.charAt(0)+chatUser.lastname.charAt(0) }}</span>
						</span>
					</span>
				</div>
				<span class="badge badge-success badge-indicator"></span>
			</div>
			<div class="media-body">
				<div class="user-name">{{chatUser.fullname}}</div>
				<div class="user-status">online</div>
			</div>
		</div>
		<div class="chat-options-wrap">
			
			<a href="javascript:void(0)" ><i class="material-icons">
				more_vert
			</i></a>
		</div>
	</header>
</template>
<script>
	import { eventBus } from '../../../app'; 
	export default{
		props:['user'],
		data(){
			return{
				chatUser:this.user
			}
		},
		methods:{
			returnChats(){
				$(".chatapp-wrap").removeClass('chatapp-slide');
				this.$router.push('/chats')
			}
		}
	}
</script>