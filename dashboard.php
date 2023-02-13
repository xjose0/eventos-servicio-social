<?php

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    $logged = $_SESSION['logged'];
    if($logged == 0){
        header('location: login.php');
    }

    if(isset($_GET['contenido'])){
        $contenido = $_GET['contenido'];
    } else{
        $contenido = "bienvenida.php";
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/fullcalendar/locales/es.js"></script>
    <link href='./js/fullcalendar/main.css' rel='stylesheet' />
    <script src='./js/fullcalendar/main.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <script>
    function limpiarModal() {
        document.querySelector('input[name="title"]').value = '';
        document.querySelector('input[name="start"]').value = '';
        document.querySelector('input[name="end"]').value = '';
        document.querySelector('input[name="expositor"]').value = '';
        document.querySelector('select[name="tipo_evento"]').value = '';
        document.querySelector('select[name="sede"]').value = '';
        document.querySelector('select[name="programa"]').value = '';
    }

    function getDateWithoutTime(dt) {
        dt.setHours(0, 0, 0, 0);
        return dt;
    }

    var calendar;
    var selectedDate;
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {

            //Alinear botones del encabezado
            headerToolbar: {
                right: 'dayGridMonth,timeGridWeek,timeGridDay',
                center: 'title',
                left: 'prevYear,prev,next,nextYear'
            },

            //Idioma español
            locale: "es",
            selectable: true,
            views: {
                dayGridMonth: {
                    buttonText: 'Mes'
                },
                timeGridWeek: {
                    buttonText: 'Semana'
                },
                timeGridDay: {
                    buttonText: 'Día'
                }
            },

            //Abrir modal cuando se da click en un dia
            dateClick: function(info) {

                var clickedDate = getDateWithoutTime(info.date);
                var nowDate = getDateWithoutTime(new Date())
                if (clickedDate >= nowDate) {
                    selectedDate = info.dateStr;
                    limpiarModal();
                    modelAgregar.show();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Aviso',
                        text: 'No puedes agregar eventos en una fecha pasada',
                        timer: 1800,
                        timerProgressBar: true
                    });
                    Swal.showLoading();
                }
            },

            //Abrir eventos de la consulta a MySQL
            events: 'http://localhost:8080/EventosUas/eventosCalendario.php',
            eventColor: '#164686',
            eventTextColor: '#ffffff',
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit'
            },
            eventTitleFormat: {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },

            //Abrir modal cuando se da click en un evento
            eventClick: function(info) {

                // Titulo del evento en el modal
                document.querySelector('#nombreEvento').innerHTML = info.event.title;

                // Mostrar la información del evento en los inputs
                document.querySelector('#txtID').value = info.event.extendedProps.id_evento;
                document.querySelector('#title2').value = info.event.title;
                document.querySelector('#expositor2').value = info.event.extendedProps.expositor;

                let fechaHoraInicio = new Date(info.event.start);
                fechaHoraInicio.setHours(fechaHoraInicio.getHours() - 7);
                document.querySelector('#start2').value = fechaHoraInicio.toISOString().substring(0,
                    16);

                let fechaHoraFin = new Date(info.event.end);
                fechaHoraFin.setHours(fechaHoraFin.getHours() - 7);
                document.querySelector('#end2').value = fechaHoraFin.toISOString().substring(0, 16);

                document.querySelector('#sede2').value = info.event.extendedProps.sede;
                document.querySelector('#programa2').value = info.event.extendedProps.programa;
                document.querySelector('#tipo_evento2').value = info.event.extendedProps
                    .tipo_evento;

                const txtID = info.event.extendedProps.id_evento;
                const tableBody = document.querySelector('#tablaAsistentes');

                // Enviar id a php para guardarlo en variable session
                fetch('guardar_id_evento.php', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + txtID,
                });

                // Cargar asistentes
                fetch('cargar_asistentes.php', {
                        method: 'POST',
                        body: JSON.stringify({
                            id: txtID
                        }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        return response.json();
                    })
                    .then(asistentes => {
                        // Limpiar la tabla
                        tableBody.innerHTML = '';

                        // Iterar sobre los asistentes y agregarlos a la tabla
                        asistentes.forEach(asistente => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                        <td>${asistente.nombre}</td>
                        <td>${asistente.grupo}</td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarAsistente(${asistente.id})"><i class="fa-solid fa-trash"></i></button></td>
                        `;
                            tableBody.appendChild(tr);
                        });
                    });


                model.show();

            }
        });
        calendar.render();
        window.calendar = calendar;

        // Cargar sedes en select
        fetch('cargar_sedes.php')
            .then(response => response.json())
            .then(sedes => {
                // Itera sobre las sedes y agrega cada una como una opción en el select
                sedes.forEach(sede => {
                    const option = document.createElement('option');
                    option.value = sede.id;
                    option.text = sede.nombre;
                    document.querySelector('select[name="sede"]').appendChild(option);
                });
            });


        // Cargar sedes en select modificar
        fetch('cargar_sedes.php')
            .then(response => response.json())
            .then(sedes => {
                // Itera sobre las sedes y agrega cada una como una opción en el select
                sedes.forEach(sede => {
                    const option = document.createElement('option');
                    option.value = sede.id;
                    option.text = sede.nombre;
                    document.querySelector('select[name="sede2"]').appendChild(option);
                });
            });

        // Cargar programas en select
        fetch('cargar_programas.php')
            .then(response => response.json())
            .then(programas => {
                // Itera sobre los programas y agrega cada uno como una opción en el select
                programas.forEach(programa => {
                    const option = document.createElement('option');
                    option.value = programa.id;
                    option.text = programa.nombre;
                    document.querySelector('select[name="programa"]').appendChild(option);
                });
            });

        // Cargar programas en select modificar
        fetch('cargar_programas.php')
            .then(response => response.json())
            .then(programas => {
                // Itera sobre los programas y agrega cada uno como una opción en el select
                programas.forEach(programa => {
                    const option = document.createElement('option');
                    option.value = programa.id;
                    option.text = programa.nombre;
                    document.querySelector('select[name="programa2"]').appendChild(option);
                });
            });

    });
    </script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Eventos UAS</title>
</head>

<body>

    <nav class="navbar navbar-dark py-3 navbar-expand-lg bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand px-5 pe-5" href="dashboard.php"><img src="./assets/logos.png" class="" alt="UAS"
                    height="70"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item pe-5">
                        <a class="nav-link" aria-current="page" href="dashboard.php">Inicio</a>
                    </li>
                    <li class="nav-item pe-5">
                        <a class="nav-link" href="dashboard.php?contenido=sedes.php">Sedes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php?contenido=programas.php">Programas</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <form action="crud.php" method="post">
                        <button type="submit" class="btn btn-danger" name="btnCerrarSesion">Cerrar sesion</button>
                    </form>
                </span>
            </div>
        </div>
    </nav>

    <div class="bg-warning py-1">

    </div>

    <div class="shadow-lg rounded-4 m-5 p-4 mt-3 bg-light">
        <?php include_once($contenido); ?>
    </div>

    <footer
        style="background-image: url('./assets/wave.svg'); background-repeat: no-repeat; background-position: center; background-size: cover; height: 238px; margin-top: 110px;"
        class="">

    </footer>

    <!-- Modal Agregar-->
    <div class="modal fade" id="agregarEvento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content p-4">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="">Agregar evento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Expositor</label>
                            <input type="text" class="form-control" name="expositor">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hora de inicio</label>
                            <input type="time" class="form-control" name="start">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha y hora de terminación</label>
                            <input type="datetime-local" class="form-control" name="end">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo de evento</label>
                            <select class="form-select" aria-label="Default select example" name="tipo_evento">
                                <option selected disabled>Selecciona una opción</option>
                                <option value="Concurso">Concurso</option>
                                <option value="Conferencia">Conferencia</option>
                                <option value="Ponencia">Ponencia</option>
                                <option value="Demostración de laboratorio">Demostración de laboratorio</option>
                                <option value="Recorrido virtual">Recorrido virtual</option>
                                <option value="Cartel de investigación">Cartel de investigación</option>
                                <option value="Exposición">Exposición</option>
                                <option value="Foro">Foro</option>
                                <option value="Panel">Panel</option>
                                <option value="Coloquio">Coloquio</option>
                                <option value="Taller">Taller</option>
                                <option value="Conversatorio">Conversatorio</option>
                                <option value="Visita guiada">Visita guiada</option>
                                <option value="Actividad cultural">Actividad cultural</option>
                                <option value="Actividad deportiva">Actividad deportiva</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sede</label>
                            <select class="form-select" aria-label="Default select example" name="sede">
                                <option selected disabled>Selecciona una opción</option>
                            </select>
                            <input type="hidden" name="facultad" value="<?php echo $_SESSION['facultad'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Programa</label>
                            <select class="form-select" aria-label="Default select example" name="programa">
                                <option selected disabled>Selecciona una opción</option>
                            </select>
                        </div>
                        <input type="hidden" name="facultad" value="<?php $_SESSION['facultad_usuario'] ?>">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" name="btnAgregar" onclick="saluda()">Agregar</button>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>

        <script>
        let eventData;

        function saluda() {
            recolectarDatos();
            console.log(eventData);
            enviarInformacion('agregar', eventData)
        }

        function recolectarDatos() {
            var start = new Date(selectedDate + "T" + document.querySelector('input[name="start"]').value);
            var end = new Date(document.querySelector('input[name="end"]').value);
            eventData = {
                title: document.querySelector('input[name="title"]').value,
                start: start.getFullYear() + "-" + (start.getMonth() + 1) + "-" + start.getDate() + " " + start
                    .getHours() + ":" + start.getMinutes() + ":00",
                end: end.getFullYear() + "-" + (end.getMonth() + 1) + "-" + end.getDate() + " " + end.getHours() +
                    ":" + end.getMinutes() + ":00",
                expositor: document.querySelector('input[name="expositor"]').value,
                tipo_evento: document.querySelector('select[name="tipo_evento"]').value,
                sede: document.querySelector('select[name="sede"]').value,
                facultad: document.querySelector('input[name="facultad"]').value,
                programa: document.querySelector('select[name="programa"]').value
            };
        }


        function enviarInformacion(accion, objEvento) {
            $.ajax({
                type: 'POST',
                url: 'eventosCalendario.php?accion=' + accion,
                data: objEvento,
                success: function(msg) {
                    if (msg) {
                        //calendar.addEvent(eventData);
                        calendar.refetchEvents();
                        modelAgregar.hide();
                        Swal.fire({
                            icon: 'success',
                            text: 'Evento agregado',
                            timer: 1500,
                            timerProgressBar: true
                        });
                    }
                },
                error() {
                    alert("Hay un error al agregar");
                }
            });
        }
        </script>

    </div>

    <script>
    // Crear variable para el modal de agregar
    var modelAgregar = new bootstrap.Modal(document.getElementById('agregarEvento'), {
        keyboard: false
    });
    </script>


    <!-- Modal Modificar-->
    <div class="modal fade" id="modificarEvento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content p-4">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="nombreEvento"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <form>
                            <input type="hidden" name="txtID" id="txtID">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="title2" id="title2">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Expositor</label>
                                <input type="text" class="form-control" name="expositor2" id="expositor2">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fecha y hora de inicio</label>
                                <input type="datetime-local" class="form-control" name="start2" id="start2">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fecha y hora de terminación</label>
                                <input type="datetime-local" class="form-control" name="end2" id="end2">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tipo de evento</label>
                                <select class="form-select" aria-label="Default select example" name="tipo_evento2"
                                    id="tipo_evento2">
                                    <option selected disabled>Selecciona una opción</option>
                                    <option value="Concurso">Concurso</option>
                                    <option value="Conferencia">Conferencia</option>
                                    <option value="Ponencia">Ponencia</option>
                                    <option value="Demostración de laboratorio">Demostración de laboratorio</option>
                                    <option value="Recorrido virtual">Recorrido virtual</option>
                                    <option value="Cartel de investigación">Cartel de investigación</option>
                                    <option value="Exposición">Exposición</option>
                                    <option value="Foro">Foro</option>
                                    <option value="Panel">Panel</option>
                                    <option value="Coloquio">Coloquio</option>
                                    <option value="Taller">Taller</option>
                                    <option value="Conversatorio">Conversatorio</option>
                                    <option value="Visita guiada">Visita guiada</option>
                                    <option value="Actividad cultural">Actividad cultural</option>
                                    <option value="Actividad deportiva">Actividad deportiva</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sede</label>
                                <select class="form-select" aria-label="Default select example" name="sede2" id="sede2">
                                    <option selected disabled>Selecciona una opción</option>
                                </select>
                                <input type="hidden" name="facultad2" value="<?php echo $_SESSION['facultad'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Programa</label>
                                <select class="form-select" aria-label="Default select example" name="programa2"
                                    id="programa2">
                                    <option selected disabled>Selecciona una opción</option>
                                </select>
                            </div>
                        </form>
                        <div class="modal-participantes mt-4 card p-4">
                            <label class="form-label">Listado de participantes</label>
                            <table class="table table-hover table-bordered" id="tablaPDF">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Grupo</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaAsistentes">

                                </tbody>
                            </table>
                            <form method="post" action="">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Apellido paterno</label>
                                    <input type="text" class="form-control" id="apellido_paterno"
                                        name="apellido_paterno">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Apellido materno</label>
                                    <input type="text" class="form-control" id="apellido_materno"
                                        name="apellido_materno">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Grupo</label>
                                    <input type="text" class="form-control" id="grupo" name="grupo">
                                </div>
                                <div>
                                    <button type="button" class="btn btn-outline-success w-100" id="agregarAsistente"
                                        name="agregarAsistente" onclick="submitForm()">Agregar
                                        participante</button>
                                </div>
                            </form>
                            <div>
                                <button type="button" class="btn btn-outline-info w-100 mt-1" id="imprimirReporte" name="imprimirReporte" onclick="imprimirReporte()">Imprimir reporte</button>
                            </div>
                            <script>
                            function submitForm() {
                                const nombre = document.getElementById("nombre").value;
                                const apellido_paterno = document.getElementById("apellido_paterno").value;
                                const apellido_materno = document.getElementById("apellido_materno").value;
                                const grupo = document.getElementById("grupo").value;

                                const tableBody = document.getElementById('tablaAsistentes');

                                fetch("agregar_asistente.php", {
                                        method: "post",
                                        headers: {
                                            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                                        },
                                        body: `nombre=${nombre}&apellido_paterno=${apellido_paterno}&apellido_materno=${apellido_materno}&grupo=${grupo}`
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log("Success:", data);
                                        // Cargar asistentes
                                        fetch('cargar_asistentes.php', {
                                                method: 'POST',
                                                body: JSON.stringify({
                                                    //id: txtID
                                                }),
                                                headers: {
                                                    'Content-Type': 'application/json'
                                                }
                                            })
                                            .then(response => {
                                                return response.json();
                                            })
                                            .then(asistentes => {
                                                // Limpiar la tabla
                                                tableBody.innerHTML = '';

                                                // Iterar sobre los asistentes y agregarlos a la tabla
                                                asistentes.forEach(asistente => {
                                                    const tr = document.createElement('tr');
                                                    tr.innerHTML = `
                                                <td>${asistente.nombre}</td>
                                                <td>${asistente.grupo}</td>
                                                <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarAsistente(${asistente.id})"><i class="fa-solid fa-trash"></i></button></td>
                                                `;
                                                    tableBody.appendChild(tr);
                                                });
                                            });
                                    })
                                    .catch(error => {
                                        console.error("Error:", error);
                                    });

                                    document.querySelector('input[name="nombre"]').value = '';
                                    document.querySelector('input[name="apellido_paterno"]').value = '';
                                    document.querySelector('input[name="apellido_materno"]').value = '';
                                    document.querySelector('input[name="grupo"]').value = '';
                            }

                            function eliminarAsistente(id) {
                                const tableBody = document.getElementById('tablaAsistentes');
                                fetch("eliminar_asistente.php", {
                                    method: "post",
                                    headers: {
                                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                                    },
                                    body: `id=${id}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log("Success:", data);
                                    fetch('cargar_asistentes.php', {
                                        method: 'POST',
                                        body: JSON.stringify({
                                            id: txtID
                                        }),
                                        headers: {
                                            'Content-Type': 'application/json'
                                        }
                                    })
                                    .then(response => {
                                        return response.json();
                                    })
                                    .then(asistentes => {
                                        // Limpiar la tabla
                                        tableBody.innerHTML = '';

                                        // Iterar sobre los asistentes y agregarlos a la tabla
                                        asistentes.forEach(asistente => {
                                            const tr = document.createElement('tr');
                                            tr.innerHTML = `
                                        <td>${asistente.nombre}</td>
                                        <td>${asistente.grupo}</td>
                                        <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarAsistente(${asistente.id})"><i class="fa-solid fa-trash"></i></button></td>
                                        `;
                                            tableBody.appendChild(tr);
                                        });
                                    });
                                })
                                .catch(error => {
                                    console.error("Error:", error);
                                });
                            }

                            function imprimirReporte() {
                                var eventName = document.getElementById("nombreEvento").innerHTML;
                                var table = document.getElementById("tablaAsistentes");
                                var style = "<style>";
                                style += "table {width: 100%; font: 17px Calibri;}";
                                style += "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
                                style += "padding: 2px 3px;text-align: center;}";
                                style += "</style>";

                                var win = window.open("", "", "height=700,width=700");
                                win.document.write("<html><head>");
                                win.document.write('<title>' + eventName + '</title>');
                                win.document.write(style);
                                win.document.write("</head>");
                                win.document.write("<body>");
                                win.document.write("<table>");
                                win.document.write("<thead>");
                                win.document.write("<tr>");
                                win.document.write("<th scope='col'>Nombre</th>");
                                win.document.write("<th scope='col'>Grupo</th>");
                                win.document.write("</tr>");
                                win.document.write("</thead>");
                                win.document.write("<tbody>");

                                for (let i = 0; i < table.rows.length; i++) {
                                    win.document.write("<tr>");
                                    win.document.write("<td>" + table.rows[i].cells[0].innerHTML + "</td>");
                                    win.document.write("<td>" + table.rows[i].cells[1].innerHTML + "</td>");
                                    win.document.write("</tr>");
                                }

                                win.document.write("</tbody>");
                                win.document.write("</table>");
                                win.document.write("</body></html>");
                                win.document.close();
                                win.print();
                            }




                            </script>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="btnModificar"
                        onclick="modificarEvento()">Actualizar</button>
                    <button type="button" class="btn btn-danger" id="eliminarEvento"
                        onclick="eliminarEvento()">Eliminar</button>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
        <script>
        let eventEliminar;
        let eventModificar;

        function modificarEvento() {
            recolectarDatosModificar();
            console.log(eventModificar);
            enviarInformacionModificar('modificar', eventModificar)
        }

        function recolectarDatosModificar() {
            var start = new Date(document.querySelector('input[name="start2"]').value);
            var end = new Date(document.querySelector('input[name="end2"]').value);
            eventModificar = {
                id: document.querySelector('input[name="txtID"]').value,
                title: document.querySelector('input[name="title2"]').value,
                start: start.getFullYear() + "-" + (start.getMonth() + 1) + "-" + start.getDate() + " " + start
                    .getHours() + ":" + start.getMinutes() + ":00",
                end: end.getFullYear() + "-" + (end.getMonth() + 1) + "-" + end.getDate() + " " + end.getHours() +
                    ":" + end.getMinutes() + ":00",
                expositor: document.querySelector('input[name="expositor2"]').value,
                tipo_evento: document.querySelector('select[name="tipo_evento2"]').value,
                sede: document.querySelector('select[name="sede2"]').value,
                facultad: document.querySelector('input[name="facultad2"]').value,
                programa: document.querySelector('select[name="programa2"]').value
            };
        }

        function enviarInformacionModificar(accion, objEvento) {
            $.ajax({
                type: 'POST',
                url: 'eventosCalendario.php?accion=' + accion,
                data: objEvento,
                success: function(msg3) {
                    if (msg3) {
                        //calendar.addEvent(eventData);
                        calendar.refetchEvents();
                        model.hide();
                        Swal.fire({
                            icon: 'success',
                            text: 'Evento modificado',
                            timer: 1800,
                            timerProgressBar: true
                        });
                    }
                },
                error() {
                    alert("Hay un error al agregar");
                }
            });
        }

        function eliminarEvento() {
            recolectarId();
            console.log(eventEliminar);
            enviarInformacionEliminar('eliminar', eventEliminar)
        }

        function recolectarId() {
            eventEliminar = {
                id: document.querySelector('input[name="txtID"]').value
            }
        }

        function enviarInformacionEliminar(accion, objEvento) {
            $.ajax({
                type: 'POST',
                url: 'eventosCalendario.php?accion=' + accion,
                data: objEvento,
                success: function(msg2) {
                    if (msg2) {
                        //calendar.addEvent(eventData);
                        calendar.refetchEvents();
                        model.hide();
                        Swal.fire({
                            icon: 'success',
                            text: 'Evento eliminado',
                            timer: 1500,
                            timerProgressBar: true
                        });
                    }
                },
                error() {
                    alert("Hay un error al agregar");
                }
            });
        }
        </script>
    </div>

    <script>
    var model = new bootstrap.Modal(document.getElementById('modificarEvento'), {
        keyboard: false
    });
    </script>

    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>