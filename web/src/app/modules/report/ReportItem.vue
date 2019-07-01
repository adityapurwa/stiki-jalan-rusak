<template>
	<li class="report-item">
		<div class="report-text">
			<div class="report-meta">
				<div class="report-author">
					Aditya Purwa
				</div>
				<time class="report-time">
					March 24th, 2019 - 15.23
				</time>
				<div class="report-support">
					1.512 dukungan
				</div>
			</div>
			<address class="report-address">
				Jalan Jogja 51A, Kota Malang
			</address>
			<div class="report-actions">
				<Button type="button" name="report" label="Tandai Palsu"></Button>
				<Button color="primary" type="button" name="report" label="Dukung"></Button>
			</div>
		</div>
		<div class="report-image">
		</div>
	</li>
</template>

<script>
	import Button from '../../components/input/Button';

	export default {
		name: 'ReportItem',
		components: { Button },
		props: {}
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

	.report-actions .button {
		flex: 1 1 50%;
	}

	.report-actions .button:first-child {
		margin-right: 16px;
	}

	.report-image {
		flex: 1 1 auto;
		background: var(--body-bg);
		height: auto;
	}
</style>
