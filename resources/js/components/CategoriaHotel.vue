<template>
	<div class="container my-4">
		<h2 class="text-primary font-weight-bolder">Hoteles</h2>
		<div class="row">
			<div class="col-md-3 mt-3" v-for="hotel in this.hoteles" v-bind:key="hotel.id">
				<div class="card">
					<img class="card-img-top" :src="`storage/${hotel.img_principal}`" alt="card del restaurante">
					<div class="card-body">						
						<h3 class="card-title text-primary text-capitalize">
							{{ hotel.nombre }}
						</h3>
						<p class="card-text">{{ hotel.direccion }}</p>
						<p class="card-text">
							<span class="font-weight-bold">Horario: </span>
							{{ hotel.apertura }} - {{ hotel.cierre }}
						</p>
						<router-link :to="{name: 'establecimiento', params: { id : hotel.id}}">
							<a class="btn btn-primary d-block text-white">Ver Lugar</a>	
						</router-link>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {		
		mounted(){
			axios.get('api/categorias/hoteles')
				.then(respuesta => {
					this.$store.commit("AGREGAR_HOTELES", respuesta.data);
				});
		},
		computed:{
			hoteles(){
				return this.$store.state.hoteles;
			}
		}
	}
</script>