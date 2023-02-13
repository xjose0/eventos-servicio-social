<div class="container mb-5">

    <div class="alerta">
        <?php
            if(isset($_SESSION['sedeAgregada'])){
        ?>
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Sede agregada',
            showConfirmButton: true,
            timer: 1500,
            timerProgressBar: true
        });
        </script>
        <?php
                unset($_SESSION['sedeAgregada']);
            }
        ?>

        <?php
            if(isset($_SESSION['sedeModificada'])){
        ?>
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Sede modificada',
            showConfirmButton: true,
            timer: 1500,
            timerProgressBar: true
        });
        </script>
        <?php
                unset($_SESSION['sedeModificada']);
            }
        ?>

        <?php
            if(isset($_SESSION['sedeEliminada'])){
        ?>
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Sede eliminada',
            showConfirmButton: true,
            timer: 1500,
            timerProgressBar: true
        });
        </script>
        <?php
                unset($_SESSION['sedeEliminada']);
            }
        ?>
    </div>

    <h2 class="text-center mb-5">Listado de sedes</h2>
    <div class="row">
        <div class="col-4">
            <h4 class="mb-4">Agregar Sede</h4>
            <form action="crud.php" method="post">
                <div class="mb-3">
                    <label for="nombreSede" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombreSede" name="nombreSede">
                </div>
                <div class="mb-3">
                    <label for="capacidadSede" class="form-label">Capacidad</label>
                    <input type="number" class="form-control" id="capacidadSede" name="capacidadSede">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Selecciona el lugar de la sede</label>
                    <select class="form-select" aria-label="" name="facultadSede">
                        <option selected disabled></option>
                        <option value="<?php echo $_SESSION['facultad']; ?>">Facultad</option>
                        <option value="3">Vicerrectoria</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-warning w-100" name="btnAgregarSede">Agregar</button>
            </form>
        </div>
        <div class="col-4">
            <h4 class="mb-4">Sedes facultad</h4>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Capacidad</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        require_once("config.php");
                        $facultad = $_SESSION['facultad'];
                        $sqlselect = "SELECT * FROM sedes WHERE facultad = '$facultad'";
                        $datos = $conexion->query($sqlselect);

                        while ($fila = mysqli_fetch_array($datos)){
                    ?>

                    <tr>
                        <td> <?php echo $fila['id_sede']; ?> </td>
                        <td> <?php echo $fila['nombre']; ?> </td>
                        <td> <?php echo $fila['capacidad']; ?> </td>

                        <form action="crud.php" method="post"
                            onsubmit="return confirm ('¿Estás seguro que deseas borrar la sede?')">
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" title="Modificar"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modificarSede<?php echo $fila['id_sede']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button type="submit" name="btnEliminarSede" title="Eliminar"
                                    class="btn btn-danger btn-sm"> <i class="fa-solid fa-trash"></i> </button>
                                <input type="hidden" value="<?php echo $fila['id_sede']; ?>" name="idEliminar">
                            </td>
                        </form>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="modificarSede<?php echo $fila['id_sede']; ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static"
                        data-bs-keyboard="false">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content p-4">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar sede</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <form action="crud.php" method="post">
                                        <div class="mb-3">
                                            <input type="hidden" name="id_sede" class="form-control"
                                                value="<?php echo $fila['id_sede']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nombre</label>
                                            <input type="text" name="nombre" class="form-control"
                                                value="<?php echo $fila['nombre']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Capacidad</label>
                                            <input type="text" name="capacidad" class="form-control"
                                                value="<?php echo $fila['capacidad']; ?>" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-info"
                                                name="btnModificarSede">Modificar</button>
                                            <button type="button" class="btn btn-outline-danger"
                                                data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-4">
            <h4 class="mb-4">Sedes vicerrectoria</h4>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Capacidad</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        require_once("config.php");
                        $sql = "SELECT * FROM sedes WHERE facultad = 3";
                        $datos2 = $conexion->query($sql);

                        while ($row = mysqli_fetch_array($datos2)){
                    ?>

                    <tr>
                        <td> <?php echo $row['id_sede']; ?> </td>
                        <td> <?php echo $row['nombre']; ?> </td>
                        <td> <?php echo $row['capacidad']; ?> </td>

                        <form action="crud.php" method="post"
                            onsubmit="return confirm ('¿Estás seguro que deseas borrar la sede?')">
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" title="Modificar"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modificarSedeVicerrectoria<?php echo $row['id_sede']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button type="submit" name="btnEliminarSede" title="Eliminar"
                                    class="btn btn-danger btn-sm"> <i class="fa-solid fa-trash"></i> </button>
                                <input type="hidden" value="<?php echo $row['id_sede']; ?>" name="idEliminar">
                            </td>
                        </form>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="modificarSedeVicerrectoria<?php echo $row['id_sede']; ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static"
                        data-bs-keyboard="false">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content p-4">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar sede</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <form action="crud.php" method="post">
                                        <div class="mb-3">
                                            <input type="hidden" name="id_sede" class="form-control"
                                                value="<?php echo $row['id_sede']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nombre</label>
                                            <input type="text" name="nombre" class="form-control"
                                                value="<?php echo $row['nombre']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Capacidad</label>
                                            <input type="text" name="capacidad" class="form-control"
                                                value="<?php echo $row['capacidad']; ?>" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-info"
                                                name="btnModificarSede">Modificar</button>
                                            <button type="button" class="btn btn-outline-danger"
                                                data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>