tinymce.init({
  selector: selectorDetail,
  language: 'es',
  content_style: 'body { font-size:14px }',
  menubar: false,
  plugins: [
    'autoresize',
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
  ],
  toolbar: 'undo redo | formatselect | ' +
    'bold italic backcolor | alignleft aligncenter ' +
    'alignright alignjustify | bullist numlist outdent indent | ' +
    'removeformat |',
});
