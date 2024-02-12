let txt_username = document.querySelector("#txt_username");
let txt_username_alert = document.querySelector("#txt_username_alert");
let txt_name = document.querySelector("#txt_name");
let txt_name_alert = document.querySelector("#txt_name_alert");
let txt_lastname = document.querySelector("#txt_lastname");
let txt_lastname_alert = document.querySelector("#txt_lastname_alert");
let txt_email = document.querySelector("#txt_email");
let txt_email_alert = document.querySelector("#txt_email_alert");
let txt_type = document.querySelector("#txt_type");
let txt_type_alert = document.querySelector("#txt_type_alert");
let slc_level = document.querySelector("#slc_level");
let slc_level_alert = document.querySelector("#slc_level_alert");
let pass_txt = document.querySelector("#pass_txt");
let pass_txt_alert = document.querySelector("#pass_txt_alert");
let rep_pass_txt = document.querySelector("#rep_pass_txt");
let rep_pass_txt_alert = document.querySelector("#rep_pass_txt_alert");
let acc_btn = document.querySelector("#acc_btn");

acc_btn.addEventListener("click", (e) => {
  e.preventDefault();
  txt_username_alert.innerHTML = "(El nombre de usuario es único, no podrá modificarse)";
  txt_name_alert.innerHTML = "";
  txt_lastname_alert.innerHTML = "";
  txt_email_alert.innerHTML = "(El email es único y no podrá modificarse)";
  txt_type_alert.innerHTML = "";
  slc_level_alert.innerHTML = "";
  pass_txt_alert.innerHTML = "";
  rep_pass_txt_alert.innerHTML = "";
  if (txt_username.value == "") {
    txt_username_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (txt_name.value == "") {
    txt_name_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (txt_lastname.value == "") {
    txt_lastname_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (txt_email.value == "") {
    txt_email_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (txt_type.value == "") {
    txt_type_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (slc_level.value == "") {
    slc_level_alert.innerHTML = "Seleccione un Opción";
  }
  if (pass_txt.value == "") {
    pass_txt_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (rep_pass_txt.value == "") {
    rep_pass_txt_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (pass_txt.value != rep_pass_txt.value) {
    pass_txt_alert.innerHTML = "Las contraseñas no coinciden";
    rep_pass_txt_alert.innerHTML = "Las contraseñas no coinciden";
  }
  if (txt_username.value != ""
    && txt_name.value != "" 
    && txt_lastname.value != "" 
    && txt_email.value != "" 
    && txt_type.value != "" 
    && slc_level.value != "" 
    && pass_txt.value != "" 
    && rep_pass_txt.value != "" 
    && pass_txt.value == rep_pass_txt.value) {
      let username = txt_username.value;
      let email = txt_email.value;

      let data = new URLSearchParams();
      data.append('username', username);
      data.append('email', email);

      let url = 'validar_disponibilidad.php';
      let options = {
        method: 'POST',
        body: data
      };

      fetch(url, options)
      .then(response => response.json())
      .then(data => {
        if (data.exists) {
          txt_username_alert.innerHTML = "Nombre de usuario o Correo electrónico no disponible";
          txt_email_alert.innerHTML = "Nombre de usuario o Correo electrónico no disponible";
        } else {
          document.querySelector("#form_crear_usuario").submit();
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }
});
