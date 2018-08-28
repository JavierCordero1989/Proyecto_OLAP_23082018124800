/**
 *Tomamos el gráfico (canvas) y lo convertimos en una variable
 */



/**
 * Descargamos la imagen en PNG
 */
function descargarPNG(link, canvasId, filename) {
    var grafico = document.getElementById(canvasId), ctx = grafico.getContext('2d');
    link.href = document.getElementById(canvasId).toDataURL("image/png");
    link.download = filename;
}

/**
 * Descargamos la imagen en  JPG
 * La diferencia del png es que se le agrega fondo blanco
 */
function descargarJPG(link, canvasId, filename) {
    //---Se cambia el fondo
    var grafico = document.getElementById(canvasId), ctx = grafico.getContext('2d');
    var datos;
    var canvas = document.getElementById(canvasId);
    var ctx = canvas.getContext('2d');
    datos = ctx.getImageData(100, 0, canvas.width, canvas.height);
    var compositeOperation = ctx.globalCompositeOperation;
    ctx.globalCompositeOperation = "destination-over";
    ctx.fillStyle = 'white';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    var imagen = canvas.toDataURL("image/jpg");
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    //restaura la imagen-canvas
    ctx.putImageData(datos, 0,0);
    //resetear la globalCompositeOperation
    ctx.globalCompositeOperation = compositeOperation;
    //---Fondo cambiado
    link.href = imagen;
    link.download = filename;
}

/**
 * Se llama a la descarga en PNG
 */
// document.getElementById('descargaPNG').addEventListener('click', function() {
//     descargarPNG(this, 'myChart', 'PNG_f'+getFechaString()+'.png');
// }, false);

/**
 * Se llama a la descarga en JPG
 */
// document.getElementById('descargaJPG').addEventListener('click', function() {
//     descargarJPG(this, 'myChart', 'JPG_f'+getFechaString()+'.jpg');
// }, false);

/**
 * Método para generar la fecha y hora en un string
 */
function getFechaString() {
    var ahora = new Date();
    return ahora.getDate()+"_"+ahora.getMonth()+"_"
        +ahora.getFullYear()+"_h"+ahora.getHours()
        +" y "+ ahora.getMinutes()+"_"+ahora.getSeconds();
}