<template>
<div class="card card-profile-feed border-top-0 rounded-top-0 shadow-sm shadow-hover-lg">
	<div class="text-center" v-if="loading">
		<div class="spinner-grow text-dark" role="status">
			<span class="sr-only">Loading...</span>
		</div>
	</div>
	<div class="card-body pb-0">
		<button v-if="!loading " class="btn btn-light btn-sm btn-block mb-25" @click="closeComment">Hide comments</button>
		<div v-for="(comment,index) in comments" :key="index">
			<div class="media pb-3" :class="{'mb-3 bb1px':(index!=comments.length-1)}">

				<div class="media-img-wrap d-flex mr-10">
					<div class="avatar avatar-sm">
						<img v-if="comment.user.images!=null" :src="comment.user.images" alt="user" class="avatar-img rounded-circle">
						<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+comment.user.avatar">
							<span class="initial-wrap">
								<span>{{ comment.user.firstname.charAt(0)+comment.user.lastname.charAt(0) }}</span>
							</span>
						</span>
					</div>
				</div>

				<div class="media-body">
					<div class="text-capitalize font-14 font-weight-500 text-dark">{{ comment.user.firstname+' '+comment.user.lastname }}</div>
					<div class="font-15"><p>{{ comment.comment }}</p></div>
					<div class="d-flex mt-10">
						<span class="font-14 text-light">{{ comment.created_at }}</span>
						<span class="ml-2 mr-2">·</span>
						<a href="#" class="font-14 text-light text-capitalize font-weight-500" @click.prevent="editComment(index,comment)">edit</a>
						<span class="ml-2 mr-2">·</span>

						<a href="#" class="font-14 text-light text-capitalize font-weight-500" @click.prevent="deleteComment(index,comment.id)">Delete</a>
					</div>

				</div>
			</div>

		</div>
		<button @click="loadMoreComments" v-if="showLoadMoreBtn" class="btn btn-light btn-sm btn-block mb-25 mt-3">Load More</button>
	</div>
	<comment-composer v-if="!loading" :index="postIndex" :post="post"></comment-composer>
	<comment-modal ></comment-modal>
</div>
</template>
<script>
	import { eventBus } from '../../../app';
	import CommentComposer from './../../Posts/Comments/CommentComposer.vue';
	import CommentEditModal from './../../Posts/Comments/CommentEditModal.vue';
	export default{
		props:['post',"postIndex","type"],
		data(){
			return{
				loading:true,
				comments:null,
				currentPage:1,
				totalComments:null,
				showLoadMoreBtn:false
			}
		},
 		components:{
			CommentComposer:CommentComposer,
			CommentModal:CommentEditModal
		},
		methods:{
			closeComment(){
				eventBus.$emit('hideComment',this.post);
			},
			editComment(index,comment){
		 		$('#commentEditModal').modal('show');
		 		eventBus.$emit('commentEdit',{comment:comment,index:index});
			},
			updateComment(commentText,index){
				this.comments[index].comment=commentText;
		 		$('#commentEditModal').modal('hide');
				
			},
			deleteComment(index,id){
				swal({
				  	title: "Are you sure?",
				  	text: "Once deleted, you will not be able to recover this imaginary file!",
				  	icon: "warning",
				  	buttons: true,
				  	dangerMode: true,
				})
				.then((willDelete) => {
				  	if (willDelete) {
				  		axios.post('/api/comment.delete',{commentId:id})
						.then(res =>{
							this.comments.splice(index,1);
							swal("Poof! Your imaginary file has been deleted!", {
				      			icon: "success",
				    		});	
						})
						.catch(error => {
							console.log(error);
						})
				  	} 
				  	else {
				    	swal("Your imaginary file is safe!");
				  	}
				});
			},
			loadMoreComments(){
				if (this.comments.length!=this.totalComments) {
					axios.post('/api/comment.fetch?page='+this.currentPage,{post_id:this.post.id})
					.then(response =>{
						this.currentPage=this.currentPage+1;
						for (var i = 0; i < response.data.comments.data.length; i++ )  {
							this.comments.push(response.data.comments.data[i]);
						}
						if (this.comments.length < this.totalComments) {
							this.showLoadMoreBtn=true;
						}
						else{
							this.showLoadMoreBtn=false;
						}
						
					})
					.catch(error => {
						console.log(error);
					});
						
				}
			}
		},
		created(){
			axios.post('/api/comment.fetch',{post_id:this.post.id})
			.then(response =>{
				this.loading=false;
				this.currentPage=this.currentPage+1;
				this.comments=response.data.comments.data;
				this.totalComments=response.data.comments.total;
				if (this.comments.length < this.totalComments) {
					this.showLoadMoreBtn=true;
				}
			})
			.catch(error => {
				console.log(error);
			});
			eventBus.$on('commentCreated',(data) => {
				if (this.type=='profile') {
					//console.log(this.type);
					this.comments.unshift(data.comment);
					eventBus.$emit('backToPost');
				 	
				}
			})

			eventBus.$on('commentUpdated',(data) => {
				this.updateComment(data.comment,data.index);
			})
		},
	
	}
</script>
<style scoped="" type="text/css">
	.bb1px{
		border-bottom: 1px solid #eaecec;
	}
</style>