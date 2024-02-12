const input = document.querySelector('input[type="file"]');
const img = document.querySelector('#img_destino');
const file_msg = document.querySelector('.file_msg');
const acc_btn = document.querySelector('.acc_btn');

input.addEventListener('change', function(event) {
  const file = event.target.files[0];
  if (file.type === 'image/svg+xml') {
    const fileSizeInBytes = file.size;
    const maxSizeInBytes = 1024 * 1024;
    if (fileSizeInBytes <= maxSizeInBytes) {
      const imageURL = URL.createObjectURL(file);
      img.src = imageURL;
      acc_btn.disabled = false;
    }else{
      file_msg.innerHTML = 'El archivo no puede superar los 1MB';
      acc_btn.disabled = true;
    }
  } else {
    file_msg.innerHTML = 'El archivo debe ser un SVG';
    acc_btn.disabled = true;
  }
});

acc_btn.addEventListener("click", (e) => {
  e.preventDefault();
    console.log('subimos el archivo')
    //document.querySelector("#form_editar_whatsapp").submit();
});
