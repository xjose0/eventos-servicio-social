<div class="container mb-5">

    <div class="alerta">
        <?php
            if(isset($_SESSION['programaAgregado'])){
        ?>
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Programa agregado',
            showConfirmButton: true,
            timer: 1500,
            timerProgressBar: true
        });
        </script>
        <?php
                unset($_SESSION['programaAgregado']);
            }
        ?>

        <?php
            if(isset($_SESSION['programaModificado'])){
        ?>
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Programa modificado',
            showConfirmButton: true,
            timer: 1500,
            timerProgressBar: true
        });
        </script>
        <?php
                unset($_SESSION['programaModificado']);
            }
        ?>

        <?php
            if(isset($_SESSION['programaEliminado'])){
        ?>
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Programa eliminado',
            showConfirmButton: true,
            timer: 1500,
            timerProgressBar: true
        });
        </script>
        <?php
                unset($_SESSION['programaEliminado']);
            }
        ?>
    </div>

    <h2 class="text-center mb-5">Listado de programas</h2>
    <div class="row">
        <div class="col-4">
            <h4 class="mb-4">Agregar programa</h4>
            <form action="crud.php" method="post">
                <div class="mb-3">
                    <label for="nombrePrograma" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombrePrograma" name="nombrePrograma">
                </div>
                <button type="submit" class="btn btn-warning w-100" name="btnAgregarPrograma">Agregar</button>
            </form>
        </div>
        <div class="col-8">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 30%;">id</th>
                        <th style="width: 40%;">Nombre</th>
                        <th style="width: 30%;"></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        require_once("config.php");
                        $sqlselect = "SELECT * FROM programas";
                        $datos = $conexion->query($sqlselect);

                        while ($fila = mysqli_fetch_array($datos)){
                    ?>

                    <tr>
                        <td> <?php echo $fila['id_programa']; ?> </td>
                        <td> <?php echo $fila['nombre']; ?> </td>

                        <form action="crud.php" method="post"
                            onsubmit="return confirm ('¿Estás seguro que deseas borrar el programa?')">
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" title="Modificar"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modificarPaciente<?php echo $fila['id_programa']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button type="submit" name="btnEliminarPrograma" title="Eliminar"
                                    class="btn btn-danger btn-sm"> <i class="fa-solid fa-trash"></i> </button>
                                <input type="hidden" value="<?php echo $fila['id_programa']; ?>" name="idEliminar">
                            </td>
                        </form>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="modificarPaciente<?php echo $fila['id_programa']; ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static"
                        data-bs-keyboard="false">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content p-4">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar paciente</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <form action="crud.php" method="post">
                                        <div class="mb-3">
                                            <input type="hidden" name="id_programa" class="form-control"
                                                value="<?php echo $fila['id_programa']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nombre</label>
                                            <input type="text" name="nombre" class="form-control"
                                                value="<?php echo $fila['nombre']; ?>" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-info"
                                                name="btnModificarPrograma">Modificar</button>
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