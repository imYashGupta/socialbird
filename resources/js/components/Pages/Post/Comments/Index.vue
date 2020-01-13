<template>
<div>
	<template v-if="DOMLoaded">
		<div class="card card-profile-feed border-top-0 rounded-top-0" >
			<div class="card-body pb-0">
				<button class="btn btn-light btn-sm btn-block mb-25" @click="hideComments">Hide comments</button>
				
				<comment v-for="(comment,index) in comments" :key="comment.id"  :comment="comment" :total="comments.length"></comment>
				<button v-if="commentsInfo.current_page!=commentsInfo.last_page" @click="loadMoreComments()" class="btn btn-light btn-sm btn-block mb-25">Load More</button>
			</div>
			<div class="card-footer">
				<div class="media w-100 align-items-center">
					<div class="media-img-wrap d-flex mr-15">
						<div class="avatar avatar-xs">
							<img v-if="user.images!=null" :src="user.images" alt="user" class="avatar-img rounded-circle">
							<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+user.avatar">
								<span class="initial-wrap">
									<span>{{ user.firstname.charAt(0)+user.lastname.charAt(0) }}</span>
								</span>
							</span>
						</div>
					</div>
					<div class="media-body">
						<textarea onfocus="" @keydown.enter.prevent="createComment()" v-model="commentText"  class="form-control filled-input bg-transparent" rows="1" placeholder="Leave a comment..."></textarea>
					</div>
				</div>
			</div>
		</div>
	</template>
	<template v-else>
		<div class="d-flex justify-content-center mt-25">
			<div class="spinner-grow" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
	</template>
</div>
</template>
<script type="text/javascript">
	import {eventBus} from './../../../../app';
	import {helper} from './../../../../helper';
	import comment from './Comment.vue'
	export default{
		props:['postId','index'],
		data(){
			return{
				commentText:'',
				commentsInfo:'', 
				postComments:[],
				DOMLoaded:false,
				madeByUser:0,
			}
		},
		components:{
			comment
		},
		computed:{
			comments(){
				return this.postComments;
			},
			user(){
				return this.$store.state.currentUser;
			}
		},
		methods:{
			createComment(){
				if (this.commentText!='') {
					helper.API.ComposeComment(this.commentText,this.postId)
					.then(res =>{
						 
						this.comments.unshift(res.data.comment);
						this.commentText='';
				 		this.madeByUser++;
						eventBus.$emit('BackOnTop');
					})
					.catch(er =>{
						console.log(er);
					})
				}
			},
			loadMoreComments(){
				 
				helper.API.LoadMoreComments({url:this.commentsInfo.next_page_url,PostID:this.postId,comment:this.madeByUser})
				.then(doneCallbacks =>{
					for (var i = 0; i < doneCallbacks.data.comments.data.length; i++ )  {
						this.comments.push(doneCallbacks.data.comments.data[i]);
						
					}

					this.commentsInfo=doneCallbacks.data.comments;	
				 	//console.log(this.commentsInfo)
				})
				.catch(failCallbacks =>{
					console.log(failCallbacks)
				})
			},
			hideComments(){
				eventBus.$emit('toggleComments');
			}
		},
		created(){
			eventBus.$on('PostCommentDeleted',(index)=>{
				this.comments.splice(index,1);
			});
			helper.API.GetComments(this.postId)
			.then(doneCallbacks =>{
				this.postComments=doneCallbacks.data.comments.data;
				this.commentsInfo=doneCallbacks.data.comments; 
				setTimeout(_ =>{
					this.DOMLoaded=true;
				},200); 
			})
			.catch(failCallbacks =>{
				console.log(failCallbacks);
			})

		}
	}
</script>