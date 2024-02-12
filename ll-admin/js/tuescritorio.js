function exportarExcel() {
    /* Obtén la tabla HTML como objeto de trabajo */
    var tabla = document.getElementById('miTabla');

    /* Crea una nueva instancia de Workbook de xlsx */
    var wb = XLSX.utils.table_to_book(tabla);

    /* Convierte el libro a formato binario en forma de arreglo */
    var binario = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });

    /* Convierte el arreglo a un objeto Blob */
    var blob = new Blob([binario], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

    /* Crea un enlace temporal para descargar el archivo */
    var enlace = document.createElement('a');
    enlace.href = URL.createObjectURL(blob);
    enlace.download = 'miarchivo.xlsx';

    /* Simula un clic en el enlace para descargar el archivo */
    document.body.appendChild(enlace);
    enlace.click();

    /* Limpia el enlace y libera recursos */
    document.body.removeChild(enlace);
}
