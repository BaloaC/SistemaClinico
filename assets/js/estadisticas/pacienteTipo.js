import getAll from "../global/getAll.js";

let root = null;
let chart = null;
let series = null;

async function getPacientesByType() {

    const pacientesList = await getAll("pacientesByType");

    if (pacientesList?.length === 0) {

        let mensajeVacio = document.querySelector(".pacienteTipo");
        if (mensajeVacio.classList.contains('d-none')) {
            mensajeVacio.classList.remove('d-none')
        }

    } else {


        const allPacientes = [
            { value: Number(pacientesList[0].paciente_natural), tipo: "Natural" },
            { value: Number(pacientesList[0].paciente_representante), tipo: "Representante" },
            { value: Number(pacientesList[0].paciente_asegurado), tipo: "Asegurado" },
            { value: Number(pacientesList[0].paciente_beneficiado), tipo: "Beneficiado" },
        ];

        if (!root) {
            
            root = am5.Root.new("pacienteTipo");

            // Set themes
            root.setThemes([
                am5themes_Animated.new(root)
            ]);

            if (chart) {
                chart.dispose();
            }

            // Create chart
            chart = root.container.children.push(am5percent.PieChart.new(root, {
                layout: root.verticalLayout
            }));


            // Create series
            series = chart.series.push(am5percent.PieSeries.new(root, {
                valueField: "value",
                categoryField: "tipo"
            }));

            let title = chart.children.unshift(am5.Label.new(root, {
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

        }

        // Set data
        series.data.setAll(allPacientes);

        // Play initial series animation
        series.appear(1000, 100);
    }
}

window.getPacientesByType = getPacientesByType;

document.addEventListener("DOMContentLoaded", async () => {
    await getPacientesByType();
});
