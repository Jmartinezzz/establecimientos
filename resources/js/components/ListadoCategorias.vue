<template>
	<div>
		<nav class="navbar-dark bg-primary d-flex flex-column flex-md-row py-2 justify-content-md-center shadow-sm">
			<a 
				class="m-0 btn  btn-outline-light mx-2"
				@click="seleccionarTodos()">Todos</a>
			<a
				v-for="categoria in categorias"
				:key="categoria.id"
				class="m-0 btn  btn-outline-light mx-2 "
				@click="seleccionarCategoria(categoria)"
			>
			{{ categoria.nombre}}
				
			</a>			
		</nav>
	</div>
</template>
<script>
	export default {
		created() {
			axios.get('/api/categorias')
				.then(respuesta => {					
					this.$store.commit("AGREGAR_CATEGORIAS", respuesta.data)
				});

		},
		computed: {
			categorias(){
				return this.$store.getters.obtenerCategorias;
			}
		},
		methods: {
			seleccionarCategoria(categoria){				
				this.$store.commit("SELECCIONAR_CATEGORIA", categoria.slug);				
			},
			seleccionarTodos(){
				axios.get('/api/establecimientos')
					.then( respuesta => {						
						this.$store.commit('AGREGAR_ESTABLECIMIENTOS', respuesta.data);
					});
			}
		}

	}
</script>