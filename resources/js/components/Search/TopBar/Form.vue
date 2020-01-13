<template>
<form role="search" @submit.prevent class="navbar-search">
	<div class="position-relative">
		<a href="javascript:void(0);" class="navbar-search-icon"><i class="ion ion-ios-search"></i></a>
		<input type="text" v-model="query" @keyup.enter="init()"  class="form-control" placeholder="Type here to Search">
		<a id="navbar_search_close" class="navbar-search-close" href="#"><i class="ion ion-ios-close"></i></a>
	</div>
</form>
</template>
<script type="text/javascript">
	import {eventBus} from './../../../app'
	export default{
		methods:{
			init(){
				if (this.query!='') {			
					if (this.$route.name=="search") {
						this.$router.push('/search?query='+this.query);

						eventBus.$emit('searchInit');
						let searchData={
							"text" : this.query,
							"type"	: this.type
						}
						axios.post('/api/search',searchData)
						.then(res => {
							eventBus.$emit('searchResult',res.data);
						})
					}
					else{
						this.$router.push('/search?query='+this.query);
					}
				}
			}
		},
		data(){
			return {
				query:'',
				type:'user'
			}
		}
	}
</script>