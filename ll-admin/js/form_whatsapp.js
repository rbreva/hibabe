let numero_wsp = document.querySelector("#numero_wsp");
let numero_wsp_alert = document.querySelector("#numero_wsp_alert");
let descripcion_wsp = document.querySelector("#descripcion_wsp");
let descripcion_wsp_alert = document.querySelector("#descripcion_wsp_alert");

let acc_btn = document.querySelector("#acc_btn");

acc_btn.addEventListener("click", (e) => {
  e.preventDefault();
  numero_wsp_alert.innerHTML = "";
  if (numero_wsp.value == "") {
    numero_wsp_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (descripcion_wsp.value == "") {
    descripcion_wsp_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (numero_wsp.value != "" && descripcion_wsp.value != "") {
    document.querySelector("#form_editar_whatsapp").submit();
  }
});
