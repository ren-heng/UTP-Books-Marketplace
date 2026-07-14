// =============================================
// APP.JS - UTP Marketplace
// =============================================

// ── Imagen de fallback si no carga ──────────
function imgFallback(el, emoji) {
  el.style.display = 'none';
  el.parentElement.querySelector('.no-img').style.display = 'flex';
}

let productos = [];


// ── CARRITO (localStorage) ─────────────────
function getCarrito() {
  const data = localStorage.getItem('utp_cart');
  return data ? JSON.parse(data) : [];
}

function addToCart(id) {
  let carrito = getCarrito();
  const idx = carrito.findIndex(x => x.id === id);
  if (idx >= 0) {
    carrito[idx].qty += 1;
  } else {
    carrito.push({ id, qty: 1 });
  }
  localStorage.setItem('utp_cart', JSON.stringify(carrito));
  updateCartCount();
}

function updateCartCount() {
  const carrito = getCarrito();
  const total = carrito.reduce((sum, x) => sum + x.qty, 0);
  document.querySelectorAll('#cartCount').forEach(el => {
    el.textContent = total;
    el.style.display = total > 0 ? 'flex' : 'none';
  });
}

// ── RENDER DE TARJETA con imagen real ────────
function renderCard(p) {
  const stars = '★'.repeat(Math.round(p.rating)) + '☆'.repeat(5 - Math.round(p.rating));
  const descuento = p.precioOriginal
    ? `<span class="product-card__badge">-${Math.round((1 - p.precio / p.precioOriginal) * 100)}%</span>`
    : '';

  // Imagen real o fallback emoji
  const imgContent = p.img
    ? `<img src="${p.img}"
           alt="${p.nombre}"
           loading="lazy"
           onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
       <div class="no-img" style="display:none">${p.emoji}</div>`
    : `<div class="no-img">${p.emoji}</div>`;

  return `
    <div class="product-card">
      ${descuento}
      <button class="product-card__wish" onclick="toggleWish(this)" title="Guardar">♡</button>
      <div class="product-card__img">
        ${imgContent}
        <div class="product-card__actions">
          <a href="detalle.html?id=${p.id}" class="btn btn--white btn--sm">
            <i class="bi bi-eye"></i> Ver
          </a>
          <button onclick="addToCart(${p.id}); showCartFeedback(this)" class="btn btn--accent btn--sm">
            <i class="bi bi-bag-plus"></i> Agregar
          </button>
        </div>
      </div>
      <div class="product-card__body">
        <div class="product-card__category">${p.categoria}</div>
        <h3 class="product-card__title">${p.nombre}</h3>
        <div class="product-card__seller">
          <i class="bi bi-person-circle"></i> ${p.vendedor} · ${p.sede}
        </div>
        <div class="product-card__footer">
          <div class="product-card__price">
            ${p.precioOriginal ? `<span class="old-price">S/ ${p.precioOriginal.toFixed(2)}</span>` : ''}
            S/ ${p.precio.toFixed(2)}
          </div>
          <div class="product-card__rating">
            ${stars.slice(0, 5)}
            <span>(${p.resenas})</span>
          </div>
        </div>
      </div>
    </div>
  `;
}

function toggleWish(btn) {
  btn.classList.toggle('active');
  btn.textContent = btn.classList.contains('active') ? '♥' : '♡';
}

function showCartFeedback(btn) {
  const original = btn.innerHTML;
  btn.innerHTML = '<i class="bi bi-check"></i> Agregado';
  btn.style.background = '#27AE60';
  setTimeout(() => {
    btn.innerHTML = original;
    btn.style.background = '';
  }, 1500);
}


// =================================================================
// CONTROL DINÁMICO DE INICIO DE SESIÓN
// =================================================================

// Escucha cuando la página termina de cargar por completo en el navegador
document.addEventListener("DOMContentLoaded", () => {

  // Busca el espacio vacío que dejamos en el menú HTML con el ID "menuSesion"
  const menuSesion = document.getElementById("menuSesion");
  if (!menuSesion) return; // Si la página no tiene este menú, detiene la función

  // Lee los datos guardados en la memoria del navegador para saber quién se conectó
  const nombre = localStorage.getItem("usuario_nombre");
  const rol = localStorage.getItem("usuario_rol");

  // EVALUACIÓN: ¿Existe un usuario con sesión iniciada?
  if (nombre) {
        // SI HAY SESIÓN INICIADA
        if (rol === "admin") {
            menuSesion.innerHTML = `
                <div class="d-flex align-items-center h-100 gap-2 ms-lg-3">
                    <a class="nav-link text-warning fw-bold p-0" href="admin/index.php">Panel Admin</a>
                    <a class="nav-link text-danger fw-bold p-0" href="#" onclick="cerrarSesionLocal(event)">Salir</a>
                </div>
            `;
        } 
                // SI EL USUARIO ES UN CLIENTE REGISTRADO (Como Lucía)
        else {
            menuSesion.innerHTML = `
                <div class="d-flex align-items-center h-100 ms-lg-3 my-2 my-lg-0 gap-3">
                    <span class="text-white fw-medium d-flex align-items-center gap-1" style="font-size: 0.95rem;">
                        <svg xmlns="http://w3.org" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                        </svg>
                        Hola, <strong class="text-warning">${nombre}</strong>
                    </span>
                    <a class="btn fw-bold px-3 btn-sm" href="#" onclick="cerrarSesionLocal(event)" 
                       style="background-color: #ffffff; color: #1a252f; border-radius: 50px; font-size: 0.85rem; border: 1px solid transparent; transition: all 0.2s ease-in-out;"
                       onmouseover="this.style.backgroundColor='rgba(255,255,255,0.85)';"
                       onmouseout="this.style.backgroundColor='#ffffff';">
                        Salir
                    </a>
                </div>
            `;
        }

        
    } else {
        // SI NO HAY NADIE CONECTADO: Botón con efecto hover dinámico al pasar el cursor
        menuSesion.innerHTML = `
            <div class="d-flex align-items-center h-100 ms-lg-3 my-2 my-lg-0">
                <a class="btn fw-bold px-3 btn-sm" href="login.html" 
                   id="btnIniciarSesionNav"
                   style="background-color: #1a252f; color: #ffffff; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; white-space: nowrap; transition: all 0.2s ease-in-out;"
                   onmouseover="this.style.backgroundColor='#2c3e50'; this.style.borderColor='#ffffff';"
                   onmouseout="this.style.backgroundColor='#1a252f'; this.style.borderColor='rgba(255,255,255,0.2)';">
                    Iniciar Sesión
                </a>
            </div>
        `;
    }
});

// Función encargada de borrar los datos de la cuenta cuando se presiona "Salir"
function cerrarSesionLocal(e) {
  e.preventDefault(); // Detiene el comportamiento por defecto del enlace

  // Borra las credenciales guardadas en la memoria del navegador (localStorage)
  localStorage.removeItem("usuario_nombre");
  localStorage.removeItem("usuario_rol");

  // Redirige al archivo PHP que limpia la memoria de sesiones en el servidor XAMPP
  window.location.href = "php/logout.php";
}
