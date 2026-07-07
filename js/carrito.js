// ======================================
// CARRITO.JS
// Compatible con app.js
// ======================================

let carrito = JSON.parse(localStorage.getItem("utp_cart")) || [];

const lista = document.getElementById("listaCarrito");
const subtotal = document.getElementById("subtotal");
const total = document.getElementById("total");

// Cargar productos desde PHP
async function cargarProductos() {

    try {

        const respuesta = await fetch("php/productos.php");
        const productos = await respuesta.json();

        mostrarCarrito(productos);

    } catch (error) {

        console.error(error);

        lista.innerHTML = `
            <div class="alert alert-danger">
                Error al cargar los productos.
            </div>
        `;

    }

}

// Mostrar carrito
function mostrarCarrito(productos) {

    lista.innerHTML = "";

    if (carrito.length === 0) {

        lista.innerHTML = `
            <div class="text-center p-5">

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

    carrito.forEach((item, index) => {

        const libro = productos.find(p => p.id == item.id);

        if (!libro) return;

        const cantidad = item.qty;
        const importe = libro.precio * cantidad;

        suma += importe;

        lista.innerHTML += `

        <div class="card mb-3 shadow-sm">

            <div class="row g-0 align-items-center">

                <div class="col-md-3 text-center p-2">

                    <img
                        src="img/${libro.imagen}"
                        class="img-fluid"
                        style="max-height:130px;">

                </div>

                <div class="col-md-6">

                    <div class="card-body">

                        <h5>${libro.nombre}</h5>

                        <p class="mb-1">
                            Precio: <strong>S/ ${Number(libro.precio).toFixed(2)}</strong>
                        </p>

                        <p class="mb-0">
                            Cantidad: ${cantidad}
                        </p>

                    </div>

                </div>

                <div class="col-md-3 text-center">

                    <h5>S/ ${importe.toFixed(2)}</h5>

                    <button
                        class="btn btn-danger btn-sm"
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

}

// Eliminar
function eliminar(index) {

    carrito.splice(index,1);

    localStorage.setItem("utp_cart", JSON.stringify(carrito));

    cargarProductos();

}

// Vaciar carrito
document
.getElementById("vaciarCarrito")
.addEventListener("click", () => {

    if(!confirm("¿Vaciar el carrito?")) return;

    carrito=[];

    localStorage.removeItem("utp_cart");

    cargarProductos();

});

// Comprar
document
.getElementById("btnComprar")
.addEventListener("click", async ()=>{

    if(carrito.length==0){

        alert("El carrito está vacío.");

        return;

    }

    try{

        const respuesta = await fetch("php/guardar_venta.php",{

            method:"POST",

            headers:{
                "Content-Type":"application/json"
            },

            body:JSON.stringify(carrito)

        });

        const datos = await respuesta.json();

        if(datos.success){

            alert("Compra realizada correctamente.");

            carrito=[];

            localStorage.removeItem("utp_cart");

            cargarProductos();

        }else{

            alert(datos.message);

        }

    }catch(error){

        console.error(error);

        alert("Error al registrar la venta.");

    }

});

cargarProductos();
