<template>
	<!-- Large modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-bg-modal">Large modal</button> -->

<div class="modal fade bd-bg-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
   <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLiveLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
			<section class="hk-sec-wrapper">
				<h5 class="hk-sec-title">Gradient Background</h5>
				<p class="mb-40">A beautiful set of gradient colors is a ready to provide flaunt design to your profile. Simply click to apply.</p>
				<div class="row">
					<div class="col-sm">
						<div class="row">
							<background v-for="(background,index) in bg" :key="index" :bg="background" :currentbg="currentbg"></background>
						</div>
					</div>
				</div>
			</section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" @click="saveBackground" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</template>
<script type="text/javascript">
 
	import background from './Backgrounds.vue'
	import {eventBus} from  './../../../../app';

	export default{
		props:['currentbg'],
		components:{
			background
		},
		data(){
			return{
				bg:["primary","success","warning","danger","info","light","dark","secondary","pony","space","streaks","bunting","paradise","honey","warbler","heaven","dusk","citrine","royston","ashes","metal","sunset"],
			}
		},
		methods:{
			saveBackground(){
				eventBus.$emit('saveBackground');
			}
		},
	}
</script>

