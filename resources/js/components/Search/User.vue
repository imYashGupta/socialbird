<template>
<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="card shadow-xl shadow-hover mb-20">
		<div class="card-img card-img-bg text-white text-center -" :class="'bg-gradient-'+user.background" style="background-image: url(/dist/img/cropper.jpg);">
			<div class="card-img-overlay text-white bg-trans-dark-25">
				<div class="avatar ">
					<img v-if="user.images!=null" :src="user.images" alt="user" class="avatar-img rounded-circle shadow-xl">
					<span v-else class="avatar-text shadow-xl  rounded-circle" :class="'avatar-text-'+user.avatar">
						<span class="initial-wrap">
							<span v-if="user.firstname">{{ user.firstname.charAt(0)+user.lastname.charAt(0) }}</span>
						</span>
					</span>
				</div>
				<router-link :to="'/user/'+user.username" class="card-title text-white mb-0 mt-10 h5 d-block">{{user.fullname}}</router-link>
				<p class="card-text"><small class="text-white">{{user.usermeta.title}}</small></p>
			 
				<follow-btn type="icon" v-if="user.follower!=null" :follow="user.follower" :id="user.id"></follow-btn>
			</div>
		</div>
	</div>
</div>
</template>
<script type="text/javascript">
		import FollowBtn from './../Elements/FollowBtn.vue';

	export default{
		props:['user'],
		components:{
			FollowBtn
		}
	}
</script>