
document.addEventListener('DOMContentLoaded', () => {

	if (document.querySelector('#dropzone')) {
		Dropzone.autoDiscover = false;
		const dropzone = new Dropzone('div#dropzone', {
			url: '/imagenes/store',
			dictDefaultMessage: 'Sube hasta 10 imágenes',
			maxFiles: 10,
			require: true,
			acceptedFiles: ".jpg,.png,.jpeg",
			addRemoveLinks: true,
			dictRemoveFile: "Eliminar",
			headers: {
				'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
			},
			init: function() {
				const galeria = document.querySelectorAll('.galeria');
				if (galeria.length > 0) {
					galeria.forEach(imagen =>{
						const imagenPublicada = {};
						imagenPublicada.size = 1;
						imagenPublicada.name = imagen.value;
						imagenPublicada.nombreServidor = imagen.value;

						this.options.addedfile.call(this, imagenPublicada);
						this.options.thumbnail.call(this, imagenPublicada, `/storage/${imagenPublicada.name}`);

						imagenPublicada.previewElement.classList.add('dz-success');
						imagenPublicada.previewElement.classList.add('dz-complete');
					})
				}
			},
			success: function(file, respuesta){
				file.nombreServidor = respuesta.archivo;

			},
			sending: function(file, xhr, formData){
				//cuando se está suviendo la imagen 
				formData.append('uuid', document.querySelector('#uuid').value);
			},
			removedfile: function(file, respuesta){
				const params = {
					imagen: file.nombreServidor,
					uuid: document.querySelector('#uuid').value
				}
				axios.post('/imagenes/destroy', params)
					.then(respuesta => {						
						console.log("respuesta", respuesta);
						file.previewElement.parentNode.removeChild(file.previewElement);

				});

			}
		});
	}
	
});