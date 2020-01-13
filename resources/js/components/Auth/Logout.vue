<template>
	
</template>
<script>
	export default{
		created(){
			this.$store.dispatch('destroyToken')
			.then((response) => {
				  this.$router.push('/login');
			})
			.catch(er =>{
				  this.$router.push('/login');
				
			})
		}
	}
</script>