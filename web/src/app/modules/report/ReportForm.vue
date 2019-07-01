<template>
	<div class="report-form" :class="{'disabled': disabled}">
		<div v-if="disabled" class="disabler">
			<Button type="button" name="login" label="Masuk Dengan Google Untuk Membuat Laporan" color="primary"></Button>
		</div>
		<h3>
			Buat Laporan
		</h3>
		<TextField name="address" label="Alamat Jalan" v-model="address"></TextField>
		<ImageField name="photo" label="Foto Kerusakan"></ImageField>
		<div class="report-form-buttons">
			<Button type="submit" name="submit" label="Simpan" color="primary"></Button>
		</div>
	</div>
</template>

<script>
	import Board from '../../components/layout/Board';
	import TextField from '../../components/input/TextField';
	import ImageField from '../../components/input/ImageField';
	import Button from '../../components/input/Button';

	export default {
		name: 'ReportForm',
		props: {
			disabled: Boolean
		},
		data() {
			return { address: '' }
		},
		components: {
			Button,
			ImageField,
			Board,
			TextField
		}
	}
</script>

<style scoped>
	.report-form {
		position: relative;
		margin-top: 8px;
		padding: 8px;
	}

	.report-form.disabled > :not(.disabler) {
		filter: blur(4px);
	}

	.report-form h3 {
		margin-bottom: 16px
	}

	.report-form-buttons {
		text-align: right;
	}

	.disabler {
		background: rgba(255, 255, 255, 0.75);
		z-index: 1;
		position: absolute;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		display: flex;
		align-items: center;
		justify-content: center;
	}

</style>
