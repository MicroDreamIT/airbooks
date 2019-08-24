<template>
	<div>
		<div class="be-content be-aside">
			<slot name="aside"></slot>
			<div class="main-content container-fluid">
				<slot name="content"></slot>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        name: "user-content"
    }
</script>

