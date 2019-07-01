<template>
	<Modal title="Daftar" :visible="visible" @close="$emit('close')">
		<form action="" class="register-form" @submit.prevent="handleSubmit">
			<ErrorAlert v-if="errors.server">
				{{ errors.server }}
			</ErrorAlert>
			<TextField name="email" type="email" v-model="email" label="E-mail" :errors="errors.email"></TextField>
			<TextField name="text" type="name" v-model="name" label="Nama" :errors="errors.name"></TextField>
			<TextField
				name="password"
				type="password"
				v-model="password"
				label="Password"
				:errors="errors.password"
			></TextField>
		</form>
		<template v-slot:footer>
			<Button
				@click="handleSubmit"
				type="submit" label="Daftar" color="primary" name="submit"
				:loading="isLoading"
			></Button>
		</template>
	</Modal>
</template>

<script>
	import axe from '../../Axios';
	import TextField from '../../components/input/TextField';
	import Button from '../../components/input/Button';
	import ErrorAlert from '../../components/alert/ErrorAlert';
	import DefaultAlert from '../../components/alert/DefaultAlert';
	import Cookies from 'js-cookie';
	import Modal from '../../components/layout/Modal';

	export default {
		name: 'RegisterForm',
		components: { Modal, DefaultAlert, ErrorAlert, Button, TextField },
		props: {
			visible: Boolean
		},
		data() {
			return {
				email: '',
				password: '',
				name: '',
				errors: {},
				isLoading: false
			}
		},
		methods: {
			handleSubmit() {
				this.isLoading = true;
				this.errors = {};
				axe.post('register.php', {
					email: this.email,
					name: this.name,
					password: this.password
				}).then(res => {
					const session = res.data.session;
					Cookies.set('PHPSESSID', session);
					this.$store.commit('user/setUser', {
						user: res.data.user
					});
					this.$emit('close');
				}).catch(err => {
					if (err.response.status === 400) {
						this.errors = err.response.data;
					} else if (err.response.status === 500) {
						this.errors = {
							server: err.response.data.error
						};
					}
				}).finally(() => this.isLoading = false);
			}
		}
	}
</script>

<style scoped>
	.register-buttons {
		display: flex;
		text-align: right;
	}

	.register-buttons .circle-button {
		flex: 1 1 auto;
	}

	.register-buttons .circle-button:first-child {
		margin-right: 8px;
	}
</style>
