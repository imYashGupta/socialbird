<template>
	<div class="row mt-25">
	<div class="col-sm">
		<ul class="nav nav-pills nav-pills-rounded mb-20  float-left" role="tablist">
			<li class="nav-item">
				<a href="#" class="nav-link " :class="(mode=='feed') ? 'active' : ''" @click="changeFeed('feed')">Feeds </a>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link " :class="(mode=='explore') ? 'active' : ''"  @click="changeFeed('explore')">Explore  </a>
			</li>
		</ul>
<!-- 		<ul class="nav nav-pills nav-pills-rounded mb-20 float-right" role="tablist">
			<li class="nav-item dropdown ">
				<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Filter <i class="fas fa-filter"></i></a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<a class="dropdown-item" href="#">Something else here</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">Separated link</a>
				</div>
			</li>
 
		</ul> -->
	</div>
</div>
</template>
<script type="text/javascript">
	import { eventBus } from '../../app'; 
	export default{
		props:['mode'],
		methods:{
			changeFeed(type){
				eventBus.$emit('changeFeed',type);
			}
		}
	}
</script>