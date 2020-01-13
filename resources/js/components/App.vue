<template>
 			<div>
 			<keep-alive v-if="this.$route.name=='UserProfile' || this.$route.name=='UserEdit' ">
  				<router-view :key="$route.path"></router-view>
 			</keep-alive>
 			<router-view v-else :key="$route.path" ></router-view>

</div>
</template>
<script>
	import { eventBus } from '../app'; 
export default{
	data(){
		return{
			loadDOM:false,
		}
	},
	created(){

		if (this.$store.state.token!=null) {
				this.$store.dispatch('user')
				.then(response => {
					this.loadDOM=true;
					window.Echo.private('notifying.'+this.$store.state.user.user.id)
						.listen('Notify' ,(noti) => {
					 
						eventBus.$emit('Notifications',noti.notification);
					});
					window.Echo.private('message.'+this.$store.state.user.user.id)
					.listen('Message' ,(e) => {

					eventBus.$emit('rec_'+e.message.senderMsgInfo.user.username,e);
					eventBus.$emit('sent',e);
					if (this.$route.name!='chatUser') {
						let data={
							heading:'New Message From '+e.message.senderMsgInfo.user.firstname,
							html:'<p>'+e.message.text+'</p><a href="/chats/'+e.message.senderMsgInfo.user.username+'" class="btn btn-primary   mt-10">Reply</a>',
							type:'jq-toast-primary'
						}
						this.$store.dispatch('Toast',data);
					}

					})
				})
				.catch(err => {
					console.log(err);
				})
		}

			if (window.screen.availWidth < 500) {
				$('.hk-pg-wrapper').css({
					'min-height': '546px !important',
				}); 
			}
 		
	}
}
</script>
<style >
	.pointer{
		cursor: pointer;
	}

		.bb1px{
		border-bottom: 1px solid #eaecec;
	}
</style>
 