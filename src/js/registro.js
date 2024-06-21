import Swal from 'sweetalert2';
(function () {
    let eventos = [];
    const resumen = document.querySelector('.registro__resumen');

    const eventosBtn = document.querySelectorAll('.evento__agregar');
    eventosBtn.forEach(boton => boton.addEventListener('click', seleccionarEvento));

    function seleccionarEvento(e) {

        if (eventos.length < 5) {

            //Deshabilitar el evento
            e.target.disabled = true;
            eventos = [...eventos, {
                id: e.target.dataset.id,
                titulo: e.target.parentElement.querySelector('.evento__nombre').textContent.trim()
            }]
            //Mostrar eventos
            mostrarEventos();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Solo puedes seleccionar hasta 5 eventos',
                confirmButtonText: 'OK'
            })
        }
    }

    function mostrarEventos() {
        //limpiar HTML

        limpiarEventos();

        if (eventos.length > 0) {
            eventos.forEach(evento => {
                const eventoDOM = document.createElement('DIV');
                eventoDOM.classList.add('registro__evento');

                const titulo = document.createElement('H3');
                titulo.classList.add = 'registro__nombre';
                titulo.textContent = evento.titulo;

                const botonEliminar = document.createElement('BUTTON');
                botonEliminar.classList.add('registro__eliminar');
                botonEliminar.innerHTML = `<li class="fa-solid fa-trash"></li>`;
                botonEliminar.onclick = function () {
                    eliminarEvento(evento.id);
                }

                //Renderizar en el HTML
                eventoDOM.appendChild(titulo);
                eventoDOM.appendChild(botonEliminar);
                resumen.appendChild(eventoDOM);
            })
        }
    }

    function eliminarEvento(id) {
        eventos = eventos.filter(evento => evento.id !== id);
        mostrarEventos();

        const botonAgregar = document.querySelector(`[data-id="${id}"]`);
        botonAgregar.disabled = false;
    }

    function limpiarEventos() {
        while (resumen.firstChild) {
            resumen.removeChild(resumen.firstChild);
        }
    }
})();