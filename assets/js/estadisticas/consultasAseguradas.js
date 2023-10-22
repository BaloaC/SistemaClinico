import getAll from "../global/getAll.js";

const consultasList = await getAll("allConsultas");

if (consultasList?.consultas_aseguradas === 0 && consultasList?.consultas_normales === 0) {

  let mensajeVacio = document.querySelector(".consultasAseguradas");
  if (mensajeVacio.classList.contains('d-none')) {
    mensajeVacio.classList.remove('d-none')
  }

} else {
  let root = am5.Root.new("consultasAseguradas");

  // Set themes
  root.setThemes([
    am5themes_Animated.new(root)
  ]);


  // Create chart
  let chart = root.container.children.push(am5percent.PieChart.new(root, {
    layout: root.verticalLayout
  }));


  // Create series
  let series = chart.series.push(am5percent.PieSeries.new(root, {
    valueField: "value",
    categoryField: "edades"
  }));

   let title = chart.children.unshift(am5.Label.new(root, {
    text: "Consultas aseguradas (Mensual)",
    fontSize: 25,
    fontWeight: "500",
    textAlign: "center",
    x: am5.percent(50),
    centerX: am5.percent(50),
    paddingTop: 0,
    paddingBottom: 0,
    dy: 1,
    id: "consultasAseguradas"
  }));


  // Set data
  series.data.setAll([
    { value: consultasList?.consultas_aseguradas ?? 0, category: "Asegurada" },
    { value: consultasList?.consultas_normales ?? 0, category: "No asegurada" },
  ]);


  // Play initial series animation
  series.appear(1000, 100);
}

