document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".status-toggle").forEach(checkbox => {

        checkbox.addEventListener("change", function () {
            
            const userId = this.dataset.id; //Se captura mas facil con dataset, ya que el atributo en html es data
            const url = this.dataset.url;  //url capturada para no utilizar php en js
            const newStatus = this.checked ? "active" : "inactive";

            fetch(url, { //Redirifimos a la ruta de la const url
                method: "POST",
                headers: { 
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `id=${encodeURIComponent(userId)}&status=${encodeURIComponent(newStatus)}`
            })

        });
    });
});



