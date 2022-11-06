import {DataTable} from "./datatables/datatable.js";

const datatable = new DataTable("#myTable",{
    pages: true,
    columns: [
        {select: 1, type: "string"}
    ]
});

const array = ["Nombre", "Constelacion", "1", "2", "3", "4", "asd"];

// datatable.rows().add(array);

// let newData = {
//     headings: ["heading 1", "heading 2", "heading 3"],
//     data: [
//         ["cel 1", "cel 2", "cel 3"],
//         ["cel 4", "cel 2", "cel 3"],
//         ["cel 1", "cel 2", "cel 7"]
//     ]
// }

let lol = 1;

let json = JSON.stringify([{
    "Nombre": "Shaka",
    "Constelacion": "de Virgo",
},
{
    "Nombre": "Camus",
    "Constelacion": "de Acuario",
},
{
    "Nombre": "Aioria",
    "Constelacion": "de Leo",
},
{
    "Nombre": "Dohko",
    "Constelacion": "de Libra",
},
{
    "Nombre": "Mu",
    "Constelacion": "Aries",
},
{
    "Nombre": "Death Mask",
    "Constelacion": "de Cancer",
},
{
    "Nombre": "Camus",
    "Constelacion": lol.toString(),
},
{
    "Nombre": "Aioria",
    "Constelacion": "de Leo",
},
{
    "Nombre": "Dohko",
    "Constelacion": "de Libra",
},
{
    "Nombre": "Mu",
    "Constelacion": "Aries",
},
{
    "Nombre": "Death Mask",
    "Constelacion": "de Cancer",
},

]);

// let newData1 = [
//     {
//         "1": "asd",
//         "2": "row 5",
//         "3": "row 6",
//     },
//     // {
//     //     "heading 4": "Cell 4",
//     //     "heading 5": "Cell 5",
//     //     "heading 6": "Cell 6", 
//     // }
// ]

fetch("http://127.0.0.1/proyectoFEO/usuarios/consulta")
.then(res => res.ok ? res.json() : Promise.reject(res))
.then(json => json.data)
.then(data => {
    datatable.import({
        type:"json",
        data: JSON.stringify(data)
    })
})



// datatable.import({
//     type:"json",
//     data: json
// });