<template>
<!-- Modal -->
<div class="modal fade" id="profileReactsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle"><i class=" text-primary fas fa-heart" ></i>  </h5>
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
					<user-lists v-if="!showLoader" v-for="(user,index) in userList" :key="index" :user="user"></user-lists>
				</ul>
			</div>
 
		</div>
	</div>
</div>
</template>
<script type="text/javascript">
	import {eventBus} from  './../../../app';
	import UserLists from './User.vue';

	export default{
		data(){
			return{
				showLoader:true,
				userList:[],
			}
		},
		components:{
			UserLists:UserLists,
		},
		created(){
			eventBus.$on('ShowReactsModal',PostID =>{
				$("#profileReactsModal").modal('show');
				axios.post('/api/post.reacts',{postID:PostID})
				.then(res => {
					this.showLoader=false;
					this.userList=res.data.reacts;
				})
			})
		}
	}
</script>