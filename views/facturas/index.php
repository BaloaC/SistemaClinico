<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <!-- <link rel="stylesheet" href="<?php echo Url::to('assets/libs/fontawesome/css/all.min.css'); ?>"> -->
    <title>Proyecto 4 | Facturas Compra</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Facturas Compra</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> Factura</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Factura compras -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
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
                                            <th>Estatus</th>
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
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar factura compra</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBody">
                        <div class="alert d-none" role="alert"></div>
                        <form action="" id="info-fcompra" class="form-reg p-3 px-4">
                            <div class="row">
                                <div class="col-6">
                                    <label for="proveedor">Proveedor</label>
                                    <select name="proveedor_id" id="s-proveedor" class="form-control" data-active="0" required>
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="fecha_compra">Fecha de compra</label>
                                    <input type="date" name="fecha_compra" data-validate="true" data-type="date" class="form-control mb-3" required>
                                </div>
                                <h5 class=""></h5>
                                <div class="col-12">
                                    <table class="table table-hover insumos-table">
                                        <thead>
                                            <tr>
                                                <th>Insumo</th>
                                                <th>Precio unitario</th>
                                                <th>Cantidad</th>
                                                <th>Total</th>
                                                <th>Impuesto</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody id="insumos-list">
                                            <tr>
                                                <td><select name="insumo_id" id="s-insumo" class="form-control insumo-id" data-active="0" required>
                                                        <option></option>
                                                    </select></td>
                                                <td>
                                                    <input type="number" step="any" name="precio_unit" min="0" class="form-control insumo-uprecio" data-validate="true" data-type="price" oninput="calcularMonto(this)" required>
                                                    <small class="form-text">No se permiten números negativos</small>
                                                </td>
                                                <td>
                                                    <input type="number" step="any" name="unidades" min="0" class="form-control insumo-unid" data-validate="true" data-type="price" oninput="calcularMonto(this)" required>
                                                    <small class="form-text">No se permiten números negativos</small>
                                                </td>
                                                <td><b class="monto-total-p">$0.00</b></td>
                                                <td><input type="checkbox" name="impuesto" oninput="calcularMonto(this)"></td>
                                                <td><div class="visible d-none"><button type="button" class="btn" onclick="deleteInsumoInput(this)"><i class="fas fa-times m-0"></i></button></div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <td><button type="button" class="btn" id="addInsumoInputBtn" onclick="addInsumoInput()"><i class="fas fa-plus m-0"></i></i></button></td>
                                </div>
                                <div class="col-4 offset-8">
                                    <p>Productos totales: <b id="productos-totales" class="float-end">0</b></p>
                                    <p>Monto sin iva: <b id="monto-sin-iva" class="float-end">$0.00</b></p>
                                    <p>IVA (16.00%): <b id="iva" class="float-end">$0.00</b></p>
                                    <hr>
                                    <p>Total: <b id="monto-total" class="float-end">$0.00</b></p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-registrar" class="btn btn-primary" onclick="addFCompra()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Insumos template -->
        <template id="insumo-template">
            <tr>
                <td><select name="insumo_id" id="s-insumo" class="form-control insumo-id" data-active="0" required>
                        <option></option>
                    </select></td>
                <td>
                    <input type="number" step="any" name="precio_unit" min="0" class="form-control insumo-uprecio" data-validate="true" data-type="price" oninput="calcularMonto(this)" required>
                    <small class="form-text">No se permiten números negativos</small>
                </td>
                <td>
                    <input type="number" step="any" name="unidades" min="0" class="form-control insumo-unid" data-validate="true" data-type="price" oninput="calcularMonto(this)" required>
                    <small class="form-text">No se permiten números negativos</small>
                </td>
                <td><b class="monto-total-p">$0.00</b></td>
                <td><input type="checkbox" name="impuesto" oninput="calcularMonto(this)"></td>
                <td><div class="visible"><button type="button" class="btn" onclick="deleteInsumoInput(this)"><i class="fas fa-times m-0"></i></button></div></td>
            </tr>
        </template>

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
    <script type="module" src="<?php echo Url::to('assets/js/facturas-compra/deleteInsumoInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/facturas-compra/calcularInsumos.js'); ?>"></script>
</body>

</html>