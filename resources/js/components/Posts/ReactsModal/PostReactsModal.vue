<template>
<!-- Modal -->
<div class="modal fade" id="reactsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle"><i class=" text-primary fas fa-heart" ></i> {{ModalTitle}}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body pl-0 pr-0">
				<ul class="list-group list-group-flush">
					<div class="text-center" v-if="showLoader">
						<div class="spinner-grow text" style="width: 3rem; height: 3rem;" role="status">
							<span class="sr-only">Loading...</span>
						</div>
					</div>
					<user-list v-if="!showLoader" v-for="(user,index) in userList" :key="index" :user="user"></user-list>
				</ul>
			</div>
 
		</div>
	</div>
</div>
</template>
<script>
	import { eventBus } from '../../../app';
	import UserList from './UserLists.vue';
	export default{
		data(){
			return{
				showLoader:true,
				userList:[],
				ModalTitle:''
			}
		},
		components:{
			UserList:UserList,
		},
		created(){
			eventBus.$on('showReactsFor',post => {
				axios.post('/api/post.reacts',{postID:post.id})
				.then(res => {
					this.showLoader=false;
					this.userList=res.data.reacts;
					this.ModalTitle=post.user.firstname+' '+post.user.lastname+"'s post reacts("+this.userList.length+")";
				})
				.catch()
			})
		},
		beforeDestroy(){
   			 eventBus.$off('showReactsFor')
  		}
	}
</script>