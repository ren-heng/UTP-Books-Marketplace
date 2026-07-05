
// ===============================
// CARRITO.JS
// ===============================

let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

const lista = document.getElementById("listaCarrito");
const subtotal = document.getElementById("subtotal");
const total = document.getElementById("total");

// Mostrar productos
function mostrarCarrito() {

    lista.innerHTML = "";

    if (carrito.length === 0) {

        lista.innerHTML = `
            <div class="text-center p-4">
                <h4>Tu carrito está vacío</h4>
                <a href="productos.html" class="btn btn-primary mt-3">
                    Ir a comprar
                </a>
            </div>
        `;

        subtotal.textContent = "S/ 0.00";
        total.textContent = "S/ 0.00";

        return;
    }

    let suma = 0;

    carrito.forEach((producto, index) => {

        suma += producto.precio * producto.cantidad;

        lista.innerHTML += `
            <div class="card mb-3">
                <div class="row g-0 align-items-center">

                    <div class="col-md-3 text-center p-2">
                        <img src="${producto.img}" class="img-fluid" style="max-height:120px;">
                    </div>

                    <div class="col-md-6">
                        <div class="card-body">
                            <h5>${producto.nombre}</h5>
                            <p>Precio: <strong>S/ ${producto.precio}</strong></p>
                            <p>Cantidad: ${producto.cantidad}</p>
                        </div>
                    </div>

                    <div class="col-md-3 text-center">

                        <h5>S/ ${(producto.precio * producto.cantidad).toFixed(2)}</h5>

                        <button class="btn btn-danger btn-sm"
                            onclick="eliminar(${index})">

                            Eliminar

                        </button>

                    </div>

                </div>
            </div>
        `;
    });

    subtotal.textContent = "S/ " + suma.toFixed(2);
    total.textContent = "S/ " + suma.toFixed(2);

    localStorage.setItem("carrito", JSON.stringify(carrito));
}

// Eliminar producto
function eliminar(index) {

    carrito.splice(index, 1);

    mostrarCarrito();

}

// Vaciar carrito
document.getElementById("vaciarCarrito").addEventListener("click", () => {

    carrito = [];

    localStorage.removeItem("carrito");

    mostrarCarrito();

});

// Comprar
document.getElementById("btnComprar").addEventListener("click", () => {

    if (carrito.length === 0) {

        alert("El carrito está vacío.");

        return;
    }

    alert("¡Compra realizada con éxito!");

    carrito = [];

    localStorage.removeItem("carrito");

    mostrarCarrito();

});

// Mostrar al abrir la página
mostrarCarrito();
