<template>
<div>
	<div class="container mt-25">
		
		<!-- Title -->
		<div class="hk-pg-header mb-10">
			<div>
				<h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-ios-today"></i> </span>Post Edit</h4>
			</div>
			<div class="d-flex  ">
				<button class="btn btn-light btn-sm  " >Home</button>
			</div>
		</div>
		<!-- Row -->
		<div class="row">
			<div class="col-xl-12">
				<div class="card card-profile-feed">
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
								<div class="text-capitalize font-weight-500 text-dark">{{post.user.fullname}}</div>
								<div class="font-13">{{post.created_at}}</div>
								
							</div>
						</div>
						
					</div>
					<div class="card-body">
						<p class="card-text mb-30">{{post.body}}</p>
						<textarea rows="2" v-model='post.body' placeholder="Write a Post..." class="form-control filled-input bg-transparent p-0" autocomplete="off"> </textarea>
					</div>
					
				</div>
				<button class="btn btn-primary mt-5 float-right" @click="updatePost">Update</button>
				
			</div>
		</div>
		<!-- /Row -->
	</div>
</div>
</template>
<script type="text/javascript">
	import {eventBus} from './../../../app';
	import {helper} from './../../../helper';
	 
	 
	export default{
		data(){
			return {
				post:{},
				postbody:'',
			}
		},
		methods:{
			updatePost(){
					 
				if (this.post.body!='' && this.post.body!=this.postbody) {	
					helper.API.UpdatePost(this.post)
					.then(res => {
					 	localStorage.setItem('post',JSON.stringify(this.post));
						this.$router.push('/post/'+this.$route.params.id);
					})
					.catch(er => {
						console.log(error);
					});
				}
			}
		},
		created(){
	 
			var post= (localStorage.getItem('post')!= '' ? JSON.parse(localStorage.getItem('post')) : '');
			if (post=='' || post==null) {
				this.$router.push('/404')
			}
			else{
				if (this.$route.params.id!=post.id) {
					this.$router.push('/404');
				}
				else{
					if (post.user.username!=this.$store.getters.user.user.username) {
						this.$router.push('/404');
					}
					this.post=post;
					this.postbody=post.body;
				}
		 
			}
		}
	}
</script>