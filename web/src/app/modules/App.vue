<template>
	<div class="app">
		<header>
			<h1>
				Lapor Jalan Rusak
			</h1>
			<UserStatus></UserStatus>
		</header>
		<main class="content">
			<aside class="left-board">
				<Board>
					<ReportForm v-if="getLeftBoardContent === 'report'"></ReportForm>
					<RegisterForm v-if="getLeftBoardContent === 'register'" @back="switchUserMode('login')"></RegisterForm>
					<LoginForm v-if="getLeftBoardContent === 'login'" @back="switchUserMode('register')"></LoginForm>
				</Board>
				<footer>
					<div class="copyright">
						Copyright &copy; Aditya Purwa 171116002 - Open Source
					</div>
				</footer>
			</aside>
			<section class="main-board">
				<div class="search-box">
					<TextField name="search" label="Pencarian" :shadow="true" :borderless="true" />
				</div>
				<div class="report-feeds">
					<Board>
						<ul class="report-list">
							<ReportItem></ReportItem>
							<ReportItem></ReportItem>
							<ReportItem></ReportItem>
							<ReportItem></ReportItem>
							<ReportItem></ReportItem>
							<ReportItem></ReportItem>
						</ul>
					</Board>
				</div>
			</section>
		</main>

	</div>
</template>

<style scoped>
	header {
		display: flex;
		align-items: center;
	}

	header h1 {
		font-size: var(--font-h1);
		font-weight: var(--font-light);
		flex: 1 1 auto;
	}

	header .user-status {
		flex: 0 0 30%;
	}

	footer {
		margin-top: 24px;
		color: rgba(0, 0, 0, .5);
	}

	.app {
		width: 960px;
		margin: 32px auto;
	}

	.content {
		margin: 16px 0;
		display: flex;
	}

	.left-board {
		display: none;
		flex: 0 0 420px;
		margin-right: 24px;
		height: auto;
	}

	.left-board .board {
		height: auto;
	}

	.main-board {
		flex: 1 1 auto;
		height: auto;
		display: flex;
		flex-direction: column;
	}

	.search-box {
		margin-bottom: 8px;
		flex: 0 0 auto;
	}

	.report-feeds {
		flex: 1 1 auto;
	}

</style>
<script>
	import Board from '../components/layout/Board';
	import TextField from '../components/input/TextField';
	import ReportForm from './report/ReportForm';
	import TermsNotice from './TermsNotice';
	import ReportItem from './report/ReportItem';
	import RegisterForm from './user/RegisterForm';

	import axe from '../Axios';
	import UserStatus from './user/UserStatus';
	import LoginForm from './user/LoginForm';

	export default {
		components: { LoginForm, UserStatus, RegisterForm, ReportItem, TermsNotice, ReportForm, TextField, Board },
		data() {
			return {
				userMode: 'register'
			}
		},
		computed: {
			getLeftBoardContent() {
				if (this.loggedIn) {
					return 'report';
				}
				return this.userMode;
			},
			loggedIn() {
				return !!this.$store.state.user.user;
			},
			currentUserName() {
				return this.$store.state.user.user.name;
			}
		},
		methods: {
			switchUserMode(mode) {
				this.userMode = mode;
			}
		},
		mounted() {
			axe.get('check.php')
				.then(res => {
					this.$store.commit('user/setUser', {
						user: res.data.user
					});
				}).catch(err => {
			});
		}
	}
</script>
