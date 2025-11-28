document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".status-toggle").forEach(checkbox => { //Recorre cada checkbox con la clase status-toggle
        checkbox.addEventListener("change", function () { //Agrega un evento al cambiar el estado del checkbox
            const userId = this.getAttribute("data-id"); //Obtiene el ID del usuario desde el atributo data-id
            const newState = this.checked ? "active" : "inactive"; //Operador ternario, si está marcado, el nuevo estado es "active", si no, "inactive"
             

           
            fetch("../actions/updateStatus.php", { //Envía una solicitud POST a updateStatus.php
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" }, //Especifica el tipo de contenido, FORM
                body: `id=${encodeURIComponent(userId)}&state=${encodeURIComponent(newState)}` //Envía los datos del ID y el nuevo estado codificados en la solicitud
            })   
        });
    });
});

