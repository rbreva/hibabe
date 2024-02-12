let txt_name = document.querySelector("#txt_name");
let txt_name_alert = document.querySelector("#txt_name_alert");
let txt_lastname = document.querySelector("#txt_lastname");
let txt_lastname_alert = document.querySelector("#txt_lastname_alert");
let txt_type = document.querySelector("#txt_type");
let txt_type_alert = document.querySelector("#txt_type_alert");
let slc_level = document.querySelector("#slc_level");
let slc_level_alert = document.querySelector("#slc_level_alert");

let pass_txt = document.querySelector("#pass_txt");
pass_txt.removeAttribute('required');
let pass_txt_alert = document.querySelector("#pass_txt_alert");

let rep_pass_txt = document.querySelector("#rep_pass_txt");
rep_pass_txt.removeAttribute('required');
let rep_pass_txt_alert = document.querySelector("#rep_pass_txt_alert");

let acc_btn = document.querySelector("#acc_btn");

acc_btn.addEventListener("click", (e) => {
  e.preventDefault();
  txt_name_alert.innerHTML = "";
  txt_lastname_alert.innerHTML = "";
  txt_type_alert.innerHTML = "";
  slc_level_alert.innerHTML = "";
  if (txt_name.value == "") {
    txt_name_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (txt_lastname.value == "") {
    txt_lastname_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (txt_type.value == "") {
    txt_type_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (slc_level.value == "") {
    slc_level_alert.innerHTML = "Seleccione un Opción";
  }
  if (txt_name.value != "" 
  && txt_lastname.value != "" 
  && txt_type.value != "" 
  && slc_level.value != ""
  && pass_txt.value == rep_pass_txt.value) {
    document.querySelector("#form_crear_usuario").submit();
  } else {
    pass_txt_alert.innerHTML = "Las contraseñas no coinciden";
    rep_pass_txt_alert.innerHTML = "Las contraseñas no coinciden";
  }
});
