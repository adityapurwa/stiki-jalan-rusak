<template>
	<Modal title="Buat Laporan Baru" :visible="visible" @close="$emit('close')">
		<div class="report-form" :class="{'disabled': disabled}">
			<div v-if="disabled" class="disabler">
				<Button type="button" name="login" label="Masuk Dengan Google Untuk Membuat Laporan" color="primary"></Button>
			</div>
			<TextField name="address" label="Alamat Jalan" v-model="address"></TextField>
			<ImageField ld ref="photo" name="photo" label="Foto Kerusakan"></ImageField>
		</div>
		<template v-slot:footer>
			<div class="report-form-buttons">
				<Button @click="handleSubmit" type="submit" name="submit" label="Simpan" color="primary"></Button>
			</div>
		</template>
	</Modal>
</template>

<script>
	import Board from '../../components/layout/Board';
	import TextField from '../../components/input/TextField';
	import ImageField from '../../components/input/ImageField';
	import Button from '../../components/input/Button';
	import Modal from '../../components/layout/Modal';
	import axe from '../../Axios';

	export default {
		name: 'ReportForm',
		props: {
			disabled: Boolean,
			visible: Boolean
		},
		data() {
			return {
				address: '',
				isLoading: false
			}
		},
		methods: {
			handleSubmit() {
				this.isLoading = true;
				const photo = this.$refs.photo.getFiles()[0];
				const formData = new FormData();
				formData.append('address', this.address);
				formData.append('photo', photo);
				axe.post('create-report.php', formData)
					.then(res => {

					})
					.catch(err => {
						if (err.response.status === 400) {
							this.errors = err.response.data;
						} else if (err.response.status === 500) {
							this.errors = {
								server: err.response.data.error
							};
						}
					})
					.finally(() => this.isLoading = false);
			}
		},
		components: {
			Modal,
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
