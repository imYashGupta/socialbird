<template>
	<div class="container-fluid">
		<loader v-if="false"></loader>
		<!-- Row -->
		<div class="row" v-else>
			<div class="col-xl-12 pa-0">
				<div class="chatapp-wrap " id="wrap">
					<template >
					<chat-heads></chat-heads>
						<router-view></router-view>
					</template>
					
					
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	import { eventBus } from '../../app'; 

	import ChatHeads from './ChatHeads/ChatHeads.vue';
	import ChatBox from './ChatBox/ChatBox.vue';
	import Loader from './../Loader/FullScreen.vue'
	export default{
		components:{
			ChatHeads,ChatBox,Loader
		},
		data(){
			return {
				chatHeads:[],
				loading:true,
				toggle:false,
			}
		},
		methods:{
			ChatHeads(){
				return new Promise((resolve,reject) => {
					axios.post('/api/chat.heads')
					.then(doneCallbacks=>{
						resolve(doneCallbacks)
						this.chatHeads=doneCallbacks.data;
					})
					.catch(error => {
						reject(error);
					})
				})
			}
		},
		created(){ 
			eventBus.$on('userSelected',() =>{
				this.toggle=true;
				$(".chatapp-wrap").addClass('chatapp-slide');

			})
			 
		},
		mounted(){
			
		}
	}
</script>