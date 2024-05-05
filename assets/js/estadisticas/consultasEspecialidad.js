import getAll from "../global/getAll.js";

let root = null;
let chart = null;
let series = null;
let title = null;
let xAxis = null;

export async function getAllConsultasEspecialidades(startDate = null, endDate = null) {

    let allConsultasEspecialidades = [];
    const loadingMessage = document.querySelector(".consultasEspecialidad.loading");
    loadingMessage.classList.remove("d-none");
    
    if(startDate !== null && endDate !== null){
        allConsultasEspecialidades = await getAll(`allConsultasEspecialidades?fecha_inicio=${startDate}&fecha_final=${endDate}`);
    } else {
        allConsultasEspecialidades = await getAll("allConsultasEspecialidades");
    }
    
    loadingMessage.classList.add("d-none");
    
    if (allConsultasEspecialidades?.length === 0) {
        let mensajeVacio = document.querySelector(".consultasEspecialidad");
        if (mensajeVacio.classList.contains("d-none")) {
            mensajeVacio.classList.remove("d-none");
        }
    } else {

        if (!root) {
            root = am5.Root.new("consultasEspecialidad");
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
            rotation: 90,
            centerY: am5.p50,
            centerX: am5.p100,
            paddingRight: 0,
        });

        xAxis = chart.xAxes.push(
            am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: "nombre_especialidad",
                renderer: xRenderer,
                tooltip: am5.Tooltip.new(root, {}),
            })
        );

        let yAxis = chart.yAxes.push(
            am5xy.ValueAxis.new(root, {
                maxDeviation: 0.3,
                renderer: am5xy.AxisRendererY.new(root, {}),
            })
        );

        yAxis.set("numberFormatter", am5.NumberFormatter.new(root, {
            "numberFormat": "#",
            "decimals": 0,
        }));

        xAxis.get("renderer").labels.template.setAll({
            oversizedBehavior: "truncate",
            textAlign: "center",
            maxWidth: 50,
            maxHeight: 50,
        });

        // Add this line to remove the gridlines
        yAxis.get("renderer").grid.template.set("forceHidden", true);
        xAxis.get("renderer").grid.template.set("forceHidden", true);

        // Create series
        series = chart.series.push(
            am5xy.ColumnSeries.new(root, {
                name: "Series 1",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "cantidad",
                sequencedInterpolation: true,
                categoryXField: "nombre_especialidad",
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

        title = chart.children.unshift(
            am5.Label.new(root, {
                text: "Consultas por especialidad (Semanal)",
                fontSize: window.innerWidth < 576 ? 20 : 25,
                fontWeight: "500",
                textAlign: "center",
                x: am5.percent(50),
                centerX: am5.percent(50),
                paddingTop: -20,
                paddingBottom: 0,
                dy: 1,
                id: "consultasEspecialidad",
            })
        );



        console.log(allConsultasEspecialidades);
            
        // Set initial data
        xAxis.data.setAll(allConsultasEspecialidades.slice(0, 5));
        series.data.setAll(allConsultasEspecialidades.slice(0, 5));

        // Make stuff animate on load
        series.appear(1000);
        chart.appear(1000, 100);

    }
}
window.getAllConsultasEspecialidades = getAllConsultasEspecialidades;

document.addEventListener("DOMContentLoaded", async () => {
    await getAllConsultasEspecialidades();
})