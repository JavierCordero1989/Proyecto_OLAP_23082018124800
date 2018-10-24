/** Está función permite convertir la hora, en el formato local */
function convertUTCDateToLocalDate(fecha) {
    let nuevaFecha = new Date(fecha.getTime()+fecha.getTimezoneOffset()*60*1000);

    let offset = fecha.getTimezoneOffset() / 60;
    let hours = fecha.getHours();

    nuevaFecha.setHours(hours - offset);

    return nuevaFecha;
}

function validatePassword(input) {
    if(typeof input !== 'object') {
        alert('Ha ocurrido un error. El valor del parámetro para la función \"validatePassword\" debe ser un objeto de tipo input.');
        return false;
    }
    else {
        // Para contraseña, debe cumplir con lo siguiente:
        // una letra minúscula, una letra mayúscula, un dígito, cualquiera de estos caractéres (@/$/!/%/*/?/./_/-)
        // debe contener de 8 a 15 caractéres
        // Expresión regular =>
        /*   /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?.-_])[A-Za-z\d@$!%*?.-_]{7,15}$/   */

        // Para el email, debe cumplir con lo siguiente:
        // puede contener cualquier texto antes del @ (arroba), sin embargo ese texto no puede tener
        // espacios en blanco, ampersand, asterisco, guion, barra inclinada, simbolos de pregunta
        // y admiracion y apostrofe. Discho simbolos no se aceptan. Además el correo deberá siempre
        // contener "@conare.ac.cr"
        /*   /^[^\&*-/¿¡!?']{2,}@conare\.ac\.cr$/   */
    }
}