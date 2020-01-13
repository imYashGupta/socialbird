<template>
<div>
	<div class="container mt-25">
		
		<!-- Title -->
		<div class="hk-pg-header mb-10">
			<div>
				<h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-ios-today"></i> </span>Post</h4>
			</div>
			<div class="d-flex  ">
				<button class="btn btn-light btn-sm  " >Home</button>
			</div>
		</div>
		<!-- /Title -->
		<!-- Row -->
		<loader v-if="!DOMloaded"></loader>
		<div class="row" v-if="DOMloaded">
			<div class="col-xl-12">
				<div class="card-columns card-column-1" :id="'top_'+count">
					<div class="card card-profile-feed mb-0 rounded-bottom-0">
						<div class="card-header card-header-action">
							<div class="media align-items-center">
								<div class="media-img-wrap d-flex mr-10">
									<div class="avatar avatar">
										<img v-if="post.user.images!=null" :src="post.user.images" alt="user" class="avatar-img rounded-circle">
										<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+post.user.avatar">
											<span class="initial-wrap">
												<span>{{ post.user.firstname.charAt(0)+post.user.lastname.charAt(0) }}</span>
											</span>
										</span>
									</div>
								</div>
								<div class="media-body">
									<router-link :to="'/user/'+post.user.username" class="text-capitalize font-weight-500 text-dark">{{post.user.fullname}}</router-link>
									<div class="font-13">{{post.created_at}}</div>
								</div>
							</div>
							<div class="d-flex align-items-center card-action-wrap">
								<div class="inline-block dropdown">
									<a class="dropdown-toggle no-caret" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="ion ion-ios-more"></i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<!-- <router-link class="dropdown-item" :to="'/post/'+this.$route.params.id+'/edit'">Edit</router-link> -->
										
										<template v-if="authuser">
											<a   class="dropdown-item" href="#" @click.prevent="editPost">Edit</a>
											<a  class="dropdown-item" href="#" @click.prevent="deletePost">Delete</a>
										</template>
										<template v-else>
											<router-link class="dropdown-item" :to="'/user/'+post.user.username">Profile</router-link>
											
										</template>
										<follow-dropdown-btn :isFollower="post.user.follower" :id="post.user.id"></follow-dropdown-btn>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<p class="card-text mb-30">{{post.body}}</p>
							<div class="card" v-if="post.images==1">
							<div class="position-relative">
								<img data-action="zoom"  class="card-img-top rounded d-block" :src="'/images/posts/'+post.media.image[0].name" alt="Card image cap">
							</div>
						</div>
						</div>
						<div class="card-footer justify-content-between">
							<div>
								<reactionbtn :id="post.id" :reacts="data.reactCount" :isliked="post.isLiked"></reactionbtn>
							</div>
							<div>
								<a href="#" @click="toggleComments">{{data.commentCount}} comments</a>
								<!-- <a href="#">18 shares</a> -->
							</div>
						</div>
					</div>
				</div>
					<comments v-if="showComments"  :comments="comments" :postId="post.id"></comments>
				
			</div>
		</div>
		<!-- /Row -->
		<reacts-modal></reacts-modal>
	</div>
</div>
</template>
<script type="text/javascript">
	import {helper} from './../../../helper';
	import {eventBus} from './../../../app';
	import Loader from './../../Loader/FullScreen.vue';
	import Comments from './Comments/Index.vue';
	import Reactionbtn from './../../Elements/ReactBtn.vue'
	import ReactsModal from './../../Elements/ReactsModal/Index.vue'
	import FollowDropdownBtn from './../../Elements/FollowBtnDropDown.vue'

	export default{
		data(){
			return{
				DOMloaded:false,
				post:{},
			 	showComments:true,
				comments:[],
				count:1,
				data:null
			}
		},
		components:{
			Comments,Loader,Reactionbtn,ReactsModal,FollowDropdownBtn
		},
		methods:{
			toggleComments(){
				eventBus.$emit('toggleComments');
			},
			editPost(){
				localStorage.setItem('post',JSON.stringify(this.post));
				this.$router.push('/post/'+this.$route.params.id+'/edit');
			},
			deletePost(){
				swal({
					title: "Are you sure?",
					text: "Once deleted, you will not be able to recover this Post!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						helper.API.DeletePost(this.post.id)
						.then(res => {
							swal("Poof! Your Post has been deleted!", {
								icon: "success",
					    	});
						})
					}
				});
			}
		
		},
		computed:{
			authuser(){
                return this.$store.getters.user.user.username==this.post.user.username;
            }
		},
		created(){
			let PostID =this.$route.params.id;
			axios.post('/api/post.single',{id:PostID})
			.then(doneCallbacks =>{
				if (doneCallbacks.data.request) {
					this.DOMloaded=true;
					this.post=doneCallbacks.data.post;
					this.comments=doneCallbacks.data.comments;
					this.data=doneCallbacks.data;

				}
				else{
					this.$router.push('/404');
				}
				//console.log(doneCallbacks.data.request);
			});

	 		eventBus.$on('toggleComments' ,_ =>{
	 			this.showComments=!this.showComments;
	 		})
			eventBus.$on('BackOnTop',_ =>{
				window.location.hash='top_'+this.count;
				this.count++;
			});

		 
		}
	}
</script>