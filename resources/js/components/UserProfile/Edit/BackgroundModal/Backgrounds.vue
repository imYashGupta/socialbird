<template>

	<div class="col-md-3 mb-30 pointer">
		<div @click="changeBackground" class="h-100p pa-15 text-white text-capitalize" :class="['bg-gradient-'+bg,(currentbg==bg ? 'set-active': '')]"   >{{bg}} </div>
	</div>

</template>
<script type="text/javascript">
	import {eventBus} from  './../../../../app';

	export default{

		props:['bg','currentbg'],
		methods:{
			changeBackground(){
				eventBus.$emit('changeBackground',this.bg);
			}
		}
	}
</script>
<style type="text/css" scoped="">
	.set-active{
		border: 3px solid #00acf0;
	}
</style>