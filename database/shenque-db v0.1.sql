-- -----------------------------------------------------
-- Database Shenque-DB v0.1 12/10/22
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS shenque_db
DEFAULT CHARACTER SET utf8mb4;
USE shenque_db;

-- -----------------------------------------------------
-- Table shenque_db.proveedor
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.proveedor (
  proveedor_id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(45) NOT NULL,
  ubicacion VARCHAR(45) NOT NULL,
  PRIMARY KEY (proveedor_id));

-- -----------------------------------------------------
-- Table shenque_db.insumo
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.insumo (
  insumo_id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(45) NOT NULL,
  cantidad INT NOT NULL,
  stock INT NOT NULL,
  cantidad_min INT NOT NULL,
  precio FLOAT NOT NULL,
  PRIMARY KEY (insumo_id));

-- -----------------------------------------------------
-- Table shenque_db.factura_compra
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.factura_compra (
  factura_compra_id INT NOT NULL AUTO_INCREMENT,
  proveedor_id INT NOT NULL,
  fecha_compra VARCHAR(45) NOT NULL,
  monto_total FLOAT NOT NULL,
  total_productos INT NOT NULL,
  monto_con_iva FLOAT NOT NULL,
  monto_sin_iva FLOAT NOT NULL,
  iva FLOAT NOT NULL,
  excento VARCHAR(45) NOT NULL,
  PRIMARY KEY (factura_compra_id),
  CONSTRAINT fk_proveedor_insumo
    FOREIGN KEY (proveedor_id)
    REFERENCES shenque_db.proveedor (proveedor_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table shenque_db.compra_insumo
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.compra_insumo (
  compra_insumo_id INT NOT NULL AUTO_INCREMENT,
  insumo_id INT NOT NULL,
  factura_compra_id INT NOT NULL,
  unidades INT NOT NULL,
  precio_unit FLOAT NOT NULL,
  precio_total FLOAT NOT NULL,
  PRIMARY KEY (compra_insumo_id),
  CONSTRAINT fk_compra_insumo_insumo
    FOREIGN KEY (insumo_id)
    REFERENCES shenque_db.insumo (insumo_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_compra_insumo_factura_compra
    FOREIGN KEY (factura_compra_id)
    REFERENCES shenque_db.factura_compra (factura_compra_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table shenque_db.paciente
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.paciente (
  paciente_id INT NOT NULL AUTO_INCREMENT,
  cedula INT NOT NULL,
  nombres VARCHAR(45) NOT NULL,
  apellidos VARCHAR(45) NOT NULL,
  fecha_nacimiento DATE NOT NULL,
  edad INT NOT NULL,
  telefono VARCHAR(45) NULL,
  direccion VARCHAR(45) NOT NULL,
  tipo_paciente enum('1','2','3') NOT NULL,
  estatus_pac enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (paciente_id));

-- -----------------------------------------------------
-- Table shenque_db.medico
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.medico (
  medico_id INT NOT NULL AUTO_INCREMENT,
  cedula INT NOT NULL,
  nombres VARCHAR(45) NOT NULL,
  apellidos VARCHAR(45) NOT NULL,
  telefono VARCHAR(45) NULL,
  direccion VARCHAR(45) NOT NULL,
  estatus_med enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (medico_id));

-- -----------------------------------------------------
-- Table shenque_db.horario
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.horario (
  horario_id INT NOT NULL AUTO_INCREMENT,
  medico_id INT NOT NULL,
  dias_semana enum('lunes','martes','miercoles','jueves','viernes','sabado') NOT NULL,
  PRIMARY KEY (horario_id));

-- -----------------------------------------------------
-- Table shenque_db.consulta
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.consulta (
  consulta_id INT NOT NULL auto_increment,
  paciente_id INT NOT NULL,
  medico_id INT NOT NULL,
  peso FLOAT NOT NULL,
  altura FLOAT NOT NULL,
  observaciones VARCHAR(255) NULL,
  fecha_consulta DATE NOT NULL,
  PRIMARY KEY (consulta_id),
  CONSTRAINT fk_consulta_medico
    FOREIGN KEY (medico_id)
    REFERENCES shenque_db.medico (medico_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_consulta_paciente
    FOREIGN KEY (paciente_id)
    REFERENCES shenque_db.paciente (paciente_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table shenque_db.metodo_pago
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.metodo_pago (
  metodo_pago_id INT NOT NULL auto_increment,
  tipo VARCHAR(45) NOT NULL,
  PRIMARY KEY (metodo_pago_id));

-- -----------------------------------------------------
-- Table shenque_db.factura_consulta
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.factura_consulta (
  factura_consulta_id INT NOT NULL auto_increment,
  consulta_id INT NOT NULL,
  paciente_id INT NOT NULL,
  metodo_pago_id INT NOT NULL,
  monto_con_iva FLOAT NOT NULL,
  monto_sin_iva FLOAT NOT NULL,
  iva FLOAT NOT NULL,
  autorizacion VARCHAR(45) NOT NULL,
  PRIMARY KEY (factura_consulta_id),
  CONSTRAINT fk_factura_consulta_consulta
    FOREIGN KEY (consulta_id)
    REFERENCES shenque_db.consulta (consulta_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_factura_consulta_paciente
    FOREIGN KEY (paciente_id)
    REFERENCES shenque_db.paciente (paciente_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_factura_consulta_metodo_pago
    FOREIGN KEY (metodo_pago_id)
    REFERENCES shenque_db.metodo_pago (metodo_pago_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table shenque_db.Seguro
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.seguro (
  seguro_id INT NOT NULL auto_increment,
  nombre VARCHAR(45) NOT NULL,
  rif VARCHAR(45) NOT NULL,
  direccion VARCHAR(45) NOT NULL,
  telefono INT NOT NULL,
  porcentaje FLOAT NOT NULL,
  tipo_seguro enum('1','2') NOT NULL,
  estatus_seg enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (seguro_id));

-- -----------------------------------------------------
-- Table shenque_db.empresa
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.empresa (
  empresa_id INT NOT NULL auto_increment,
  nombre VARCHAR(45) NOT NULL,
  rif VARCHAR(45) NOT NULL,
  direccion VARCHAR(45) NOT NULL,
  estatus_emp enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (empresa_id));

-- -----------------------------------------------------
-- Table shenque_db.medico_seguro
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.medico_seguro (
  medico_seguro_id INT NOT NULL auto_increment,
  seguro_id INT NOT NULL,
  medico_id INT NOT NULL,
  acumulado_seguro FLOAT NOT NULL,
  PRIMARY KEY (medico_seguro_id),
  CONSTRAINT fk_medico_seguro_seguro
    FOREIGN KEY (seguro_id)
    REFERENCES shenque_db.seguro (seguro_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_medico_seguro_medico
    FOREIGN KEY (medico_id)
    REFERENCES shenque_db.medico (medico_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table shenque_db.paciente_seguro
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.paciente_seguro (
  paciente_seguro_id INT NOT NULL auto_increment,
  paciente_id INT NOT NULL,
  seguro_id INT NOT NULL,
  empresa_id INT NOT NULL,
  tipo_seguro enum('1','2') NOT NULL,
  cobertura_general FLOAT NOT NULL,
  fecha_contra DATE NOT NULL,
  saldo_disponible FLOAT NOT NULL,
  PRIMARY KEY (paciente_seguro_id),
  CONSTRAINT fk_paciente_seguro_paciente
    FOREIGN KEY (paciente_id)
    REFERENCES shenque_db.paciente (paciente_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_paciente_seguro_seguro
    FOREIGN KEY (seguro_id)
    REFERENCES shenque_db.seguro (seguro_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_paciente_seguro_empresa
    FOREIGN KEY (empresa_id)
    REFERENCES shenque_db.empresa (empresa_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table shenque_db.seguro_empresa
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.seguro_empresa (
  seguro_empresa_id INT NOT NULL auto_increment,
  empresa_id INT NOT NULL,
  seguro_id INT NOT NULL,
  PRIMARY KEY (seguro_empresa_id),
  CONSTRAINT fk_seguro_empresa_empresa
    FOREIGN KEY (empresa_id)
    REFERENCES shenque_db.empresa (empresa_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_seguro_empresa_seguro
    FOREIGN KEY (seguro_id)
    REFERENCES shenque_db.seguro (seguro_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table shenque_db.especialidad
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.especialidad (
  especialidad_id INT NOT NULL auto_increment,
  nombre VARCHAR(45) NOT NULL,
  estatus_esp enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (especialidad_id));

-- -----------------------------------------------------
-- Table shenque_db.medico_especialidad
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.medico_especialidad (
  medico_especialidad_id INT NOT NULL auto_increment,
  medico_id INT NOT NULL,
  especialidad_id INT NOT NULL,
  PRIMARY KEY (medico_especialidad_id),
  CONSTRAINT fk_medico_especialidad_medico
    FOREIGN KEY (medico_id)
    REFERENCES shenque_db.medico (medico_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_medico_especialidad_especialidad
    FOREIGN KEY (especialidad_id)
    REFERENCES shenque_db.especialidad (especialidad_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table shenque_db.cita
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.cita (
  cita_id INT NOT NULL AUTO_INCREMENT,
  paciente_id INT NOT NULL,
  medico_id INT NOT NULL,
  especialidad_id INT NOT NULL,
  fecha_cita DATETIME NOT NULL,
  motivo_cita VARCHAR(45) NOT NULL,
  cedula_titular INT NOT NULL,
  clave INT,
  tipo_cita enum('1','2') NOT NULL,
  estatus enum('1','2','3') NOT NULL,
  PRIMARY KEY (cita_id),
  CONSTRAINT fk_cita_paciente
    FOREIGN KEY (paciente_id)
    REFERENCES shenque_db.paciente (paciente_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_cita_medico
    FOREIGN KEY (medico_id)
    REFERENCES shenque_db.medico (medico_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_cita_especialidad
    FOREIGN KEY (especialidad_id)
    REFERENCES shenque_db.especialidad (especialidad_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
    
-- -----------------------------------------------------
-- Table shenque_db.examen
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.examen (
  examen_id INT NOT NULL auto_increment,
  nombre VARCHAR(45) NOT NULL,
  tipo VARCHAR(45) NOT NULL,
  PRIMARY KEY (examen_id));

-- -----------------------------------------------------
-- Table shenque_db.consulta_examen
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.consulta_examen (
  consulta_examen_id INT NOT NULL auto_increment,
  consulta_id INT NOT NULL,
  examen_id INT NOT NULL,
  PRIMARY KEY (consulta_examen_id),
  CONSTRAINT fk_consulta_examen_consulta
    FOREIGN KEY (consulta_id)
    REFERENCES shenque_db.consulta (consulta_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_consulta_examen_examen
    FOREIGN KEY (examen_id)
    REFERENCES shenque_db.examen (examen_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table shenque_db.consulta_insumo
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.consulta_insumo (
  consulta_insumo_id INT NOT NULL auto_increment,
  insumo_id INT NOT NULL,
  consulta_id INT NOT NULL,
  PRIMARY KEY (consulta_insumo_id),
  CONSTRAINT fk_consulta_insumo_insumo
    FOREIGN KEY (insumo_id)
    REFERENCES shenque_db.insumo (insumo_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_consulta_insumo_consulta
    FOREIGN KEY (consulta_id)
    REFERENCES shenque_db.consulta (consulta_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table shenque_db.factura_medico
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.factura_medico (
  factura_medico_id INT NOT NULL auto_increment,
  medico_id INT NOT NULL,
  acumulado_seguro_total FLOAT NOT NULL,
  acumulado_consulta_total FLOAT NOT NULL,
  pago_total FLOAT NOT NULL,
  fecha_pago DATE NOT NULL,
  PRIMARY KEY (factura_medico_id),
  CONSTRAINT fk_factura_medico_medico
    FOREIGN KEY (medico_id)
    REFERENCES shenque_db.medico (medico_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table shenque_db.pago_seguro
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.pago_seguro (
  pago_seguro_id INT NOT NULL auto_increment,
  factura_consulta_id INT NOT NULL,
  seguro_id INT NOT NULL,
  fecha_pago DATE NOT NULL,
  PRIMARY KEY (pago_seguro_id),
  CONSTRAINT fk_pago_seguro_factura_consulta
    FOREIGN KEY (factura_consulta_id)
    REFERENCES shenque_db.factura_consulta (factura_consulta_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_pago_seguro_seguro
    FOREIGN KEY (seguro_id)
    REFERENCES shenque_db.Seguro (seguro_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table shenque_db.factura_seguro
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.factura_seguro (
  factura_seguro_id INT NOT NULL auto_increment,
  consulta_id INT NOT NULL,
  seguro_id INT NOT NULL,
  autorizacion VARCHAR(45) NOT NULL,
  factura_ocurrencia VARCHAR(45) NOT NULL,
  fecha_ingreso DATE NOT NULL,
  fecha_pago_limite DATE NOT NULL,
  monto FLOAT NOT NULL,
  estatus INT NOT NULL,
  PRIMARY KEY (factura_seguro_id),
  CONSTRAINT fk_factura_seguro_consulta
    FOREIGN KEY (consulta_id)
    REFERENCES shenque_db.consulta (consulta_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_factura_seguro_seguro
    FOREIGN KEY (seguro_id)
    REFERENCES shenque_db.seguro (seguro_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table shenque_db.usuario
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.usuario (
  usuario_id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(16) NOT NULL,
  clave VARCHAR(100) NOT NULL,
  tokken VARCHAR(10) UNIQUE,
  rol INT NOT NULL,
  estatus_usu enum('1','2') NOT NULL DEFAULT '1', -- 1 activo / 2 eliminado
  fecha_creacion DATETIME NOT NULL,
  PRIMARY KEY (usuario_id));

-- -----------------------------------------------------
-- Table shenque_db.auditoria
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shenque_db.auditoria (
  auditoria_id INT NOT NULL auto_increment,
  fecha_creacion VARCHAR(45) NOT NULL,
  usuario_id INT NOT NULL,
  accion VARCHAR(45) NOT NULL,
  descripcion VARCHAR(45) NOT NULL,
  fecha DATETIME NOT NULL,
  PRIMARY KEY (auditoria_id),
  CONSTRAINT fk_auditoria_usuario
    FOREIGN KEY (usuario_id)
    REFERENCES shenque_db.usuario (usuario_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
