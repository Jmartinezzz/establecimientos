<template>
	<div class="container my-5">
		<h2 class="text-capitalize font-weight-bold text-primary mb-3">{{ establecimiento.nombre }}</h2>
		<div class="row align-items-start">
			<div class="col-md-7">
				<img 
					class="img-fluid rounded" 
				    :src="`../storage/${establecimiento.img_principal}`" 
				    alt="Imagén del establecimiento">
				<h4 class="mt-4 ">{{ establecimiento.descripcion }}</h4>
				<galeria-imagenes 
					:nombre-establecimiento="`${ establecimiento.nombre }`">
				</galeria-imagenes>
			</div>
			<div class="col-md-4 offset-md-1">
				<div class="rounded-top">
					<mapa-ubicacion></mapa-ubicacion>
				</div>
				<div class="p-4 bg-primary rounded-bottom">
					<h2 class="text-center text-white mt-2 mb-4">
						Más Información
					</h2>
					<p class="text-white">
						<span class="font-weight-bold">Ubicación:</span>
						{{ establecimiento.direccion }}
					</p>
					<p class="text-white">
						<span class="font-weight-bold">Colonia:</span>
						{{ establecimiento.colonia }}
					</p>
					<p class="text-white">
						<span class="font-weight-bold">Horario:</span>
						{{ establecimiento.apertura }} - {{ establecimiento.cierre }}
					</p>
					<p class="text-white">
						<span class="font-weight-bold">Teléfono:</span>
						{{ establecimiento.telefono }}
					</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import MapaUbicacion from './MapaUbicacion';
	import GaleriaImagenes from './GaleriaImagenes';
	export default {

		components:{
			MapaUbicacion,
			GaleriaImagenes
		},
		mounted() {
			let { id } = this.$route.params;			

			axios.get('/api/establecimientos/' + id)
				.then(respuesta => {
					this.$store.commit("AGREGAR_ESTABLECIMIENTO", respuesta.data);
				})
		},
		computed: {
			establecimiento(){
				return this.$store.getters.obtenerEstablecimiento
			}
		}
	}
</script>