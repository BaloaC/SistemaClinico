import getAll from "../global/getAll.js";

let root = null;
let chart = null;
let series = null;
let xAxis = null;

export async function getPacientesByAge(startRange = null, endRange = null) {


    let allPacientes = [];
    let pacientesList = [];
    const loadingMessage = document.querySelector(".pacienteEdad.loading");
    loadingMessage.classList.remove("d-none");

    if(startRange !== null && endRange !== null){

        pacientesList = await getAll(`pacientesByAge?inicio_rango=${startRange}&fin_rango=${endRange}`);

        allPacientes = [
            { value: Number(pacientesList[0].filterRange), edades: `Entre ${startRange} de ${endRange}` },
        ];

    } else {

        pacientesList = await getAll("pacientesByAge");

        allPacientes = [
            { value: Number(pacientesList[0].menos18), edades: "Menores de 18" },
            { value: Number(pacientesList[0].mas18_30), edades: "Entre 18 y 30" },
            { value: Number(pacientesList[0].mas31_40), edades: "Entre 31 y 40" },
            { value: Number(pacientesList[0].mas41_50), edades: "Entre 41 y 50" },
            { value: Number(pacientesList[0].mas51_60), edades: "Entre 51 y 60" },
            { value: Number(pacientesList[0].mayor60), edades: "Mayores de 60" },
        ];

    }

    loadingMessage.classList.add("d-none");


    if (pacientesList?.length === 0) {

        let mensajeVacio = document.querySelector(".pacienteEdad");
        if (mensajeVacio.classList.contains('d-none')) {
            mensajeVacio.classList.remove('d-none')
        }

    } else {

        if (!root) {
            root = am5.Root.new("pacienteEdad");
        }

        // Set themes
        root.setThemes([am5themes_Responsive.new(root)]);

        if (chart) {
            chart.dispose();
        }

        // Create chart
        chart = root.container.children.push(
            am5xy.XYChart.new(root, {
                panX: true,
                panY: true,
                wheelX: "panX",
                wheelY: "zoomX",
                pinchZoomX: true,
            })
        );

        // Add cursor
        let cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);

        // Create axes
        let xRenderer = am5xy.AxisRendererX.new(root, {
            minGridDistance: 30,
        });

        xRenderer.labels.template.setAll({
            rotation: -90,
            centerY: am5.p50,
            centerX: am5.p100,
            paddingRight: 15,
        });

        xAxis = chart.xAxes.push(
            am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: "edades",
                renderer: xRenderer,
                tooltip: am5.Tooltip.new(root, {}),
            })
        );

        let yAxis = chart.yAxes.push(
            am5xy.ValueAxis.new(root, {
                maxDeviation: 0.3,
                // min: 0,
                // strictMinMax: true,
                // maxPrecision: 0,
                renderer: am5xy.AxisRendererY.new(root, {}),
            })
        );

        yAxis.set("numberFormatter", am5.NumberFormatter.new(root, {
            "numberFormat": "#",
            "decimals": 0
        }));

        // Add this line to remove the gridlines
        yAxis.get("renderer").grid.template.set("forceHidden", true);
        xAxis.get("renderer").grid.template.set("forceHidden", true);

        // Create series
        series = chart.series.push(
            am5xy.ColumnSeries.new(root, {
                name: "Series 1",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value",
                sequencedInterpolation: true,
                categoryXField: "edades",
                tooltip: am5.Tooltip.new(root, {
                    labelText: "{valueY}",
                }),
            })
        );


        series.columns.template.setAll({
            cornerRadiusTL: 5,
            cornerRadiusTR: 5,
        });
        series.columns.template.adapters.add("fill", function (fill, target) {
            return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        series.columns.template.adapters.add("stroke", function (stroke, target) {
            return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        title = chart.children.unshift(am5.Label.new(root, {
            text: "Pacientes por edad",
            fontSize: 25,
            fontWeight: "500",
            textAlign: "center",
            x: am5.percent(50),
            centerX: am5.percent(50),
            paddingTop: 0,
            paddingBottom: 0,
            dy: 1,
            id: "titleChart"
        }));


        // Set data
        xAxis.data.setAll(allPacientes);
        series.data.setAll(allPacientes);

        // Make stuff animate on load
        series.appear(1000);
        chart.appear(1000, 100);

    }
}

window.getPacientesByAge = getPacientesByAge;

document.addEventListener("DOMContentLoaded", async () => {
    await getPacientesByAge();
})