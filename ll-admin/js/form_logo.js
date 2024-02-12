function mostrarImagen(input) {
  if ( input.files && input.files[0] ) {
    let reader = new FileReader();
    reader.onload = function (e) {
      $('#img_destino').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#file_url").change(function () {
  mostrarImagen(this);
} );

//Funcion de JS que valida el archivo ingresado al input. Formato y Tamaño.
function validarFile(all)
{
//EXTENSIONES Y TAMANO PERMITIDO.
let extensiones_permitidas = [".svg"];
let tamano = 8; // EXPRESADO EN MB.
let rutayarchivo = all.value;
let ultimo_punto = all.value.lastIndexOf(".");
let extension = rutayarchivo.slice(ultimo_punto, rutayarchivo.length);
if(extensiones_permitidas.indexOf(extension) == -1)
{
  //alert("Extensión de archivo no valida");
  $(".solosvg").show();
  setTimeout(function(){
    $(".solosvg").hide();
  },3000)
  document.getElementById(all.id).value = "";
  return; // Si la extension es no válida ya no chequeo lo de abajo.
}
  if((all.files[0].size / 1048576) > tamano)
  {
    //alert("El archivo no puede superar los "+tamano+"MB");
    $(".granrp").show();
    setTimeout(function(){
      $(".granrp").hide();
    },3000)
    document.getElementById(all.id).value = "";
    return;
  }
}