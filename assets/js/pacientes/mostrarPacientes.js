import listarEmpresas from "../empresas/listarEmpresas.js";
import dinamicSelect from "../global/dinamicSelect.js";
import listarSeguros from "../seguros/listarSeguros.js";

const d = document,
    path = location.pathname.split('/');


// async function cargarSelect() {
//     try {

//         const $form = d.getElementById("info-empresa"),
//             $actForm = d.getElementById("act-empresa"),
//             $select = d.createElement("select"),
//             $defaultOption = d.createElement("option"),
//             $fragment = d.createDocumentFragment(),
//             seguros = await listarSeguros();
//         // empresas = await listarEmpresas();

//         //Estableciendo configuraciones iniciales del select
//         $select.setAttribute("name", "seguro_id");
//         // $select.setAttribute("id","act-seguro");
//         $select.classList.add("form-control");
//         $defaultOption.textContent = "Seleccione un seguro";
//         $select.appendChild($defaultOption);


//         seguros.forEach(el => {

//             const $option = d.createElement("option");
//             $option.value = el.seguro_id;
//             $option.textContent = el.nombre;

//             console.log(el.seguro_id, el.nombre)

//             $fragment.appendChild($option);
//         })


//         $select.appendChild($fragment);
//         let $select2 = $select.cloneNode(true) //document.importNode($select,true);
//         $form.appendChild($select);
//         $actForm.appendChild($select2);

//     } catch (error) {
//         console.log(error)
//         alert(error);
//     }
// }

d.addEventListener("click", async e => {

    if (e.target.matches("#seguro_id") && e.target.dataset.active == 0) {

        const seguros = await listarSeguros();
        dinamicSelect(seguros, "nombre", "seguro_id", e.target);
        e.target.dataset.active = 1;
    }

    if (e.target.matches("#empresa_id") && e.target.dataset.active == 0) {

        const empresas = await listarEmpresas();
        dinamicSelect(empresas, "nombre_empresa", "empresa_id", e.target);
        e.target.dataset.active = 1;
    }
})


d.addEventListener("DOMContentLoaded", e => {

    let pacientes = $('#pacientes').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: `/${path[1]}/pacientes/consulta/`,
        columns: [

            {
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },

            { data: "cedula" },

            // ! Nombre paciente (asegurado y natural)
            {
                "data": function (row, type, val, meta) {

                    if (row.nombres) {
                        return row.nombres;

                    } else {
                        return row.nombre_paciente;
                    }
                }
            },
            { data: "apellidos" },
            { data: "edad" },
            {
                data: "tipo_paciente",
                render: function (data, type, row) {

                    switch (data) {
                        case '1': return 'Natural';
                        case '2': return 'Asegurado';
                        case '3': return 'Beneficiado';
                        default: return 'Natural';
                    }
                }
            },
            {
                data: "paciente_id",
                render: function (data, type, row) {

                    return `<a href="#" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalInfo" class="view-info"><i class="fas fa-eye view-info" data-id="${data}"></i></a>
                        <a href="#" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-paciente"><i class="fas fa-edit act-paciente" data-id="${data}"></i></a>
                        <a href="#" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente"><i class="fas fa-trash del-paciente" data-id="${data}"></i></a>
                    `
                }
            }

        ],

        
        // ! Ocultar los paneles por defecto 
        columnDefs: [{
            searchPanes: {
                show: false,
            },
            targets: [0, 1, 2, 3, 4, 5],
        }],

        // ! rowData (Devuelve toda la fila)
        searchPanes: {
            controls: false,
            hideCount: true,
            collapse: true,
            initCollapsed: true,
            panes: [
                {
                    header: 'Filtrar por tipo de paciente:',
                    options: [
                        {
                            label: 'Paciente natural',
                            value: function (rowData, rowIdx) {
                                return rowData.tipo_paciente === "1";
                            },
                            className: 'paciente-natural'
                        },
                        {
                            label: 'Paciente asegurado',
                            value: function (rowData, rowIdx) {
                                return rowData.tipo_paciente === "2";
                            },
                            className: 'paciente-asegurado'
                        },
                        {
                            label: 'Paciente beneficiado',
                            value: function (rowData, rowIdx) {
                                return rowData.tipo_paciente === "3";
                            },
                            className: 'paciente-beneficiado'
                        }
                    ],
                    dtOpts: {
                        searching: false,
                        order: [[1, 'desc']]
                    }
                },
                {
                    header: 'Filtrar por edad:',
                    options: [
                        {
                            label: 'Menores de 18 años',
                            value: function (rowData, rowIdx) {
                                return rowData.edad < 18;
                            },
                            className: 'may-18'
                        },
                        {
                            label: 'Mayores de 18 años',
                            value: function (rowData, rowIdx) {
                                return rowData.edad > 18;
                            },
                            className: 'men-18'
                        }
                    ],
                }
            ]
        },
        dom: 'Plfrtip'
    });

    function format(data) {

        if (!data.nombre_seguro) data.nombre_seguro = "No aplica";
        if (!data.saldo_disponible) data.saldo_disponible = "No aplica";

        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                    <td>Fecha de Nacimiento:</td>
                    <td>${data.fecha_nacimiento}</td>
                    <td>Teléfono:</td>
                    <td>${data.telefono}</td>
                </tr>
                <tr class="blue-td">
                    <td>Dirección:</td>
                    <td>${data.direccion}</td>
                    <td>Seguro:</td>
                    <td>${data.nombre_seguro}</td>
                </tr>
                <tr>
                    <td>Saldo disponible:</td>
                    <td>${data.saldo_disponible}</td>
                </tr>
            </table>
        `
    }

    $('#pacientes').on('click', 'td.dt-control', function () {
        let tr = $(this).closest('tr');
        let row = pacientes.row(tr);

        if (row.child.isShown()) {

            row.child.hide();
            tr.removeClass('shown');
        }
        else {

            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
});

