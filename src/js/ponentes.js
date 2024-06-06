(function () {
    const ponentesInput = document.querySelector('#ponentes');
    if (ponentesInput) {
        let ponentes = [];
        let ponentesFiltrados = [];

        obtenerPonentes();

        ponentesInput.addEventListener('input', buscarPonentes);

        async function obtenerPonentes() {
            const url = '/api/ponentes';
            const respuesta = await fetch(url);
            resultado = await respuesta.json();
            formatearPonentes(resultado);
        }

        function formatearPonentes(arrayPonentes = []) {
            ponentes = arrayPonentes.map(ponente =>{
                return {
                    nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id: ponente.id
                }
            })
        }

        function buscarPonentes(e) {
           const busqueda = e.target.value;
           if(busqueda.lenght > 3) {
            //Expresion regular para buscar coincidencias
            const expresion = new RegExp(busqueda, 'i');
           }
        }
    }
})();