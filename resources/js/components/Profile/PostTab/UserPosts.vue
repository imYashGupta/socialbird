<template>
<div id="main">
		<div class="hk-pg-header mb-10">
			<div>
				<h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-ios-today"></i></span> Wall</h4>
			</div>
		</div>
 		<template v-if="!showloading">

			<post-composer v-if="authUser.user.username==this.$route.params.id"></post-composer>
			<profile-post v-if="!showloading"  v-for="(post,index) in posts" :index="index" :post="post" :key="index"></profile-post>
			<profile-post-edit-modal v-if="modal" :modal="modalData"></profile-post-edit-modal>
 		</template>
 
		<div  v-if="showloading" class="text-center">
			<div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
 
 		
</div>
</template>
<script type="text/javascript">
	import { eventBus } from '../../../app'; 
	import Posts from './Post.vue';
	import PostComposer from './Compose.vue';
	import ProfilePostEditModal from './ProfilePostEditModal.vue';
	export default{
		data(){
			return{
				showloading:true,
				posts:[],
				modal:false,
				modalData:null,
				authUser:'',
			}
		},
		components:{
			profilePost:Posts,
			ProfilePostEditModal:ProfilePostEditModal,
			PostComposer:PostComposer
			
		},
		methods:{
			deletePost(id,index){
				swal({
					title: "Are you sure?",
					text: "Once deleted, you will not be able to recover this Post!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						axios.post('/api/post.delete',{id})
						.then(res => {
							swal("Poof! Your Post has been deleted!", {icon: "success"});	
							this.posts.splice(index,1);
						})
						.catch(err => {
							console.log(err);		
						})
					} 
					else {
					    swal("Your Post is safe!");
					}
				});
			},
			editPost(post,index){
				this.modalData={
					post:post,
					index:index
				};
				this.modal=true;
				setTimeout(()=> {
					$("#p-postEditModal").modal('show')
				},100)
			}
		},
 
		created(){
			eventBus.$on('userProfilePosts',(posts) => {
				this.posts=posts;
				this.authUser=this.$store.getters.user;
				if (this.authUser!='') {
					this.showloading=false;
				}

			});
			// delete post event 
			eventBus.$on('profilePostDelete',(data) => {
				this.deletePost(data.id,data.index);
			});
			eventBus.$on('profilePostEdit',(data) => {
				this.editPost(data.post,data.index);
			});

			eventBus.$on("postUpdated",(data) =>{
				this.posts[data.index].body=data.body;
			})

		}
	}
</script>