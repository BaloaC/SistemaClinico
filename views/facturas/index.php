<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <title>Proyecto 4 | Facturas Compra</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6"><h4 class="pt-5 pb-2 text-grey">Facturas Compra</h4></div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> Factura</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Factura compras -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-dark m-1">Facturas compra registradas</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="fCompra" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>Detalles</th>
                                            <th>Nombre Proveedor</th>
                                            <th>Total Insumos</th>
                                            <th>Monto con IVA</th>
                                            <th>Monto sin IVA</th>
                                            <th>Excento</th>
                                            <th>Fecha Compra</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Registro-->
        <div class="modal fade" id="modalReg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar factura compra</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert d-none" role="alert"></div>
                        <form action="" id="info-fcompra" class="p-3 px-4">
                            <div class="row">
                                <!-- Labels -->
                                <div class="col-12 col-md-6">
                                    <label for="proveedor">Proveedor</label>
                                    <select name="proveedor_id" id="s-proveedor" class="form-control" data-active="0">
                                        <option></option>
                                    </select>

                                    <label for="fecha_compra">Fecha de compra</label>
                                    <input type="date" name="fecha_compra" class="form-control">

                                    <label for="monto_con_iva">Monto con IVA</label>
                                    <input type="number" name="monto_con_iva" class="form-control">

                                    <label for="monto_sin_iva">Monto sin IVA</label>
                                    <input type="number" name="monto_sin_iva" class="form-control">
                                    
                                    <label for="total_productos">Total de productos</label>
                                    <input type="number" name="total_productos" class="form-control">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="insumo">Insumo</label>
                                    <select name="insumo_id" id="s-insumo" class="form-control insumo-id" data-active="0">
                                        <option></option>
                                    </select>

                                    <label for="unidades">Unidades</label>
                                    <input type="number" name="unidades" class="form-control insumo-unid">

                                    <label for="precio_unit">Precio unitario</label>
                                    <input type="number" name="precio_unit" class="form-control insumo-uprecio">

                                    <label for="precio_total">Precio total</label>
                                    <input type="number" name="precio_total" class="form-control insumo-tprecio">
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mt-3" id="addInsumo" onclick="addInsumoInput()">Añadir otro insumo</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addFCompra()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar Eliminación -->
        <div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar factura compra</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar esta factura?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/facturas-compra/mostrarFCompras.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/facturas-compra/registrarFCompra.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/facturas-compra/eliminarFCompra.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/facturas-compra/addInsumoInput.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.js'); ?>"></script>
</body>

</html>