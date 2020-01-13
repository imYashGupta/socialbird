<template>
	<div class="avatar" :class="'avatar-'+avatar.size">
		<img v-if="avatar.image!=null" alt="user" class="avatar-img rounded-circle" :src="avatar.image"/>
		<span v-else class="avatar-text rounded-circle" :class="'avatar-text-'+avatar.color"><span class="initial-wrap"><span>{{ avatar.firstname.charAt(0)+avatar.lastname.charAt(0) }}</span></span></span>
	</div>
</template>
<script type="text/javascript">
	export default{
		props:["avatar"]
	}
</script>