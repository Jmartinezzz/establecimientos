<template>
	<div>
		<h2 class="mt-4">Galería de Imágenes</h2>
		<ul class="row list-unstyled mt-4">
			<li class="col-md-4 mb-4" v-for="imagen in imagenesGaleria" v-bind:key="imagen.id">
				<a :href="`/storage/${imagen.ruta}`" data-lightbox="imagenes" :data-title="`Imagenes del establecimiento ${nombreEstablecimiento}`" >
					<img class="img-fluid rounded border border-info" :src="`/storage/${imagen.ruta}`" :alt="`Imagenes del establecimiento ${nombreEstablecimiento}`">
				</a>
				
			</li>
		</ul>
	</div>
</template>

<script>
	import Lightbox from 'lightbox2';

	export default {
		props: [
			'nombreEstablecimiento'
		],
		computed: {
			imagenesGaleria() {
				return this.$store.getters.obtenerImagenesGaleria;
			}
		}
	}
</script>
<style scoped>
	@import 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css';
</style>