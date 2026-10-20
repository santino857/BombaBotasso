  <!-- MODAL DE PEDIDO / CARRITO -->
  <div class="cart-modal-overlay" id="cartModalOverlay" onclick="if(event.target === this) toggleCartModal()">
    <div class="cart-modal">
      <div class="cart-modal-header">
        <div class="cart-title-wrap">
          <i class="fas fa-shopping-basket"></i>
          <h3>Tu Pedido Artesanal</h3>
        </div>
        <button type="button" class="cart-close-btn" onclick="toggleCartModal()">&times;</button>
      </div>

      <div class="cart-modal-body">
        <div id="cartEmptyState" class="cart-empty-state">
          <i class="fas fa-drumstick-bite"></i>
          <p>Tu carrito está vacío.</p>
          <span>Elegí tus cortes y productos favoritos en la sección de Productos.</span>
          <button type="button" class="btn btn-primary btn-sm" onclick="toggleCartModal(); location.href='#productos';">
            Ver Productos
          </button>
        </div>

        <div id="cartItemsContainer" style="display: none;">
          <div class="cart-items-list" id="cartItemsList"></div>

          <div class="cart-summary-box">
            <div class="summary-line">
              <span>Subtotal estimado:</span>
              <strong id="cartSubtotalText">$ 0</strong>
            </div>
            <p class="summary-note"><i class="fas fa-info-circle"></i> Los cortes frescos se pesan en mostrador. El total final puede variar levemente según el peso exacto.</p>
          </div>

          <form id="orderForm" onsubmit="confirmOrder(event)" class="order-form">
            <h4 class="order-form-title">Datos para tu pedido</h4>
            <div class="form-row">
              <div class="form-group">
                <label for="orderName">Nombre y Apellido *</label>
                <input type="text" id="orderName" required value="<?= esc(session()->get('name') ?? '') ?>" placeholder="Ej: Juan Pérez" />
              </div>
              <div class="form-group">
                <label for="orderPhone">WhatsApp / Teléfono *</label>
                <input type="text" id="orderPhone" required placeholder="Ej: 3571 556677" />
              </div>
            </div>
            <div class="form-group">
              <label for="orderAddress">Dirección de Entrega / Retiro en local</label>
              <input type="text" id="orderAddress" placeholder="Ej: Retiro por Belgrano 243 o mi dirección para delivery" />
            </div>
            <div class="form-group">
              <label for="orderNotes">Notas adicionales / Aclaraciones del corte</label>
              <textarea id="orderNotes" rows="2" placeholder="Ej: Cortes gruesos para asador, salame bien seco..."></textarea>
            </div>

            <div class="cart-actions">
              <button type="button" class="btn btn-outline-danger" onclick="clearCart()">
                <i class="fas fa-trash-alt"></i> Vaciar
              </button>
              <button type="submit" class="btn btn-whatsapp btn-order">
                <i class="fab fa-whatsapp"></i> Confirmar y Enviar Pedido
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="footer-inner">
      <div class="footer-brand">
        <span class="logo-main">La Boutique</span>
        <span class="logo-sub">del Cerdo</span>
      </div>
      <p>Belgrano 243 · Río Tercero, Córdoba · Argentina</p>
      <div class="footer-socials">
        <a href="https://wa.me/5493571523376" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
        <a href="https://www.instagram.com/laboutiquedelcerdo.rio3" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://www.google.com/search?q=la+boutique+del+cerdo" target="_blank" title="Google"><i class="fab fa-google"></i></a>
        <a href="tel:03571410310" title="Teléfono Fijo"><i class="fas fa-phone"></i></a>
      </div>
      <p class="footer-copy">© 2026 La Boutique del Cerdo. Tradición y Calidad Cordobesa.</p>
    </div>
  </footer>

  <!-- WA FLOAT -->
  <a href="https://wa.me/5493571523376" class="wa-float" target="_blank" aria-label="WhatsApp">
    <i class="fab fa-whatsapp"></i>
  </a>

  <!-- SCRIPTS -->
  <script>
    // --- ESTADO DEL CARRITO ---
    let cart = [];
    try {
      const stored = localStorage.getItem('boutique_cart');
      if (stored) cart = JSON.parse(stored);
    } catch(e) { cart = []; }

    function saveCart() {
      try {
        localStorage.setItem('boutique_cart', JSON.stringify(cart));
      } catch(e) {}
      updateCartUI();
    }

    function addToCart(id, name, price, tag) {
      const existing = cart.find(item => item.id == id);
      if (existing) {
        existing.qty += 1;
      } else {
        cart.push({ id, name, price: parseFloat(price) || 0, tag: tag || 'Fresco', qty: 1 });
      }
      saveCart();
      showToast(`¡"${name}" agregado al pedido!`);
    }

    function changeQty(id, delta) {
      const item = cart.find(i => i.id == id);
      if (!item) return;
      item.qty += delta;
      if (item.qty <= 0) {
        cart = cart.filter(i => i.id != id);
      }
      saveCart();
    }

    function removeFromCart(id) {
      cart = cart.filter(i => i.id != id);
      saveCart();
    }

    function clearCart() {
      if (confirm('¿Deseas vaciar tu pedido?')) {
        cart = [];
        saveCart();
      }
    }

    function updateCartUI() {
      const totalQty = cart.reduce((acc, i) => acc + i.qty, 0);
      const totalAmt = cart.reduce((acc, i) => acc + (i.price * i.qty), 0);

      const b1 = document.getElementById('cartCountBadge');
      const b2 = document.getElementById('cartCountBadgeMobile');
      const b3 = document.getElementById('cartCountTextMobile');
      if (b1) b1.textContent = totalQty;
      if (b2) b2.textContent = totalQty;
      if (b3) b3.textContent = totalQty;

      const emptyEl = document.getElementById('cartEmptyState');
      const contEl  = document.getElementById('cartItemsContainer');
      const listEl  = document.getElementById('cartItemsList');
      const subtEl  = document.getElementById('cartSubtotalText');

      if (!emptyEl || !contEl) return;

      if (cart.length === 0) {
        emptyEl.style.display = 'block';
        contEl.style.display = 'none';
      } else {
        emptyEl.style.display = 'none';
        contEl.style.display = 'block';

        listEl.innerHTML = cart.map(item => `
          <div class="cart-item-row">
            <div class="cart-item-info">
              <strong>${item.name}</strong>
              <div class="cart-item-meta">
                <span class="producto-tag">${item.tag}</span>
                <span class="item-price">$ ${item.price.toLocaleString('es-AR')}</span>
              </div>
            </div>
            <div class="cart-item-controls">
              <button type="button" class="qty-btn" onclick="changeQty(${item.id}, -1)">-</button>
              <span class="qty-val">${item.qty}</span>
              <button type="button" class="qty-btn" onclick="changeQty(${item.id}, 1)">+</button>
              <button type="button" class="del-btn" onclick="removeFromCart(${item.id})" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
            </div>
          </div>
        `).join('');

        subtEl.textContent = `$ ${totalAmt.toLocaleString('es-AR')}`;
      }
    }

    function toggleCartModal() {
      const modal = document.getElementById('cartModalOverlay');
      if (modal) {
        const isOpen = modal.classList.contains('active');
        if (isOpen) {
          modal.classList.remove('active');
          document.body.style.overflow = '';
        } else {
          modal.classList.add('active');
          document.body.style.overflow = 'hidden';
          updateCartUI();
        }
      }
    }

    function confirmOrder(e) {
      e.preventDefault();
      if (cart.length === 0) {
        alert('Tu pedido está vacío.');
        return;
      }

      const name = document.getElementById('orderName').value.trim();
      const phone = document.getElementById('orderPhone').value.trim();
      const address = document.getElementById('orderAddress').value.trim();
      const notes = document.getElementById('orderNotes').value.trim();
      const total = cart.reduce((acc, i) => acc + (i.price * i.qty), 0);

      let itemsSummary = cart.map(i => `• ${i.qty}x ${i.name} ($ ${ (i.price * i.qty).toLocaleString('es-AR') })`).join('\n');

      // 1. Guardar en Backend via AJAX
      const formData = new FormData();
      formData.append('customer_name', name);
      formData.append('customer_phone', phone);
      formData.append('customer_address', address);
      formData.append('notes', notes);
      formData.append('items_summary', itemsSummary);
      formData.append('total', total);
      formData.append('items', JSON.stringify(cart));

      fetch('<?= base_url('pedidos/guardar') ?>', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      }).catch(err => console.error('Error guardando pedido en BD:', err));

      // 2. Formatear y Enviar a WhatsApp
      let msg = `🐖 *NUEVO PEDIDO - LA BOUTIQUE DEL CERDO*\n\n`;
      msg += `👤 *Cliente:* ${name}\n`;
      msg += `📞 *Teléfono:* ${phone}\n`;
      if (address) msg += `📍 *Dirección/Entrega:* ${address}\n`;
      if (notes) msg += `📝 *Aclaraciones:* ${notes}\n`;
      msg += `\n🛒 *DETALLE DEL PEDIDO:*\n${itemsSummary}\n\n`;
      msg += `💰 *TOTAL ESTIMADO:* $ ${total.toLocaleString('es-AR')}\n\n`;
      msg += `_¡Muchas gracias por su atención!_`;

      const waUrl = `https://wa.me/5493571523376?text=${encodeURIComponent(msg)}`;
      window.open(waUrl, '_blank');

      // Limpiar y cerrar
      cart = [];
      saveCart();
      toggleCartModal();
      alert('¡Tu pedido ha sido generado con éxito! Te responderemos a la brevedad por WhatsApp.');
    }

    // --- COMENTARIOS / RESEÑAS ---
    let selectedStars = 5;
    const starContainer = document.getElementById('starRating');
    if (starContainer) {
      const stars = starContainer.querySelectorAll('span');
      stars.forEach(s => {
        s.addEventListener('mouseover', () => highlightStars(+s.dataset.val));
        s.addEventListener('mouseout', () => highlightStars(selectedStars));
        s.addEventListener('click', () => { selectedStars = +s.dataset.val; highlightStars(selectedStars); });
      });
    }

    function highlightStars(n) {
      if (!starContainer) return;
      const stars = starContainer.querySelectorAll('span');
      stars.forEach(s => s.classList.toggle('active', +s.dataset.val <= n));
    }
    if (starContainer) highlightStars(5);

    function publicarComentario() {
      const nameInput = document.getElementById('commentName');
      const textInput = document.getElementById('commentText');
      if (!nameInput || !textInput) return;

      const name = nameInput.value.trim();
      const text = textInput.value.trim();
      if (!name || !text) {
        alert('Por favor completá tu nombre y comentario.');
        return;
      }

      const publishBtn = document.getElementById('btnPublicarComentario');
      const originalHtml = publishBtn ? publishBtn.innerHTML : 'Publicar';
      if (publishBtn) {
        publishBtn.disabled = true;
        publishBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Publicando...';
      }

      const formData = new FormData();
      formData.append('name', name);
      formData.append('comment', text);
      formData.append('stars', selectedStars);

      fetch('<?= base_url('comentarios/guardar') ?>', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          const starsStr = '★'.repeat(selectedStars) + '☆'.repeat(5 - selectedStars);
          const card = document.createElement('div');
          card.className = 'comment-card new-comment';
          card.innerHTML = `
            <div class="comment-header">
              <div class="comment-avatar">${name[0].toUpperCase()}</div>
              <div>
                <strong>${name}</strong>
                <span>${data.data ? data.data.subtitle : 'Cliente'}</span>
              </div>
              <div class="comment-stars">${starsStr}</div>
            </div>
            <p>"${text}"</p>`;
          
          const list = document.getElementById('commentsList');
          if (list) list.prepend(card);

          nameInput.value = '';
          textInput.value = '';
          selectedStars = 5;
          highlightStars(5);
          showToast('¡Tu comentario fue publicado con éxito!');
        } else {
          alert('No se pudo publicar el comentario: ' + (data.errors ? Object.values(data.errors).join(', ') : 'Error'));
        }
      })
      .catch(err => {
        console.error(err);
        alert('Error de conexión al enviar el comentario.');
      })
      .finally(() => {
        if (publishBtn) {
          publishBtn.innerHTML = originalHtml;
          publishBtn.disabled = false;
        }
      });
    }

    // --- FORMULARIO DE CONSULTAS ---
    function enviarConsulta(e) {
      e.preventDefault();
      const nombre = document.getElementById('nombre').value.trim();
      const contacto = document.getElementById('contacto-form').value.trim();
      const mensaje = document.getElementById('mensaje').value.trim();

      // Guardar en backend
      const formData = new FormData();
      formData.append('nombre', nombre);
      formData.append('contacto', contacto);
      formData.append('mensaje', mensaje);

      fetch('<?= base_url('consultas/guardar') ?>', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      }).catch(e => console.error(e));

      // Abrir WhatsApp
      let texto = `Hola! Soy *${nombre}*.\n\n${mensaje}`;
      if (contacto) texto += `\n\nMi contacto: ${contacto}`;
      const url = `https://wa.me/5493571523376?text=${encodeURIComponent(texto)}`;
      window.open(url, '_blank');

      showToast('¡Consulta enviada! Te esperamos por WhatsApp.');
      document.getElementById('consultaForm').reset();
    }

    // --- TOAST NOTIFICATIONS ---
    function showToast(msg) {
      let toast = document.getElementById('globalToast');
      if (!toast) {
        toast = document.createElement('div');
        toast.id = 'globalToast';
        toast.className = 'global-toast';
        document.body.appendChild(toast);
      }
      toast.innerHTML = `<i class="fas fa-check-circle"></i> ${msg}`;
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 3500);
    }

    // --- NAVBAR & ANIMACIONES ---
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
      if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 60);
    });

    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');
    if (hamburger && mobileMenu) {
      hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('open');
        mobileMenu.classList.toggle('open');
      });
    }
    function closeMobile() {
      if (hamburger && mobileMenu) {
        hamburger.classList.remove('open');
        mobileMenu.classList.remove('open');
      }
    }

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) e.target.classList.add('visible');
      });
    }, { threshold: 0.12 });
    document.querySelectorAll('.producto-card, .info-card, .nosotros-inner, .nosotros-datos .dato, .comment-card').forEach(el => observer.observe(el));

    // Inicializar UI al cargar
    document.addEventListener('DOMContentLoaded', () => {
      updateCartUI();
    });
  </script>
</body>
</html>