const input = document.getElementById('picture'); // obtengo el input de tipo file
const img = document.getElementById('preview'); // obtengo la imagen donde se mostrará la previsualización
input.addEventListener('change', (e) => { // cuando cambie el input (se seleccione un archivo)
    const file = e.target.files?.[0]; // obtengo el primer archivo seleccionado
    if (!file) { img.classList.add('hidden'); img.removeAttribute('src'); return; } // si no hay archivo, oculto la imagen y salgo
    img.src = URL.createObjectURL(file); // creo una URL temporal para el archivo seleccionado
    img.classList.remove('hidden'); // muestro la imagen
});