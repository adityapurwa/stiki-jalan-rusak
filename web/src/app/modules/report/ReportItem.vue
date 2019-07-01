<template>
	<li class="report-item">
		<div class="report-text">
			<div class="report-meta">
				<div class="report-author">
					{{ report.user_name }}
				</div>
				<time class="report-time">
					{{ report.created_at | date }}
				</time>
				<div class="report-support">
					1.512 dukungan
				</div>
			</div>
			<address class="report-address">
				{{ report.address }}
			</address>
			<div class="report-actions">
				<Button type="button" name="report" label="Tandai Palsu"></Button>
				<Button color="primary" type="button" name="report" label="Dukung"></Button>
			</div>
		</div>
		<img class="report-image" :src="getReportImageUrl" />
	</li>
</template>

<script>
	import Button from '../../components/input/Button';
	import { API_URL } from '../../Axios';

	export default {
		name: 'ReportItem',
		components: { Button },
		props: {
			report: Object
		},
		computed: {
			getReportImageUrl() {
				return `http://${ API_URL }/storage/${ this.report.photo }.jpg`;
			}
		},
		filters: {
			date: function (val) {
				const date = new Date(val);
				const dateFormat = new Intl.DateTimeFormat('id-ID');
				return `${ dateFormat.format(date) }, ${ date.getHours() }:${ date.getMinutes() }`;
			}
		}
	}
</script>

<style scoped>
	.report-item {
		display: flex;
		border: solid 1px rgba(0, 0, 0, .1);
		margin: 24px 0;
	}

	.report-item:first-child {
		margin-top: 0;
	}

	.report-item:last-child {
		margin-bottom: 0;
	}

	.report-text {
		flex: 0 0 45%;
		padding: 16px;
	}

	.report-author {
		font-weight: var(--font-heavy);
	}

	.report-time, .report-support {
		font-size: var(--font-small);
		color: rgba(0, 0, 0, .5);
	}

	.report-address {
		margin: 8px 0;
		font-size: var(--font-normal);
		font-style: normal;
		color: rgba(0, 0, 0, .75);
	}

	.report-actions {
		display: flex;
	}

	.report-actions .circle-button {
		flex: 1 1 50%;
	}

	.report-actions .circle-button:first-child {
		margin-right: 16px;
	}

	.report-image {
		flex: 1 1 auto;
		width: 0;
		background: var(--body-bg);
		height: 140px;
		object-fit: cover;
	}
</style>
