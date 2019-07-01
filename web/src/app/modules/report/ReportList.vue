<template>
	<ul class="report-list">
		<ReportItem v-for="report in reports" :report="report"></ReportItem>
	</ul>
</template>

<script>
	import ReportItem from './ReportItem';
	import axe from '../../Axios';

	export default {
		name: 'ReportList',
		components: { ReportItem },
		data() {
			return {
				reports: []
			}
		},
		mounted() {
			axe.get('list-report.php')
				.then(res => {
					this.reports = res.data.reports;
				})
		}
	}
</script>

<style scoped>

</style>
