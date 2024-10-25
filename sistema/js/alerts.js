document.getElementById('registro_aprendiz').addEventListener('submit', function(event) {
    event.preventDefault(); 


    var nomb_apre = document.getElementById('nomb_apre').value;
    var apell_apre = document.getElementById('apell_apre').value;
    var tip_doc = document.getElementById('tip_doc').value;
    var doc_apre = document.getElementById('doc_apre').value;
    var correo = document.getElementById('correo').value;
    var nombre = document.getElementById('nombre').value;
    var num_fich = document.getElementById('num_fich').value;
    
    

    if (nomb_apre === '') {
        Swal.fire({
            title: 'Falta información',
            text: 'Por favor, ingrese el nombre del aprendiz',
            icon: 'info'
        });
        return; 
    }

    if (apell_apre === '') {
        Swal.fire({
            title: 'Falta información',
            text: 'Por favor, ingrese apellido del aprendiz',
            icon: 'info'
        });
        return; 
    }
    if (tip_doc === 'Seleccione') {
        Swal.fire({
            title: 'Falta información',
            text: 'Por favor, documento no puede ser seleccióne',
            icon: 'info'
        });
        return; 
    }
    if (doc_apre === '') {
        Swal.fire({
            title: 'Falta información',
            text: 'Por favor, ingrese el documento del aprendiz',
            icon: 'info'
        });
        return; 
    }
    if (correo === '') {
        Swal.fire({
            title: 'Falta información',
            text: 'Por favor, ingrese el documento del aprendiz',
            icon: 'info'
        });
        return; 
    }
    if (correo === '') {
        Swal.fire({
            title: 'Falta información',
            text: 'Por favor, ingrese el correo del aprendiz',
            icon: 'info'
        });
        return; 
    }
    if (nombre === '1') {
        Swal.fire({
            title: 'Falta información',
            text: 'Por favor, Seleccione un instructor',
            icon: 'info'
        });
        return; 
    }
    if (num_fich === '11') {
        Swal.fire({
            title: 'Falta información',
            text: 'Por favor, Seleccione la ficha',
            icon: 'info'
        });
        return; 
    }
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Quieres crear el formulario  formulario?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "OK"
    }).then((result) => {
        if (result.isConfirmed) {
          
 
            Swal.fire({
                title: "Exitoso",
                text: "Aprendiz registrado exitosamente",
                icon: "success"
            }).then(() => {
                document.getElementById('registro_aprendiz').submit();
            });
        }
    });
});

//tufucar la exponencia de la red 120.0.2.23 en el puerto de la municipal de as d sññs 2¿¿¿mb  ´´ptnt()
//229u34u5  s  poty t resetr == 1023v  


