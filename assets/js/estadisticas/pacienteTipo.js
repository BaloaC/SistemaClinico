import getAll from "../global/getAll.js";

const pacientesList = await getAll("pacientes/consulta");
let [asegurado, natural, representante, beneficiado] = [0, 0, 0, 0];

pacientesList.forEach(paciente => {

    switch (true) {
        case (paciente.tipo_paciente == 1): natural++; break;
        case (paciente.tipo_paciente == 2): representante++; break;
        case (paciente.tipo_paciente == 3): asegurado++; break;
        case (paciente.tipo_paciente == 4): beneficiado++; break;
    }
})

const allPacientes = [
    { value: natural, tipo: "Natural" },
    { value: representante, tipo: "Representante" },
    { value: asegurado, tipo: "Asegurado" },
    { value: beneficiado, tipo: "Beneficiado" },
];


let root = am5.Root.new("pacienteTipo");


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
  categoryField: "tipo"
}));

export let title = chart.children.unshift(am5.Label.new(root, {
    text: "Tipos de pacientes",
    fontSize: 25,
    fontWeight: "500",
    textAlign: "center",
    x: am5.percent(50),
    centerX: am5.percent(50),
    paddingTop: 0,
    paddingBottom: 0,
    dy: 1,
    id: "titleChartTipo"
}));

// Set data
series.data.setAll(allPacientes);


// Play initial series animation
series.appear(1000, 100);