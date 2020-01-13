<template>
<footer>
	<div class="input-group">
		<div class="input-group-prepend">
			<div class="btn-file  btn btn-light">
				<div class="btn-icon-wrap">
					<!-- <span class="feather-icon"><i data-feather="paperclip"></i></span>
					<input type="file"> -->
				</div>
			</div>
		</div>
		<input v-model="text" @keydown.enter.prevent="sendMessage" type="text" id="input_msg_send_chatapp" name="send-msg" class="input-msg-send form-control" placeholder="Type something">
		<div class="input-group-append">
			<button @click="sendMessage" type="button" class="btn  btn-light   "  >
				<i v-if="!loading" class="material-icons">send</i><div v-else class="spinner-grow spinner-grow-sm" role="status">
				<span class="sr-only">Loading...</span>
			</div>
			</button>
			
		</div>
	</div>
</footer>
</template>
<script type="text/javascript">
	import { eventBus } from '../../../app'; 

	export default{
		props:["user"],
		data(){
			return{
				to:this.user,
				text:'',
				loading:false
			}
		},
		methods:{
			sendMessage(){
			 	
				if (this.text!='') {
					this.loading=true;
					axios.post('/api/chat.send',{text:this.text,username:this.to.username})
					.then(res => {
						this.text='';
						eventBus.$emit('sent',res.data);
						this.loading=false;
						if (res.data.first) {
							eventBus.$emit('refreshChatHeads');
						}
						//console.log(res.data)
						eventBus.$emit('sent_'+this.to.username,res.data);
					})
				}
				else{
					return false;
				}
			}
		}
	}
</script>