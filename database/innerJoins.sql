-- Paciente/seguro
select
	paciente.paciente_id,
    paciente.cedula,
    paciente.nombres AS nombre_paciente,
    paciente.apellidos,
    paciente.fecha_nacimiento,
    paciente.edad,
    paciente.telefono,
    paciente.direccion,
    paciente.tipo_paciente,
    paciente_seguro.tipo_seguro,
    paciente_seguro.cobertura_general,
    paciente_seguro.fecha_contra,
    paciente_seguro.saldo_disponible,
    empresa.nombre AS nombre_empresa,
    seguro.nombre AS nombre_seguro
from paciente_seguro
INNER JOIN paciente on paciente.paciente_id = paciente_seguro.paciente_id
INNER JOIN seguro on seguro.seguro_id = paciente_seguro.seguro_id
INNER JOIN empresa on empresa.empresa_id = paciente_seguro.empresa_id
where paciente.paciente_id = 5;
-- empresa/seguro
select
	empresa.empresa_id,
    empresa.nombre AS nombre_empresa,
    empresa.rif,
    empresa.direccion,
    seguro.nombre,
    seguro.seguro_id
from seguro_empresa
INNER JOIN empresa on empresa.empresa_id = seguro_empresa.empresa_id
INNER JOIN seguro on seguro.seguro_id = seguro_empresa.seguro_id
where empresa.empresa_id = 8;
-- seguro/empresa
select
	empresa.empresa_id,
    empresa.nombre AS nombre_empresa,
    seguro.nombre AS nombre_seguro,
    seguro.seguro_id,
    seguro.rif,
    seguro.direccion,
    seguro.telefono,
    seguro.porcentaje,
    seguro.tipo_seguro
from seguro_empresa
INNER JOIN empresa on empresa.empresa_id = seguro_empresa.empresa_id
INNER JOIN seguro on seguro.seguro_id = seguro_empresa.seguro_id
where seguro.seguro_id = 1;
-- empresas de seguro/empresa
select
	empresa.empresa_id,
    empresa.nombre AS nombre_empresa,
    empresa.rif,
    empresa.direccion
from seguro_empresa
INNER JOIN empresa on empresa.empresa_id = seguro_empresa.empresa_id
INNER JOIN seguro on seguro.seguro_id = seguro_empresa.seguro_id
where seguro.seguro_id = 1;
-- medico/especialidad
select *
from medico_especialidad
INNER JOIN medico on medico.medico_id = medico_especialidad.medico_id
INNER JOIN especialidad on especialidad.especialidad_id = medico_especialidad.especialidad_id
where medico.medico_id = 3;
-- medico/horario
SELECT
	horario.dias_semana
from horario
INNER JOIN medico on medico.medico_id = horario.medico_id
where medico.medico_id = 3;
-- horarios 
SELECT 
	horario.horario_id,
    horario.dias_semana,
    horario.medico_id,
    medico.nombres
FROM horario 
INNER JOIN medico on medico.medico_id = horario.medico_id
-- citas
SELECT 
    paciente.nombres AS nombre_paciente,
    medico.nombres AS nombre_medico,
    especialidad.nombre AS nombre_especialidad,
    cita.cita_id,
    cita.paciente_id,
    cita.medico_id,
    cita.especialidad_id,
    cita.fecha_cita,
    cita.motivo_cita,
    cita.cedula_titular,
    cita.clave,
    cita.tipo_cita,
    cita.estatus_cit
from cita
INNER JOIN paciente ON paciente.paciente_id = cita.paciente_id
INNER JOIN medico ON medico.medico_id = cita.medico_id
INNER JOIN especialidad ON especialidad.especialidad_id = cita.especialidad_id


-- consulta
SELECT
	consulta.consulta_id,
    consulta.peso,
    consulta.altura,
    consulta.observaciones,
    consulta.fecha_consulta,
    paciente.paciente_id,
    paciente.nombres AS nombre_paciente,
    medico.medico_id,
    medico.nombres AS nombre_medico,
    especialidad.especialidad_id,
    especialidad.nombre AS nombre_especialidad,
    cita.cita_id,
    cita.fecha_cita,
    cita.motivo_cita,
    cita.cedula_titular,
    cita.clave
FROM consulta
INNER JOIN paciente ON paciente.paciente_id = consulta.paciente_id 
INNER JOIN medico ON medico.medico_id = consulta.medico_id
INNER JOIN especialidad ON especialidad.especialidad_id = consulta.especialidad_id
INNER JOIN cita ON cita.cita_id = consulta.cita_id
where consulta.consulta_id = 40;


-- consulta examen
SELECT 
	examen.examen_id,
    examen.nombre
from consulta_examen
INNER JOIN examen on examen.examen_id = consulta_examen.examen_id

-- factura_seguro
SELECT 
	cita.cita_id,
    consulta.consulta_id,
    consulta.fecha_consulta,
    especialidad.especialidad_id,
    especialidad.nombre AS nombre_especialidad,
    paciente.paciente_id AS paciente_id,
    paciente.cedula AS cedula_paciente,
    paciente.apellidos AS apellido_paciente,
    paciente.nombre AS nombre_paciente
from factura_seguro
INNER JOIN consulta ON consulta.consulta_id = factura_seguro.consulta_id
INNER JOIN paciente ON paciente.paciente_id = consulta.paciente_id
INNER JOIN especialidad ON especialidad.especialidad_id = consulta.especialidad_id
INNER JOIN cita ON cita.cita_id = consulta.cita_id


