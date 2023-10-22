// ** Define patrones de expresiones regulares para validar los campos
export const patterns = {
    username: /^[a-zA-Z0-9_-]{1,16}$/, // Patrón para nombre de usuario
    password: /^(?=.*\d)[\d\w@-]{8,20}$/i, // Patrón para contraseña
    email: /^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/, // Patrón para email
    phone: /^\d{7}$/, // Patrón para número de teléfono
    rif: /^\d{9}$/, // Patrón para RIF
    pin: /^\d{6,}$/, // Patrón para el pin
    dni: /^\d{6,8}$/, //Patrón para la cédula
    address: /^(?=.*[^\s])(?=.*[a-zA-Z0-9 @#+_,-])[a-zA-Z0-9 @#+_,-]{1,255}$/, // Patrón para dirección
    name: /^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/, // Patrón para nombres
    number: /^[1-9]\d*$/, // Patrón para validar inputs tipo number
    price: /^[0-9]*\.?[0-9]+$/, // Patrón para los precios
    date: /^\d{4}([\-/. ])(0?[1-9]|1[1-2])([\-/. ])(0?[1-9]|[1-2][0-9]|3[01])$/ // Patrón para fecha
};