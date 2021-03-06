<template>
	<div class="container my-4">
		<h2 class="text-primary font-weight-bolder">Cafés</h2>
		<div class="row">
			<div class="col-md-3 mt-3" v-for="cafe in this.cafes" v-bind:key="cafe.id">
				<div class="card">
					<img class="card-img-top" :src="`storage/${cafe.img_principal}`" alt="card del restaurante">
					<div class="card-body">						
						<h3 class="card-title text-primary text-capitalize">
							{{ cafe.nombre }} 
						</h3>
						<p class="card-text">{{ cafe.direccion }}</p>
						<p class="card-text">
							<span class="font-weight-bold">Horario: </span>
							{{ cafe.apertura }} - {{ cafe.cierre }}
						</p>
						<router-link :to="{name: 'establecimiento', params: { id : cafe.id}}">
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
			axios.get('api/categorias/cafes')
				.then(respuesta => {
					this.$store.commit("AGREGAR_CAFES", respuesta.data);
				});
		},
		computed: {
			cafes(){
				return this.$store.state.cafes;
			}
		}
	}
</script>