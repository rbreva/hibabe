let txt_name = document.querySelector("#txt_name");
let txt_name_alert = document.querySelector("#txt_name_alert");
let acc_btn = document.querySelector("#acc_btn");

acc_btn.addEventListener("click", (e) => {
  e.preventDefault();
  txt_name_alert.innerHTML = "";
  if (txt_name.value == "") {
    txt_name_alert.innerHTML = "Este campo no puede estar vacío";
  }
  if (txt_name.value != "") {
    document.querySelector("#form_create_menu").submit();
  }
});
