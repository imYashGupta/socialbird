<template>
<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="card shadow-xl shadow-hover mb-20">
		<div class="card-img card-img-bg text-white text-center -" :class="'bg-gradient-'+user.user.background" style="background-image: url(/dist/img/cropper.jpg);">
			<div class="card-img-overlay text-white bg-trans-dark-25">
				<div class="avatar ">
					<img v-if="user.user.images!=null" :src="user.user.images" alt="user" class="avatar-img rounded-circle shadow-xl">
					<span v-else class="avatar-text shadow-xl  rounded-circle" :class="'avatar-text-'+user.user.avatar">
						<span class="initial-wrap">
							<span v-if="user.user.firstname">{{ user.user.firstname.charAt(0)+user.user.lastname.charAt(0) }}</span>
						</span>
					</span>				
				</div>
					<router-link :to="'/user/'+user.user.username" class="card-title text-white mb-0 mt-10 h5 d-block">{{user.user.fullname}}</router-link>
					<p class="card-text"><small class="text-white">{{user.user.usermeta.title}}</small></p>
					<p class="mt-3 mb-3">{{user.followers.follower}} Follower | {{user.followers.following}} following</p>
					<follow-btn type="icon" :follow="user.user.follower" :id="user.user.id"></follow-btn>
				</div>
			</div>
		</div>
	</div>
	</template>
	<script type="text/javascript">
		import FollowBtn from './../../Elements/FollowBtn.vue';
		export default{
			props:['user'],
			components:{
				FollowBtn
			},
			created(){
				//console.log(this.user);
			},
			methods:{
				follow(){

				}
			}
		}
	</script>