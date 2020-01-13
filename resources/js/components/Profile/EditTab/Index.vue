<template>
<div>
	<template v-if="showloading">
	<div   class="text-center">
		<div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
			<span class="sr-only">Loading...</span>
		</div>
	</div>
	</template>
	<template v-else>
		<edit-form :data="EditFormData" :countries="countries"></edit-form>
	</template>
</div>
</template>
<script type="text/javascript">
	import { eventBus } from '../../../app';
	import Form from './EditForm.vue'
	export default{
		components:{
			EditForm:Form,
		},
		data(){
			return{
				EditFormData:null,
				showloading:true,
				countries:[]
			};
		},
		created(){
			eventBus.$on('EditProfile',(data)=>{
				this.EditFormData=data;
				axios.get('http://vocab.nic.in/rest.php/country/json')
				.then(response => {
					this.countries=response.data.countries;
					this.showloading=false;
				})

				
			})
		}
	}
</script>