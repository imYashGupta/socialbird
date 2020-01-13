<template>
<a href="#" @click.prevent="react">
	<i :class="(liked ? 'fas' : 'far')" class=" text-primary fa-heart" > </i>
	<span>
		<div v-if="loading" class="spinner-grow spinner-grow-sm" role="status">
			<span class="sr-only">Loading...</span>
		</div>
		<span v-else @click.prevent.stop="showReacts">
			{{reaction}}
		</span>
	</span>
</a>
</template>
<script type="text/javascript">
	import {eventBus} from  './../../app';

	export default{
		props:['id','reacts','isliked'],
		data(){
			return{
				reaction:this.reacts,
				liked:this.isliked,
				loading:false,
			}
		},
		methods:{
			react(){
				this.loading=true;
				axios.post('/api/react',{postID:this.id})
				.then(response => {
					const react=response.data.res;
					this.liked=react;
					(react) ? this.reaction++ : this.reaction--;
					this.loading=false;

				})
			},
			showReacts(){
				eventBus.$emit('ShowReactsModal',this.id);
			}
		}
	}
</script>