<template>
	<div class="image-field">
		<label :for="name" class="image-label">{{ label }}</label>
		<div class="image-box" @click="clickInputFile">
			<img class="image-thumbnail" :alt="label" v-if="thumbnailUrl" :src="thumbnailUrl" />
			<div v-else class="image-prompt">
				Tekan untuk memilih foto
			</div>
		</div>
		<input type="file" :name="name" class="image-input" ref="inputFile" @change="showThumbnail" />
	</div>
</template>

<script>
	export default {
		name: 'ImageField',
		data() {
			return {
				thumbnailUrl: null
			}
		},
		props: {
			name: String,
			label: String,
			value: Object,
			height: Number
		},
		methods: {
			clickInputFile() {
				this.$refs.inputFile.click();
			},
			showThumbnail() {
				const files = this.$refs.inputFile.files;
				const file = files[0];
				const reader = new FileReader();
				reader.addEventListener('loadend', () => {
					this.thumbnailUrl = reader.result;
				});
				reader.readAsDataURL(file);
			},
			getFiles(){
				return this.$refs.inputFile.files;
			}
		}
	}
</script>

<style scoped>

	.image-field {
		margin: 4px 0 12px;
	}

	.image-field:first-child {
		margin-top: 0;
	}

	.image-label {
		display: block;
		font-weight: var(--font-heavy);
		margin-bottom: 4px;
	}

	.image-input {
		display: none;
	}

	.image-box {
		min-height: 150px;
		border: solid 1px rgba(0, 0, 0, .1);
		background: var(--body-bg);
		display: flex;
		align-items: center;
		justify-content: center;
		transition: all var(--speed-fast) ease;
	}

	.image-prompt {
		font-weight: var(--font-heavy);
		font-size: var(--font-large);
		color: rgba(0, 0, 0, .5);
		transition: all var(--speed-fast) ease;
	}

	.image-box:hover {
		border: solid 1px var(--accent-a50);
		cursor: default;
	}

	.image-box:hover .image-prompt {
		color: rgba(0, 0, 0, .75);
	}

	.image-thumbnail {
		width: 100%;
		height: auto;
		object-fit: cover;
	}

</style>
