<?= view('templates/header') ?>

  <!-- HERO -->
  <section class="hero" id="inicio">
    <div class="hero-bg" style="background-image: url('<?= base_url('assets/img/img_1.jpg') ?>');">
      <div class="hero-overlay"></div>
      <div class="hero-texture"></div>
    </div>
    <div class="hero-content">
      <p class="hero-eyebrow">Río Tercero · Córdoba · Argentina</p>
      <h1 class="hero-title">
        La Boutique<br/><em>del Cerdo</em>
      </h1>
      <p class="hero-desc">Calidad artesanal, sabor cordobés.<br/>Los mejores cortes de cerdo, embutidos y productos frescos de la zona.</p>
      <div class="hero-ctas">
        <a href="#productos" class="btn btn-primary">
          <i class="fas fa-drumstick-bite"></i> Ver Productos
        </a>
        <a href="https://wa.me/5493571523376?text=Hola!%20Quisiera%20consultar%20por%20sus%20cortes%20y%20productos." target="_blank" class="btn btn-whatsapp">
          <i class="fab fa-whatsapp"></i> Escribinos al WhatsApp
        </a>
      </div>
    </div>
    <div class="hero-scroll">
      <span></span>
    </div>
  </section>

  <!-- FRANJA HORARIO -->
  <div class="horario-bar">
    <div class="horario-inner">
      <div class="horario-item">
        <i class="far fa-clock"></i>
        <div>
          <strong>Lunes a Sábado</strong>
          <span>08:00 – 13:00 hs</span>
        </div>
      </div>
      <div class="horario-divider"></div>
      <div class="horario-item">
        <i class="far fa-clock"></i>
        <div>
          <strong>Por la tarde</strong>
          <span>16:30 – 20:30 hs</span>
        </div>
      </div>
      <div class="horario-divider"></div>
      <div class="horario-item">
        <i class="fas fa-map-marker-alt"></i>
        <div>
          <strong>Belgrano 243</strong>
          <span>Río Tercero, Córdoba</span>
        </div>
      </div>
    </div>
  </div>

  <!-- PRODUCTOS -->
  <section class="productos" id="productos">
    <div class="section-header">
      <span class="section-tag">Lista de Precios y Cortes Seleccionados</span>
      <h2>Nuestros <em>Productos</em></h2>
      <p>Todos nuestros cortes de cerdo frescos, embutidos artesanales, fiambres de campo, elaborados y productos de despensa.</p>
    </div>

    <!-- BUSCADOR RÁPIDO DE PRODUCTOS -->
    <div class="productos-search-wrap">
      <i class="fas fa-search productos-search-icon"></i>
      <input type="text" id="productSearchInput" class="productos-search-input" placeholder="Buscar por corte o producto (ej: bondiola, costilla, salame, queso...)" oninput="filterAndSearchProducts()" />
    </div>

    <!-- FILTROS DE CATEGORÍA -->
    <div class="productos-filter-bar">
      <button type="button" class="filter-btn active" data-filter="todos" onclick="setCategoryFilter('todos')">Todos (<?= count($products) ?>)</button>
      <button type="button" class="filter-btn" data-filter="cortes" onclick="setCategoryFilter('cortes')">Cortes de Cerdo</button>
      <button type="button" class="filter-btn" data-filter="embutidos" onclick="setCategoryFilter('embutidos')">Embutidos</button>
      <button type="button" class="filter-btn" data-filter="fiambres" onclick="setCategoryFilter('fiambres')">Fiambres</button>
      <button type="button" class="filter-btn" data-filter="preparados" onclick="setCategoryFilter('preparados')">Preparados</button>
      <button type="button" class="filter-btn" data-filter="despensa" onclick="setCategoryFilter('despensa')">Despensa y Quesos</button>
      <button type="button" class="filter-btn" data-filter="pastas" onclick="setCategoryFilter('pastas')">Pastas</button>
      <button type="button" class="filter-btn" data-filter="parrilla" onclick="setCategoryFilter('parrilla')">Parrilla</button>
      <button type="button" class="filter-btn" data-filter="condimentos" onclick="setCategoryFilter('condimentos')">Sales y Especias</button>
    </div>

    <div class="productos-grid" id="productosGrid">
      <?php if (!empty($products)): ?>
        <?php foreach ($products as $prod): ?>
          <article class="producto-card" 
                   data-category="<?= esc(strtolower($prod['tag'])) ?>" 
                   data-name="<?= esc(mb_strtolower($prod['name'], 'UTF-8')) ?>" 
                   data-desc="<?= esc(mb_strtolower($prod['description'] ?? '', 'UTF-8')) ?>"
                   data-code="<?= esc($prod['code_int'] ?? '') ?>">
            <div class="producto-img-container">
              <?php 
                $imgSrc = !empty($prod['image']) ? base_url('assets/img/' . $prod['image']) : base_url('assets/img/img 2.jpg');
              ?>
              <img src="<?= $imgSrc ?>" alt="<?= esc($prod['name']) ?>" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=600&q=80';" />
              <span class="producto-tag-badge"><?= esc($prod['tag']) ?></span>
              <?php if (!empty($prod['code_int'])): ?>
                <span class="producto-code-badge">Cód. #<?= esc($prod['code_int']) ?></span>
              <?php endif; ?>
            </div>
            
            <div class="producto-card-body">
              <h3><?= esc($prod['name']) ?></h3>
              <?php if (!empty($prod['category'])): ?>
                <small style="display:block; color:var(--dorado); font-size:0.75rem; font-weight:600; text-transform:uppercase; margin-top:-0.3rem; margin-bottom:0.5rem; letter-spacing:0.5px;">
                  <?= esc($prod['category']) ?>
                </small>
              <?php endif; ?>
              <p><?= esc($prod['description']) ?></p>
              
              <div class="producto-price-wrap">
                <?php if ($prod['price'] > 0): ?>
                  <span class="price-val">$ <?= number_format($prod['price'], 0, ',', '.') ?></span>
                  <span class="price-note">por kg / un. aprox.</span>
                <?php else: ?>
                  <span class="price-val" style="font-size: 1.15rem; color: var(--rojo);">Consultar Precio</span>
                  <span class="price-note">a pedido</span>
                <?php endif; ?>
              </div>

              <div class="producto-actions">
                <?php if ($prod['price'] > 0): ?>
                  <button type="button" 
                          class="btn btn-primary btn-add-cart" 
                          onclick="addToCart(<?= $prod['id'] ?>, '<?= esc($prod['name']) ?>', <?= $prod['price'] ?>, '<?= esc($prod['tag']) ?>')">
                    <i class="fas fa-cart-plus"></i> Agregar al Pedido
                  </button>
                <?php endif; ?>

                <?php 
                  $msg = !empty($prod['whatsapp_msg']) ? $prod['whatsapp_msg'] : 'Hola! Quisiera pedir ' . $prod['name'];
                  $waLink = "https://wa.me/5493571523376?text=" . urlencode($msg);
                ?>
                <a href="<?= $waLink ?>" target="_blank" class="btn btn-whatsapp btn-card-wa" style="<?= $prod['price'] <= 0 ? 'width: 100%; justify-content: center;' : '' ?>" title="Pedir directo por WhatsApp">
                  <i class="fab fa-whatsapp"></i> <?= $prod['price'] > 0 ? 'Pedir' : 'Consultar por WhatsApp' ?>
                </a>
              </div>

              <?php if (session()->get('role') === 'admin'): ?>
                <div class="admin-quick-edit">
                  <a href="<?= base_url('admin#productos') ?>">
                    <i class="fas fa-edit"></i> Administrar Producto
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align: center; grid-column: 1 / -1; padding: 2rem;">No hay productos disponibles en este momento.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- NOSOTROS -->
  <section class="nosotros" id="nosotros">
    <div class="nosotros-inner">
      <div class="nosotros-deco">
        <div class="deco-circle"></div>
        <div class="nosotros-img-block">
          <div class="nosotros-img-placeholder">
            <img src="<?= base_url('assets/img/negocio3.jpeg') ?>" alt="La Boutique del Cerdo - Local" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80';" />
          </div>
        </div>
      </div>
      <div class="nosotros-texto">
        <span class="section-tag">Quiénes somos</span>
        <h2>Tradición y sabor<br/><em>en cada corte</em></h2>
        <p>En <strong>La Boutique del Cerdo</strong> nos dedicamos a ofrecer los mejores productos porcinos de Río Tercero y la región. Trabajamos con producción seleccionada y elaboramos embutidos y chacinados propios bajo recetas tradicionales familiares.</p>
        <p>Brindamos atención personalizada para asesorarte en cada preparación: para el asado del domingo, la picada con amigos o eventos familiares. Calidad garantizada en cada kilo.</p>
        <div class="nosotros-datos">
          <div class="dato">
            <strong>+25</strong>
            <span>Años de trayectoria</span>
          </div>
          <div class="dato">
            <strong>100%</strong>
            <span>Cortes frescos</span>
          </div>
          <div class="dato">
            <strong>Artesanal</strong>
            <span>Elaboración propia</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTACTO -->
  <section class="contacto" id="contacto">
    <div class="section-header light">
      <span class="section-tag">Encontranos</span>
      <h2>Contacto <em>&amp; Ubicación</em></h2>
      <p style="color: rgba(255,255,255,.8);">Vení a visitarnos o hacé tu pedido sin moverte de casa.</p>
    </div>
    <div class="contacto-inner">

      <div class="contacto-info">
        <div class="info-card">
          <i class="fas fa-map-marker-alt"></i>
          <div>
            <strong>Dirección</strong>
            <span>Belgrano 243, Río Tercero<br/>Córdoba, Argentina</span>
          </div>
        </div>
        <div class="info-card">
          <i class="fas fa-phone"></i>
          <div>
            <strong>Teléfono Fijo</strong>
            <span><a href="tel:03571410310">03571 – 410310</a></span>
          </div>
        </div>
        <div class="info-card">
          <i class="fab fa-whatsapp"></i>
          <div>
            <strong>WhatsApp Ventas</strong>
            <span><a href="https://wa.me/5493571523376" target="_blank">3571 – 523376</a></span>
          </div>
        </div>
        <div class="info-card">
          <i class="far fa-clock"></i>
          <div>
            <strong>Horarios de Atención</strong>
            <span>Lun – Sáb: 08:00 a 13:00 hs<br/>Lun – Sáb: 16:30 a 20:30 hs</span>
          </div>
        </div>
        <a href="https://www.google.com/search?q=la+boutique+del+cerdo" target="_blank" class="info-card info-card-link">
          <i class="fab fa-google"></i>
          <div>
            <strong>Dejanos tu reseña</strong>
            <span>Compartí tu experiencia en Google</span>
          </div>
        </a>
        <a href="https://www.instagram.com/laboutiquedelcerdo.rio3" target="_blank" class="info-card info-card-link">
          <i class="fab fa-instagram"></i>
          <div>
            <strong>Instagram Oficial</strong>
            <span>@laboutiquedelcerdo.rio3</span>
          </div>
        </a>

        <a href="https://wa.me/5493571523376?text=Hola!%20Quisiera%20hacer%20una%20consulta." target="_blank" class="btn btn-whatsapp btn-lg">
          <i class="fab fa-whatsapp"></i> Abrir Chat Directo de WhatsApp
        </a>
      </div>

      <div class="mapa-wrapper">
        <iframe
          title="Ubicación La Boutique del Cerdo"
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3358.0!2d-64.1160!3d-32.1730!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sBelgrano+243%2C+R%C3%ADo+Tercero%2C+C%C3%B3rdoba!5e0!3m2!1ses!2sar!4v1"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>

    </div>
  </section>

  <!-- CONSULTAS Y COMENTARIOS -->
  <section class="consultas" id="consultas">
    <div class="section-header">
      <span class="section-tag">Tu opinión y pedidos</span>
      <h2>Comentarios <em>&amp; Consultas</em></h2>
      <p>¿Tenés alguna pregunta o querés dejarnos tu opinión? ¡Nos encanta escucharte!</p>
    </div>
    <div class="consultas-inner">

      <!-- FORMULARIO DE CONSULTAS -->
      <div class="consultas-form-wrap">
        <form class="consultas-form" id="consultaForm" onsubmit="enviarConsulta(event)">
          <div class="form-row">
            <div class="form-group">
              <label for="nombre">Nombre y Apellido *</label>
              <input type="text" id="nombre" value="<?= esc(session()->get('name') ?? '') ?>" placeholder="Tu nombre" required />
            </div>
            <div class="form-group">
              <label for="contacto-form">Teléfono o Correo (opcional)</label>
              <input type="text" id="contacto-form" value="<?= esc(session()->get('email') ?? '') ?>" placeholder="Para poder responderte" />
            </div>
          </div>
          <div class="form-group">
            <label for="mensaje">Tu consulta o mensaje *</label>
            <textarea id="mensaje" rows="4" placeholder="¿En qué corte o producto estás interesado?" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary btn-consulta">
            <i class="fas fa-paper-plane"></i> Enviar Consulta
          </button>
          <p class="form-note"><i class="fab fa-whatsapp"></i> Tu consulta quedará registrada y se abrirá WhatsApp para chatear en directo.</p>
        </form>
      </div>

      <!-- LISTA DE COMENTARIOS Y DEJAR COMENTARIO -->
      <div class="consultas-comments">
        <div class="comments-header-flex">
          <h3 class="comments-title">Lo que dicen nuestros clientes</h3>
          <span class="stars-avg-badge">
            <i class="fas fa-star"></i> <?= $avgStars ?? '5.0' ?> / 5.0
          </span>
        </div>

        <div class="comments-list" id="commentsList">
          <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $c): ?>
              <div class="comment-card">
                <div class="comment-header">
                  <div class="comment-avatar"><?= esc(strtoupper(substr($c['name'], 0, 1))) ?></div>
                  <div>
                    <strong><?= esc($c['name']) ?></strong>
                    <span><?= esc($c['subtitle'] ?? 'Cliente') ?></span>
                  </div>
                  <div class="comment-stars">
                    <?= str_repeat('★', (int) $c['stars']) . str_repeat('☆', 5 - (int) $c['stars']) ?>
                  </div>
                </div>
                <p>"<?= esc($c['comment']) ?>"</p>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p style="text-align: center; color: var(--gris-med); padding: 1rem;">Sé el primero en dejarnos tu comentario.</p>
          <?php endif; ?>
        </div>

        <!-- FORMULARIO DE COMENTARIO -->
        <div class="leave-comment">
          <h4>Dejá tu comentario o reseña</h4>
          <p style="font-size: 0.85rem; color: var(--gris-med); margin-bottom: 0.5rem;">Elegí tu puntuación y dejanos tu experiencia:</p>
          
          <div class="star-rating" id="starRating">
            <span data-val="1">★</span>
            <span data-val="2">★</span>
            <span data-val="3">★</span>
            <span data-val="4">★</span>
            <span data-val="5">★</span>
          </div>

          <input type="text" id="commentName" value="<?= esc(session()->get('name') ?? '') ?>" placeholder="Tu nombre y apellido *" required />
          <textarea id="commentText" rows="3" placeholder="Escribí tu comentario sobre nuestros cortes o atención..." required></textarea>
          
          <button type="button" id="btnPublicarComentario" class="btn btn-primary" onclick="publicarComentario()">
            <i class="fas fa-comment"></i> Publicar Comentario
          </button>
        </div>
      </div>

    </div>
  </section>

  <!-- SCRIPT PARA FILTRO Y BÚSQUEDA DE PRODUCTOS -->
  <script>
    let currentCategory = 'todos';

    function setCategoryFilter(cat) {
      currentCategory = cat.toLowerCase();
      const buttons = document.querySelectorAll('.filter-btn');
      buttons.forEach(btn => {
        if (btn.dataset.filter === cat) {
          btn.classList.add('active');
        } else {
          btn.classList.remove('active');
        }
      });
      filterAndSearchProducts();
    }

    function filterAndSearchProducts() {
      const searchInput = document.getElementById('productSearchInput');
      const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
      const cards = document.querySelectorAll('.producto-card');

      cards.forEach(card => {
        const cardCat = (card.dataset.category || '').toLowerCase();
        const cardName = (card.dataset.name || '').toLowerCase();
        const cardDesc = (card.dataset.desc || '').toLowerCase();
        const cardCode = (card.dataset.code || '').toLowerCase();

        const matchesCat = (currentCategory === 'todos' || cardCat.includes(currentCategory));
        const matchesQuery = query === '' || 
                             cardName.includes(query) || 
                             cardDesc.includes(query) || 
                             cardCode.includes(query);

        if (matchesCat && matchesQuery) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    }

    // Compatibilidad por si se llama filterProducts
    function filterProducts(cat) {
      setCategoryFilter(cat);
    }
  </script>

<?= view('templates/footer') ?>
