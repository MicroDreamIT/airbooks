<template>
	<div>
		<div class="dropHeader d-flex justify-content-between" id="asideCollaps">
			<span class="text-primary">View Category</span>
			<i id="iconFolding" class="icon mdi mdi-caret-down rotateIcon" data-name="mdi-chevron-down"></i>
		</div>
		<div class="asideArea">
			<div class="child-one">
				<div class="nano-content">
					<div class="content">
						<slot name="asideContent"></slot>
					</div>
				</div>
			</div>
			<div class="child-two col-sm-12">
				<div class="innerContent">
					<div class="card card-contrast custom_info">
						<slot name="asideMainContent"></slot>
					</div>
				</div>
			</div>
		</div>
	
	
	
	
	</div>
</template>

<script>
    export default {

        data(){
            return{

            }
        },
        mounted() {
            $(document).ready(function () {
                $("#asideCollaps").click(function(){
                    $(".child-one").slideToggle();
                    $("#iconFolding").toggleClass('rotating');
                });
            })
        }

    }
</script>
