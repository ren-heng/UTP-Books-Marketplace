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
