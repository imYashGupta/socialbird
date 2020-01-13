<template>
	<router-link :to="'/user/'+user.user.username" class="col-3 mb-15">
	
		<div class="w-100">
			<div class="avatar avatar-md">
				<img v-if="user.user.images!=null" :src="user.user.images" alt="user" class="avatar-img rounded-circle">
				<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+user.user.avatar">
					<span class="initial-wrap">
						<span>{{ user.user.firstname.charAt(0)+user.user.lastname.charAt(0) }}</span>
					</span>
				</span>
			</div>
		</div>
		<span class="d-block font-14 text-truncate text-muted">{{user.user.fullname}}</span>
	</router-link>
</template>
<script type="text/javascript">
	export default{
		props:['user']	,
		created(){
		}
	}
</script>