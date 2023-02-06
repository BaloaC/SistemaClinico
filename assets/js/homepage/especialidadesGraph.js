/* Chart code */
// Create root element
import dinamicSelect2, {
    emptySelect2,
    select2OnClick,
} from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import getAllConsultationsByMonth from "./getAllConsultationsByMonth.js";
import getAllConsultationsForYear from "./getAllConsultationsForYear.js";

const especialidades = await getAll("especialidades/consulta"),
    especialidadSelect = document.getElementById("s-especialidades");

dinamicSelect2({
    obj: especialidades,
    selectSelector: especialidadSelect,
    selectValue: "especialidad_id",
    selectNames: ["nombre"],
    parentModal: "body",
    placeholder: "Todas las especialidades",
    selectWidth: "75%",
});

dinamicSelect2({
    obj: [{ id: "month", text: "Mensual" }],
    selectNames: ["text"],
    selectValue: "id",
    selectSelector: "#s-fecha",
    placeholder: "Todo el año",
    parentModal: "body",
    staticSelect: true,
    selectWidth: "75%",
});

// https://www.amcharts.com/docs/v5/getting-started/#Root_element
let root = am5.Root.new("chartdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([am5themes_Responsive.new(root)]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
let chart = root.container.children.push(
    am5xy.XYChart.new(root, {
        panX: true,
        panY: true,
        wheelX: "panX",
        wheelY: "zoomX",
        pinchZoomX: true,
    })
);

// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
let cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
cursor.lineY.set("visible", false);

// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
let xRenderer = am5xy.AxisRendererX.new(root, { 
    minGridDistance: 30,
    grid: {
        "disabled": true
    }
});
xRenderer.labels.template.setAll({
    rotation: -90,
    centerY: am5.p50,
    centerX: am5.p100,
    paddingRight: 15,
});

export let xAxis = chart.xAxes.push(
    am5xy.CategoryAxis.new(root, {
        maxDeviation: 0.3,
        categoryField: "meses",
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

// Create series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
export let series = chart.series.push(
    am5xy.ColumnSeries.new(root, {
        name: "Series 1",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        sequencedInterpolation: true,
        categoryXField: "meses",
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

export let title = chart.children.unshift(am5.Label.new(root,{
    text: "Consultas realizadas",
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

console.log(am5.registry.entitiesById.titleChart);

// Set data
// const data = await getAllConsultationsForYear();
// xAxis.data.setAll(data);
// series.data.setAll(data);
await getAllConsultationsForYear("all");

// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
series.appear(1000);
chart.appear(1000, 100);

$("#s-especialidades").on("change", async function (e) {
    console.log($("#s-fecha").val());
    if ($("#s-fecha").val() === "year") {
        await getAllConsultationsForYear(this.value);
    } else if ($("#s-fecha").val() === "month"){
        await getAllConsultationsByMonth(this.value);
    }
});

$("#s-fecha").on("change", async function (e) {
    if($("#s-especialidades").val() === "all" && this.value === "year"){
        await getAllConsultationsForYear("all");
    } else if($("#s-especialidades").val() === "all" && this.value === "month"){
        await getAllConsultationsByMonth("all");
    } else if($("#s-especialidades").val() !== "all" && this.value === "year"){
        await getAllConsultationsForYear($("#s-especialidades").val());
    } else if($("#s-especialidades").val() !== "all" && this.value === "month"){
        await getAllConsultationsByMonth($("#s-especialidades").val());
    } 
});
