<template>
	<div class="mapa">
		<l-map
		:zoom="zoom"
		:center="center"
		:opctions="mapOptions"
		>
			<l-tile-layer :url="url" :attribution="attribution" />
			<l-marker
				v-for="establecimiento in establecimientos" 
				v-bind:key="establecimiento.id"
				:lat-lng="obtenerCoordenadas(establecimiento)"
				:icon="iconoEstablecimiento(establecimiento)"
				@click="redireccionar(establecimiento.id)"
			>
				<l-tooltip>
					<div class="text-capitalize">{{ establecimiento.nombre }} - {{ establecimiento.categoria.nombre }}</div>
				</l-tooltip>
			</l-marker>		
		</l-map>	
	</div>
</template>

<script>
	import { latLng } from 'leaflet';
	import { LMap, LTileLayer, LMarker, LTooltip, LIcon } from 'vue2-leaflet';

	export default {
		components: {
			LMap, 
			LTileLayer,
			LMarker, 
			LTooltip,
			LIcon
		},
		data() {
			return {
				zoom: 13,
				center: latLng(13.6984969, -89.1917642),
				url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
				attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributos',
				currentZoom: 11.5,
				currentCenter: latLng(13.6984969, -89.1917642),
				showParagrph: false,
				mapOptions: {
					zoomSnap: 0.5
				},
				showMap: true,				
			};
		},
		created() {
			axios.get('/api/establecimientos')
				.then(respuesta => {
					this.$store.commit('AGREGAR_ESTABLECIMIENTOS', respuesta.data);
			});
		},
		computed: {
			establecimientos() {
				return this.$store.getters.obtenerEstablecimientos;
			}
		},
		methods: {
			obtenerCoordenadas(establecimiento){
				//console.log(establecimiento);
				return {
					lat: establecimiento.lat,
					lng: establecimiento.lng
				}
			},
			iconoEstablecimiento(establecimiento) {
				const { slug } = establecimiento.categoria
				return L.icon({
					iconUrl: `images/icons/${slug}.png`,
					iconSize: [40, 50]
				})
			},
			redireccionar(id){
				this.$router.push({ name: 'establecimiento', params: { id }})
			}
		},
		watch: {
			"$store.state.categoria": function(){
				axios.get('/api/' + this.$store.getters.obtenerCategoria)
					.then(respuesta => {
						this.$store.commit("AGREGAR_ESTABLECIMIENTOS", respuesta.data);
					});

			}
		}
	}
</script>
<style scoped>
	.mapa{
		height: 600px;
		width: 100%;
	}
</style>