// import
import { OpenStreetMapProvider } from 'leaflet-geosearch';

// setup
const provider = new OpenStreetMapProvider();

document.addEventListener('DOMContentLoaded', () => {
	
    if (document.querySelector('#mapa')){
    	let lat = document.querySelector('#lat').value === '' ? 13.6984969 : document.querySelector('#lat').value;
    	let lng = document.querySelector('#lng').value === '' ? -89.1917642 : document.querySelector('#lng').value;	    
	    const mapa = L.map('mapa').setView([lat, lng], 16);

	    //eliminar pines previos
	    let markers = new L.FeatureGroup().addTo(mapa);

		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(mapa);

	    let marker = new L.marker([lat, lng], {
	    	draggable: true,
	    	autoPan: true
	    }).addTo(mapa);

	    //agregar el pin a capas
	    markers.addLayer(marker);

	    // geocode service
	    const geocodeService = L.esri.Geocoding.geocodeService();

	    //buscador de direcciones
	    const buscador = document.querySelector('#formbuscador');
	    buscador.addEventListener('blur', buscarDireccion);

	    reubicarPin(marker);

	    function reubicarPin(marker){
	    	// detectar movimeinto del marker
		    marker.on('moveend', function(e){
		    	marker = e.target;
		    	const posicion = marker.getLatLng();
		    	document.querySelector('#lat').value = posicion.lat || '';
		    	document.querySelector('#lng').value = posicion.lng || '';

		    	// centrar automaticamente luego de mover
		    	mapa.panTo(new L.LatLng(posicion.lat, posicion.lng));

		    	//reverse geocoding no sirve
		    	geocodeService.reverse().latlng(posicion, 16).run(function(error, resultado,respuesta){
		    		
		    		console.log( error);
		    		
		    		marker.bindPopup(respuesta.address.LongLabel).openPopup();
		    		//marker.openPopup();
		    		llenarInputs(resultado);
		    	});	    	
		    });
	    }

	    function buscarDireccion(e){
	    	if(e.target.value.length > 10){
	    		// hay que isntalar leaflet-geosearch
	    		provider.search({query: e.target.value + ' San salvador SV'})
	    			.then(resultado => {
	    				if(resultado){	
	    					//limpiar pines previos
	    					markers.clearLayers();   					
					    	geocodeService.reverse().latlng(resultado[0].bounds[0], 16).run(function(error, resultado,respuesta){
						    	//llenar inputs
						    	llenarInputs(resultado);
						    	//centar mapa
						    	mapa.setView(resultado.latlng);
						    	//agregar y mover el pin
						    	marker = new L.marker(resultado.latlng, {
							    	draggable: true,
							    	autoPan: true
							    }).addTo(mapa);

							    //asignar el contenedor de markers el nuevo pin
							    markers.addLayer(marker);

							    //mover el pin
							     reubicarPin(marker);
					    	});	 
	    				}
	    			})
	    			.catch(error => {
	    				console.log(error);
	    			})
	    	}	    	
	    }

	    function llenarInputs(resultado){
	    	document.querySelector('#direccion').value = resultado.address.Address || '';
	    	document.querySelector('#colonia').value = resultado.address.Neighborhood || '';
	    	document.querySelector('#lat').value = posicion.lat || '';
	    	document.querySelector('#lng').value = posicion.lng || '';
	    }
    }

});
