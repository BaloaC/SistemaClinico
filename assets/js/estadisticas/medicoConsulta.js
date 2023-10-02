import getAll from "../global/getAll.js";

const medicosConsultas = await getAll("allConsultasMedicos");


let root = am5.Root.new("medicoConsulta");

// Set themes
root.setThemes([am5themes_Responsive.new(root)]);

// Create chart
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
let cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
cursor.lineY.set("visible", false);

// Create axes
let xRenderer = am5xy.AxisRendererX.new(root, {
    minGridDistance: 30,
});

xRenderer.labels.template.setAll({
    rotation: 0,
    centerY: am5.p50,
    centerX: am5.p100,
    paddingRight: -60,
});

export let xAxis = chart.xAxes.push(
    am5xy.CategoryAxis.new(root, {
        maxDeviation: 0.3,
        categoryField: "nombre_medico",
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

xAxis.get("renderer").labels.template.setAll({
    oversizedBehavior: "wrap",
    textAlign: "center",
    maxWidth: 100
});

yAxis.set("numberFormatter", am5.NumberFormatter.new(root, {
    "numberFormat": "#",
    "decimals": 0
}));

// Add this line to remove the gridlines
yAxis.get("renderer").grid.template.set("forceHidden", true);
xAxis.get("renderer").grid.template.set("forceHidden", true);

// Create series
export let series = chart.series.push(
    am5xy.ColumnSeries.new(root, {
        name: "Series 1",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "cantidad",
        sequencedInterpolation: true,
        categoryXField: "nombre_medico",
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

export let title = chart.children.unshift(am5.Label.new(root, {
    text: "Médicos con más consultas (Mensual)",
    fontSize: 25,
    fontWeight: "500",
    textAlign: "center",
    x: am5.percent(50),
    centerX: am5.percent(50),
    paddingTop: 0,
    paddingBottom: 0,
    dy: 1,
    id: "medicoConsulta"
}));

xAxis.data.setAll(medicosConsultas.slice(0,5));
series.data.setAll(medicosConsultas.slice(0,5));

series.appear(1000);
chart.appear(1000, 100);
