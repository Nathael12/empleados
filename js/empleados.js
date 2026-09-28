document.addEventListener('DOMContentLoaded', function() {
    
    const modalAgregar = new bootstrap.Modal(document.getElementById('modalAgregar'));
    const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
    
    const formAgregar = document.getElementById('formAgregar');
    const formEditar = document.getElementById('formEditar');

    document.getElementById('btnAgregar').addEventListener('click', function() {
        formAgregar.reset();
        modalAgregar.show();
    });

    formAgregar.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(formAgregar);
        
        fetch('acciones/agregar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                modalAgregar.hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Hubo un problema de conexión', 'error');
        });
    });

    document.querySelectorAll('.btnEditar').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            fetch(`acciones/obtener.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('editId').value = data.data.id;
                        document.getElementById('editNif').value = data.data.nif;
                        document.getElementById('editNombre').value = data.data.nombre;
                        document.getElementById('editApellido1').value = data.data.apellido1;
                        document.getElementById('editApellido2').value = data.data.apellido2 || '';
                        document.getElementById('editDepartamento').value = data.data.id_departamento || '';
                        
                        modalEditar.show();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    formEditar.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(formEditar);
        
        fetch('acciones/editar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                modalEditar.hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Hubo un problema de conexión', 'error');
        });
    });

    document.querySelectorAll('.btnEliminar').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('id', id);
                    
                    fetch('acciones/eliminar.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire(
                                'Eliminado',
                                data.message,
                                'success'
                            ).then(() => {
                                document.getElementById(`fila-${id}`).remove();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Hubo un problema de conexión', 'error');
                    });
                }
            });
        });
    });

    const buscador = document.getElementById('buscador');
    if (buscador) {
        buscador.addEventListener('keyup', function() {
            const texto = this.value.toLowerCase();
            const filas = document.querySelectorAll('#tablaEmpleados tbody tr');
            
            filas.forEach(fila => {
                const contenido = fila.textContent.toLowerCase();
                if (contenido.includes(texto)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    }

});