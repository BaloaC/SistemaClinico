import formatToRealDate from "../global/formatToRealDate.js";
import createDataTable from "../global/createDataTable.js";

const path = location.pathname.split("/");

addEventListener("DOMContentLoaded", (e) => {

    // Para permitir que se filtre con la fecha formateada
    $.fn.dataTable.moment('DD-MM-YYYY');

    const fComprasColumns = [
        {
            className: "dt-control",
            orderable: false,
            data: null,
            defaultContent: "",
        },
        { data: "factura_compra_id" },
        { data: "proveedor_nombre" },
        {
            data: "monto_con_iva",
            render: function (data, type, row) {
                return `${data} Bs`
            }
        },
        {
            data: "monto_sin_iva",
            render: function (data, type, row) {
                return `${data} Bs`
            }
        },
        {
            data: "excento",
            render: function (data, type, row) {
                return data === null || data === 0 ? "Ninguno" : `${data} Bs`;
            },
        },
        {
            data: "fecha_compra",
            render: function (data, type, row) {
                return formatToRealDate(data);
            },
        },
        {
            data: "estatus_fac",
            render: function (data, type, row) {
                if (data == 1) {
                    return `<span class="badge light badge-success">Pagada</span>`;
                } else {
                    return `<span class="badge light badge-danger">Anulada</span>`;
                }
            },
        },
        {
            data: "factura_compra_id",
            render: function (data, type, row) {

                const estaDentroDeLos3DiasAnteriores = (fechaObjetivo) => {
    
                    const fechaActual = new Date();
                    // Calcular la fecha límite (3 días antes de la fecha actual)
                    const fechaLimite = new Date();
                    fechaLimite.setDate(fechaActual.getDate() - 3);
                  
                    // Convertir las fechas a milisegundos
                    const fechaObjetivoMilisegundos = fechaObjetivo.getTime();
                    const fechaLimiteMilisegundos = fechaLimite.getTime();
                    const fechaActualMilisegundos = fechaActual.getTime();
                  
                    // Verificar si la fecha objetivo está dentro del rango de 3 días anteriores
                    return fechaObjetivoMilisegundos >= fechaLimiteMilisegundos && fechaObjetivoMilisegundos < fechaActualMilisegundos;
                  }

                if (row.estatus_fac == 1 && estaDentroDeLos3DiasAnteriores(new Date(row.fecha_compra))) {
                
                    return `
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-facturaCompra" onclick="deleteFCompra(${Number(row.factura_compra_id)})"><i class="fas fa-trash del-facturaCompra"></i></a>
                        `;
                } else {
                    return `-`;
                }
            }
        },
    ];

    const order = [[6, 'desc'], [5, 'desc']];

    const format = (data) => {
        let template = `<table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">`;
        data.insumos.forEach((e) => {
            template += `
                <tr>
                    <td>Nombre Insumo: ${e.insumo_nombre}</td>
                    <td>Unidades: ${e.unidades}</td>
                    <td>Precio unitario: ${e.precio_unit_bs} Bs</td>
                    <td>Precio total: ${e.precio_total_bs} Bs</td>
                </tr>
            `;
        });
        template += `<tr>
            <td><a class="btn btn-sm btn-add" href="#" onclick="openPopup('pdf/facturacompra/${data.factura_compra_id}')"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a></td>
        </tr>`;
        template += `</table>`;
        return template;
    }

    createDataTable({
        id: "#fCompra",
        url: `/${path[1]}/factura/compra/consulta/`,
        columns: fComprasColumns,
        order,
        format,
        formatDataCustom: true,
        formatDataCustomUrl: "factura/compra",
        formatDataCustomId: "factura_compra_id",
        processing: true,
        serverSide: true
    });
});
