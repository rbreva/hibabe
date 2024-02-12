let txt_ruta = document.querySelector("#txt_ruta");
let txt_ruta_alert = document.querySelector("#txt_ruta_alert");

let acc_btn = document.querySelector("#acc_btn");

acc_btn.addEventListener("click", (e) => {
  e.preventDefault();
  txt_ruta_alert.innerHTML = "";
  if (txt_ruta.value == "") {
    txt_ruta_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (txt_ruta.value != "") {
    document.querySelector("#form_editar_redes").submit();
  }
});
