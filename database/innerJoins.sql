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





