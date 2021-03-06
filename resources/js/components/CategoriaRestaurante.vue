<template>
	<div class="container my-4">
		<h2 class="text-primary font-weight-bolder">Restaurantes</h2>
		<div class="row">
			<div class="col-md-3 mt-3" v-for="restaurante in this.restaurantes" v-bind:key="restaurante.id">
				<div class="card">
					<img class="card-img-top" :src="`storage/${restaurante.img_principal}`" alt="card del restaurante">
					<div class="card-body">						
						<h3 class="card-title text-primary text-capitalize">
							{{ restaurante.nombre }}
						</h3>
						<p class="card-text">{{ restaurante.direccion }}</p>
						<p class="card-text">
							<span class="font-weight-bold">Horario: </span>
							{{ restaurante.apertura }} - {{ restaurante.cierre }}
						</p>
						<router-link :to="{name: 'establecimiento', params: { id : restaurante.id}}">
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
			axios.get('api/categorias/restaurantes')
				.then(respuesta => {
					this.$store.commit("AGREGAR_RESTAURANTES", respuesta.data);
				});
		},
		computed:{
			restaurantes(){
				return this.$store.state.restaurantes;
			}
		}
	}
</script>