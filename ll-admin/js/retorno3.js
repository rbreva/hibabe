document.addEventListener("DOMContentLoaded", function() {
  var botonRegreso = document.getElementById("botonRegreso");
  
  botonRegreso.addEventListener("click", function(e) {
      e.preventDefault();
      window.history.go(-3);
  });
});