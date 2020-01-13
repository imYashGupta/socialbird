<template>
	<div>
	<div :id="post.id+'postview'+aftercomment" class="card card-profile-feed mb-0 rounded-bottom-0 shadow-sm shadow-hover-lg mt-3">
		<div class="card-header card-header-action">
			<div class="media align-items-center">
				<div class="media-img-wrap d-flex mr-10">
					<div class="avatar avatar-md">
						<img v-if="post.user.images!=null" :src="post.user.images" alt="user" class="avatar-img rounded-circle">
						<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+post.user.avatar">
							<span class="initial-wrap">
								<span>{{ post.user.firstname.charAt(0)+post.user.lastname.charAt(0) }}</span>
							</span>
						</span>
					</div>
				</div>
				<div class="media-body">
					<a href="" @click.prevent="" class="text-capitalize font-weight-500 text-dark pointer">{{post.user.fullname}}</a>
					<div class="font-13">{{post.created_at}}</div>
				</div>
			</div>
			<div class="d-flex align-items-center card-action-wrap">
				<div class="inline-block dropdown">
					<a class="dropdown-toggle no-caret" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="ion ion-ios-more"></i></a>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="#">Action</a>
						<a  class="dropdown-item" href="#"
						@click.prevent="editEvent(post,index)" >Edit </a>
						<a   class="dropdown-item" href="#" @click.prevent="deleteEvent(post.id,index)">Delete</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Separated link</a>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body">
			<p class="card-text mb-30">{{post.body}}</p>
			
		</div>
		<div  class="card-footer justify-content-between">
			<div>
				<a href="#" @click.prevent="react(index,post.id)">
					<i class=" text-primary" :class="(post.isLiked ? 'fas fa-heart' : 'far fa-heart')">
					</i>
				<div v-if="post.extra" class="spinner-grow spinner-grow-sm" role="status">
					<span class="sr-only">Loading...</span>
				</div>
				<span @click.prevent.stop="showReacts(post)" v-if="!post.extra">
					&nbsp;{{ post.reacts_count }}
				</span>
				</a>
			</div>
			<div>
				<a href="#" @click.prevent="post.is_deleted=!post.is_deleted">{{post.comments_count}} comments </a>
				<a href="#">1 shares</a>
			</div>
		</div>
	</div>
	<comments v-if="post.is_deleted" :postIndex="index" :post="post" type="profile" ></comments>
	<post-react-modal v-if="showReacts"></post-react-modal>
	</div>
</template>
<script type="text/javascript">
	import { eventBus } from '../../../app'; 
	import comments from './Comment.vue';
	import PostReactModal from './../../Posts/ReactsModal/PostReactsModal.vue';
	export default{
		props:['post','index'],
		components:{
			comments:comments,
			PostReactModal:PostReactModal
		},
		data(){
			return{
				showReact:false,
				aftercomment:1
			}
		},
		methods:{
			deleteEvent(id,index){
				eventBus.$emit('profilePostDelete',{id,index});
			},
			editEvent(post,index){
				eventBus.$emit('profilePostEdit',{post:post,index});
			},
			react(index,id){
				this.post.extra=true;
				
				axios.post('/api/react',{postID:id})
				.then(response => {
					const react=response.data.res;
					this.post.isLiked=react;
					this.post.extra=false;
					(react) ? this.post.reacts_count++ : this.post.reacts_count--;
				})
		 		 
			},
			showReacts(post){

				this.showReact=true;
				setTimeout(() => {
					$("#reactsModal").modal('show');
					eventBus.$emit('showReactsFor',post);
				},100);
			},
		},
		created(){
			eventBus.$on('hideComment', (post) => {
				post.is_deleted=false;
			});

			eventBus.$on('backToPost',() => {
				window.location.hash=this.post.id+'postview'+this.aftercomment;
				this.aftercomment++;
				this.post.comments_count++;
			})
		}
	}
</script>