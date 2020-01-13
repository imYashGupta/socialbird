<template>
	<router-link :to="'/user/'+user.following.username" class="col-3 mb-15">
		<div class="w-100">
			<div class="avatar avatar-md">
				<img v-if="user.following.images!=null" :src="user.following.images" alt="user" class="avatar-img rounded-circle">
				<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+user.following.avatar">
					<span class="initial-wrap">
						<span>{{ user.following.firstname.charAt(0)+user.following.lastname.charAt(0) }}</span>
					</span>
				</span>
			</div>
		</div>
		<span class="d-block font-14 text-truncate text-muted">{{user.following.fullname}}</span>
	</router-link>
</template>
<script type="text/javascript">
	export default{
		props:['user']	
	}
</script>