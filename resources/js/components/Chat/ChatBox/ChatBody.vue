<template>
	<div ref="chatBody" class="chat-body" style="overflow-y: scroll;" :style="(mobile) ? 'height: 546px;' : 'height: 747px;'" >
		<div >
			<ul class="list-unstyled">
				<li class="media"  v-for="(message,index) in messages" :key="index" :class="(message.sender==user.id) ? 'sent' : 'received'">
					<div class="avatar">
						<template  v-if="(message.reciver==user.id)">
							<img v-if="message.senderMsgInfo.user.images!=null" :src="message.senderMsgInfo.user.images" alt="user" class="avatar-img rounded-circle">
							<span v-else class="avatar-text rounded-circle" :class="'avatar-text-'+message.senderMsgInfo.user.avatar">
								<span class="initial-wrap">
									<span>{{ message.senderMsgInfo.user.firstname.charAt(0)+message.senderMsgInfo.user.lastname.charAt(0) }}</span>
								</span>
							</span>
						</template>
					</div>
					<div class="media-body">
						<div class="msg-box">
							<div>
								<p>{{message.text}}</p>
								<span class="chat-time">{{message.created_at}}</span>
								<div class="arrow-triangle-wrap">
									<div class="arrow-triangle " :class="(message.sender==user.id) ? 'left' : 'right'"></div>
								</div>
							</div>
						</div>
		 
					</div>
				</li>
			 
			</ul>
		</div>
	</div>
</template>
<script type="text/javascript">
	import { eventBus } from '../../../app'; 
	export default{
		props:['chat','chatuser'],
		data(){
			return {
				messages:null,
				mobile:false,
			}
		},
		computed:{
			user(){
				return this.$store.state.user.user;
			},
	
		},
		methods:{
			scrollToBottom(){
				if (this.$route.name=='chatUser') {
					setTimeout(()=>{
						this.$refs.chatBody.scrollTop= this.$refs.chatBody.scrollHeight - this.$refs.chatBody.clientHeight;
					},100);
				}
				else{
					return false;
				}	 
			}
		},
		created(){
			this.scrollToBottom();
			this.messages=this.chat;
			eventBus.$on('sent',(msg) => {
				this.messages.push(msg.message);
				this.scrollToBottom();
			})

			if (window.screen.availWidth < 500) {
				this.mobile=true;
				$('.hk-pg-wrapper').css({
					'min-height': '546px !important',
				}); 
			}
	
		},
		mounted(){
			//console.log(this.chatuser.id);
/*			if (this.$route.name=='chatUser') {
			      window.Echo.private('message.'+this.user.id)
                                .listen('Message' ,(e) => {
                                    this.messages.push(e.message);
                                    eventBus.$emit('rec_'+e.message.senderMsgInfo.user.username,e);
                                    this.scrollToBottom();
                                    console.log('msg rec on body')
                                    console.log(this.$route.name);
                                })
                                }*/
		},
		destroyed(){
	 
      this.$destroy();
 
		}
	}
</script>