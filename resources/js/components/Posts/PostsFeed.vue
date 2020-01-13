<template>
<div>
	<feed-options :mode="mode"></feed-options>
	<template v-if="DOMloaded">
		<div v-if="posts.length==0">
			<div class="card card-lg"><div class="card-body"><div><div>Please follow other users to get feed updates or Try Explore Mode</div></div></div></div>
		</div>
		<div v-else class="card-columns card-column-1 " v-for="(post,key) in posts" :ref="'p'+key"  :key="key">
			<div class="card card-profile-feed mb-0 rounded-bottom-0 shadow-sm shadow-hover-lg mt-3">
				<div class="card-header card-header-action">
					<div class="media align-items-center">
						<div class="media-img-wrap d-flex mr-10">
							<div class="avatar avatar-md">
								<span v-if="post.user.images==null" class="avatar-text  rounded-circle" :class="'avatar-text-'+post.user.avatar">
									<span class="initial-wrap">
										<span>{{ post.user.firstname.charAt(0)+post.user.lastname.charAt(0) }}</span>
									</span>
								</span>
								<img  v-else :src="post.user.images" alt="user" class="avatar-img rounded-circle">
							</div>
						</div>
						<div class="media-body">
							<router-link tag="div" :to="'/user/'+post.user.username" class="text-capitalize font-weight-500 text-dark pointer">{{post.user.firstname}} {{post.user.lastname}}</router-link>
							<div class="font-13">{{post.created_at}}</div>
						</div>
					</div>
					<div class="d-flex align-items-center card-action-wrap">
						<div class="inline-block dropdown">
							<a class="dropdown-toggle no-caret" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="ion ion-ios-more"></i></a>
							<div class="dropdown-menu dropdown-menu-right">
								<router-link class="dropdown-item" :to="'/post/'+post.id">View</router-link>
								<a v-if="post.user.id==user.user.id" class="dropdown-item" href="#" @click.prevent="editPost(key,post.id)">Edit </a>
								<a v-if="post.user.id==user.user.id"  class="dropdown-item" href="#" @click.prevent="deletePost(key,post.id)">Delete</a>
								
								<follow-dropdown-btn :isFollower="post.user.follower" :id="post.user.id"></follow-dropdown-btn>
							</div>
						</div>
					</div>
				</div>
				<div   class="card-body">
					<p class="card-text mb-30">{{post.body}}</p>
						<div class="card" v-if="post.images==1">
							<div class="position-relative">
								<img data-action="zoom"  class="card-img-top rounded d-block" :src="'/images/posts/'+post.media.image[0].name" alt="Card image cap">
							</div>
						</div>
					
				</div>
				<div class="card-footer justify-content-between">
					<div>
						<a href="#"  @click.prevent="react(key,post.id)">
							<i class=" text-primary" :class="(post.isLiked ? 'fas fa-heart' : 'far fa-heart')">
							
							</i>
							<div v-if="post.extra" class="spinner-grow spinner-grow-sm" role="status">
								<span class="sr-only">Loading...</span>
							</div>
							<span @click.prevent.stop="showReacts(post)" v-if="!post.extra">
								{{ post.reacts_count }}
							</span>
						</a>
					</div>
					<div>
						<a href="#" @click.prevent="post.is_deleted=!post.is_deleted">{{post.comments_count}} comments </a>
						<!-- <a href="#">{{key}} shares</a> -->
					</div>
				</div>
			</div>
			<comment v-if="post.is_deleted" :post="post" :postIndex="key"></comment>
		</div>
		<modal :body="modalbody" :postData="modalData"></modal>
		<post-react-modal v-if="showReact"  ></post-react-modal>
	</template>
	<template v-else>
		<loader></loader>
	</template>
</div>
</template>
<script>
	import { eventBus } from '../../app'; 
	import FeedOptions from './FeedOptions.vue';
	import Modal from './PostEditModal.vue';
	import Comment from './Comments/Comment.vue';
	import PostReactModal from './ReactsModal/PostReactsModal.vue';
	import Loader from './../Loader/FullScreen.vue';
	import FollowDropdownBtn from './../Elements/FollowBtnDropDown.vue'
	export default{
		data(){
			return{
				showComment:false,
				modalData:null,
				modalbody:'',
				DOMloaded:false,
				showReact:false,
				mode:'feed'
			}
		},
		components:{
			Modal:Modal,
			Comment:Comment,
			PostReactModal:PostReactModal,
			FeedOptions,Loader,FollowDropdownBtn
		},
		methods:{
			showReacts(post){

				this.showReact=true;
				setTimeout(() => {
					$("#reactsModal").modal('show');
					eventBus.$emit('showReactsFor',post);
				},100);
			},
			react(index,id){
				this.$store.state.posts[index].extra=true;
				this.$store.dispatch('react',{index:index,id:id})
				.then(response => {
/*					const react=response.data.res;
					if (react==1) {
						this.heartIcon='favorite';
					}
					else{
						this.heartIcon='favorite_border';
					}*/
					this.$store.state.posts[index].extra=false;

				})
		 		 
			},
			deletePost(index,id){
				let vue=this;
				swal({
					title: "Are you sure?",
					text: "Once deleted, you will not be able to recover this imaginary file!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						//$(this.$refs['p'+index]).fadeOut('slow');
						vue.$store.dispatch('deletePost',{index:index,id:id})
						.then(res => {
							swal("Poof! Your imaginary file has been deleted!", {
								icon: "success",
					    	});
						})
					} else {
					    swal("Your imaginary file is safe!");
					}
				});
		 	},
		 	editPost(index,id){
		 		this.modalbody=this.$store.state.posts[index].body;
		 		this.modalData={
		 			id:id,
		 			index:index
		 		};
		 		eventBus.$emit('postData',{id:id,index:index,body:this.$store.state.posts[index].body})
		 		$('#postEditModal').modal('show');
		 	}
		},
		computed:{
			posts(){
				return this.$store.getters.posts;
			},
			user(){
				return this.$store.getters.user;
			}
		},
		created(){
			this.$store.dispatch('fetchPosts',{mode:this.mode})
			.then(res => {
				this.DOMloaded=true;
			})
			//Hide Comment form Button 
			eventBus.$on('hideComment', (post) => {
				post.is_deleted=false;
			});
			eventBus.$on('closeReacts',() =>{
				this.showReact=false;
				//console.log(this.showReact)
			})
			 
			eventBus.$on('changeFeed',(mode)=>{
				this.DOMloaded=false;
				this.mode=mode;
				this.$store.dispatch('fetchPosts',{mode:this.mode})
				.then(res => {
					this.DOMloaded=true;
				})
				.catch(er =>{
					console.log(er);
				})
			})

		 
 
		}
	}
</script>
