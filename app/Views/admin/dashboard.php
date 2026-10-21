<?= view('templates/header') ?>

<section class="admin-section">
  <div class="admin-container">
    
    <!-- ADMIN HEADER -->
    <div class="admin-header-bar">
      <div>
        <span class="section-tag"><i class="fas fa-shield-alt"></i> Panel de Control</span>
        <h1 class="admin-title">Administración <em>La Boutique</em></h1>
        <p class="admin-subtitle">Gestioná tus productos, pedidos de clientes, reseñas y consultas desde un solo lugar.</p>
      </div>
      <div class="admin-header-actions">
        <a href="<?= base_url('/') ?>" class="btn btn-outline-light">
          <i class="fas fa-store"></i> Ver Tienda
        </a>
        <button type="button" class="btn btn-primary" onclick="openProductModal()">
          <i class="fas fa-plus-circle"></i> Nuevo Producto
        </button>
      </div>
    </div>

    <!-- STATS CARDS -->
    <div class="admin-stats-grid">
      <div class="stat-card">
        <div class="stat-icon icon-products"><i class="fas fa-drumstick-bite"></i></div>
        <div class="stat-info">
          <span class="stat-number"><?= count($products) ?></span>
          <span class="stat-label">Productos en Catálogo</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon icon-orders"><i class="fas fa-shopping-basket"></i></div>
        <div class="stat-info">
          <span class="stat-number"><?= count($orders) ?></span>
          <span class="stat-label">Pedidos Recibidos</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon icon-comments"><i class="fas fa-star"></i></div>
        <div class="stat-info">
          <span class="stat-number"><?= count($comments) ?></span>
          <span class="stat-label">Reseñas de Clientes</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon icon-inquiries"><i class="fas fa-envelope-open-text"></i></div>
        <div class="stat-info">
          <span class="stat-number"><?= count($inquiries) ?></span>
          <span class="stat-label">Consultas Recibidas</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon icon-users"><i class="fas fa-users"></i></div>
        <div class="stat-info">
          <span class="stat-number"><?= count($users) ?></span>
          <span class="stat-label">Usuarios Registrados</span>
        </div>
      </div>
    </div>

    <!-- NAVIGATION TABS -->
    <div class="admin-tabs-nav">
      <button type="button" class="admin-tab-btn active" onclick="switchAdminTab('productos')">
        <i class="fas fa-drumstick-bite"></i> Productos (<?= count($products) ?>)
      </button>
      <button type="button" class="admin-tab-btn" onclick="switchAdminTab('pedidos')">
        <i class="fas fa-shopping-cart"></i> Pedidos (<?= count($orders) ?>)
      </button>
      <button type="button" class="admin-tab-btn" onclick="switchAdminTab('comentarios')">
        <i class="fas fa-comments"></i> Reseñas (<?= count($comments) ?>)
      </button>
      <button type="button" class="admin-tab-btn" onclick="switchAdminTab('consultas')">
        <i class="fas fa-question-circle"></i> Consultas (<?= count($inquiries) ?>)
      </button>
      <button type="button" class="admin-tab-btn" onclick="switchAdminTab('usuarios')">
        <i class="fas fa-user-cog"></i> Usuarios (<?= count($users) ?>)
      </button>
    </div>

    <!-- TAB 1: PRODUCTOS -->
    <div class="admin-tab-content active" id="tab-productos">
      <div class="admin-card">
        <div class="admin-card-header">
          <h3><i class="fas fa-drumstick-bite"></i> Gestión de Productos</h3>
          <button type="button" class="btn btn-primary btn-sm" onclick="openProductModal()">
            <i class="fas fa-plus"></i> Agregar Producto
          </button>
        </div>
        <div class="admin-table-responsive">
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Cód.</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Categoría / Tag</th>
                <th>Precio aprox.</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($products)): ?>
                <?php foreach ($products as $p): ?>
                  <tr>
                    <td>#<?= $p['id'] ?></td>
                    <td><strong><?= esc($p['code_int'] ?? '-') ?></strong></td>
                    <td>
                      <img src="<?= base_url('assets/img/' . $p['image']) ?>" 
                           alt="<?= esc($p['name']) ?>" 
                           class="admin-thumb" 
                           onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=100&q=80';" />
                    </td>
                    <td>
                      <strong><?= esc($p['name']) ?></strong>
                      <?php if (!empty($p['category'])): ?>
                        <br/><small style="color:var(--gris-med);"><?= esc($p['category']) ?></small>
                      <?php endif; ?>
                      <p class="admin-desc-snippet"><?= esc($p['description']) ?></p>
                    </td>
                    <td><span class="producto-tag"><?= esc($p['tag']) ?></span></td>
                    <td><strong>$ <?= number_format($p['price'], 0, ',', '.') ?></strong></td>
                    <td>
                      <?php if ($p['active']): ?>
                        <span class="badge badge-success"><i class="fas fa-check"></i> Activo</span>
                      <?php else: ?>
                        <span class="badge badge-danger"><i class="fas fa-pause"></i> Pausado</span>
                      <?php endif; ?>
                    </td>
                    <td class="admin-actions-cell">
                      <button type="button" class="btn-icon btn-edit" title="Editar" 
                              onclick='editProduct(<?= json_encode($p, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                        <i class="fas fa-edit"></i>
                      </button>
                      <a href="<?= base_url('admin/productos/toggle/' . $p['id']) ?>" 
                         class="btn-icon btn-toggle" 
                         title="<?= $p['active'] ? 'Pausar' : 'Activar' ?>">
                        <i class="fas <?= $p['active'] ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
                      </a>
                      <a href="<?= base_url('admin/productos/eliminar/' . $p['id']) ?>" 
                         class="btn-icon btn-delete" 
                         title="Eliminar" 
                         onclick="return confirm('¿Seguro que deseas eliminar este producto?')">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="7" class="text-center">No hay productos registrados.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- TAB 2: PEDIDOS -->
    <div class="admin-tab-content" id="tab-pedidos">
      <div class="admin-card">
        <div class="admin-card-header">
          <h3><i class="fas fa-shopping-basket"></i> Pedidos Recibidos</h3>
        </div>
        <div class="admin-table-responsive">
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Contacto</th>
                <th>Dirección</th>
                <th>Detalle del Pedido</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $o): ?>
                  <tr>
                    <td>#<?= $o['id'] ?></td>
                    <td><small><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></small></td>
                    <td>
                      <strong><?= esc($o['customer_name']) ?></strong>
                      <?php if (!empty($o['user_id'])): ?>
                        <br/><span style="font-size:0.75rem; background: #e8f4fd; color: #1e88e5; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-top: 3px;">
                          <i class="fas fa-user-check"></i> Usuario #<?= $o['user_id'] ?> (<?= esc($o['user_account_name'] ?? 'Registrado') ?>)
                        </span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if (!empty($o['customer_phone'])): ?>
                        <a href="https://wa.me/<?= preg_replace('/\D/', '', $o['customer_phone']) ?>" target="_blank" class="admin-wa-link">
                          <i class="fab fa-whatsapp"></i> <?= esc($o['customer_phone']) ?>
                        </a>
                      <?php else: ?>-<?php endif; ?>
                    </td>
                    <td><?= esc($o['customer_address'] ?? 'Retiro en local') ?></td>
                    <td>
                      <div class="admin-order-summary">
                        <pre><?= esc($o['items_summary']) ?></pre>
                        <?php if (!empty($o['notes'])): ?>
                          <p class="order-notes-tag"><i class="fas fa-sticky-note"></i> <?= esc($o['notes']) ?></p>
                        <?php endif; ?>
                      </div>
                    </td>
                    <td><strong>$ <?= number_format($o['total'], 0, ',', '.') ?></strong></td>
                    <td>
                      <form action="<?= base_url('admin/pedidos/estado/' . $o['id']) ?>" method="post" class="status-form">
                        <?= csrf_field() ?>
                        <select name="status" onchange="this.form.submit()" class="status-select status-<?= esc($o['status']) ?>">
                          <option value="pending" <?= $o['status'] === 'pending' ? 'selected' : '' ?>>Pendiente</option>
                          <option value="confirmed" <?= $o['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmado</option>
                          <option value="delivered" <?= $o['status'] === 'delivered' ? 'selected' : '' ?>>Entregado</option>
                          <option value="cancelled" <?= $o['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelado</option>
                        </select>
                      </form>
                    </td>
                    <td class="admin-actions-cell">
                      <?php if (!empty($o['customer_phone'])): ?>
                        <a href="https://wa.me/<?= preg_replace('/\D/', '', $o['customer_phone']) ?>?text=Hola%20<?= urlencode($o['customer_name']) ?>!%20Te%20escribimos%20de%20La%20Boutique%20del%20Cerdo%20sobre%20tu%20pedido%20%23<?= $o['id'] ?>." 
                           target="_blank" class="btn-icon btn-wa" title="Escribir por WhatsApp">
                          <i class="fab fa-whatsapp"></i>
                        </a>
                      <?php endif; ?>
                      <a href="<?= base_url('admin/pedidos/eliminar/' . $o['id']) ?>" 
                         class="btn-icon btn-delete" 
                         title="Eliminar" 
                         onclick="return confirm('¿Eliminar este pedido?')">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="9" class="text-center">No hay pedidos registrados aún.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- TAB 3: COMENTARIOS -->
    <div class="admin-tab-content" id="tab-comentarios">
      <div class="admin-card">
        <div class="admin-card-header">
          <h3><i class="fas fa-star"></i> Comentarios y Reseñas</h3>
        </div>
        <div class="admin-table-responsive">
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Estrellas</th>
                <th>Comentario</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $cm): ?>
                  <tr>
                    <td>#<?= $cm['id'] ?></td>
                    <td><small><?= date('d/m/Y', strtotime($cm['created_at'])) ?></small></td>
                    <td>
                      <strong><?= esc($cm['name']) ?></strong>
                      <span class="badge badge-light"><?= esc($cm['subtitle'] ?? 'Cliente') ?></span>
                      <?php if (!empty($cm['user_id'])): ?>
                        <br/><span style="font-size:0.72rem; background: #e8f4fd; color: #1e88e5; padding: 1px 5px; border-radius: 4px; display: inline-block; margin-top: 2px;">
                          <i class="fas fa-check-circle"></i> Cuenta #<?= $cm['user_id'] ?>
                        </span>
                      <?php endif; ?>
                    </td>
                    <td><span class="stars-gold"><?= str_repeat('★', (int) $cm['stars']) ?></span></td>
                    <td><p class="admin-desc-snippet">"<?= esc($cm['comment']) ?>"</p></td>
                    <td>
                      <?php if ($cm['status'] === 'approved'): ?>
                        <span class="badge badge-success">Visible</span>
                      <?php else: ?>
                        <span class="badge badge-danger">Oculto</span>
                      <?php endif; ?>
                    </td>
                    <td class="admin-actions-cell">
                      <a href="<?= base_url('admin/comentarios/toggle/' . $cm['id']) ?>" 
                         class="btn-icon btn-toggle" 
                         title="<?= $cm['status'] === 'approved' ? 'Ocultar' : 'Hacer Visible' ?>">
                        <i class="fas <?= $cm['status'] === 'approved' ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
                      </a>
                      <a href="<?= base_url('admin/comentarios/eliminar/' . $cm['id']) ?>" 
                         class="btn-icon btn-delete" 
                         title="Eliminar" 
                         onclick="return confirm('¿Seguro que deseas eliminar este comentario?')">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="7" class="text-center">No hay comentarios registrados.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- TAB 4: CONSULTAS -->
    <div class="admin-tab-content" id="tab-consultas">
      <div class="admin-card">
        <div class="admin-card-header">
          <h3><i class="fas fa-envelope-open-text"></i> Mensajes y Consultas de Contacto</h3>
        </div>
        <div class="admin-table-responsive">
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Contacto</th>
                <th>Mensaje</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($inquiries)): ?>
                <?php foreach ($inquiries as $inq): ?>
                  <tr>
                    <td>#<?= $inq['id'] ?></td>
                    <td><small><?= date('d/m/Y H:i', strtotime($inq['created_at'])) ?></small></td>
                    <td>
                      <strong><?= esc($inq['name']) ?></strong>
                      <?php if (!empty($inq['user_id'])): ?>
                        <br/><span style="font-size:0.72rem; background: #e8f4fd; color: #1e88e5; padding: 1px 5px; border-radius: 4px; display: inline-block; margin-top: 2px;">
                          <i class="fas fa-user-check"></i> Usuario #<?= $inq['user_id'] ?>
                        </span>
                      <?php endif; ?>
                    </td>
                    <td><?= esc($inq['contact'] ?: 'No especificado') ?></td>
                    <td><p class="admin-desc-snippet"><?= esc($inq['message']) ?></p></td>
                    <td>
                      <?php if ($inq['status'] === 'answered'): ?>
                        <span class="badge badge-success"><i class="fas fa-check"></i> Respondido</span>
                      <?php else: ?>
                        <span class="badge badge-warning"><i class="fas fa-clock"></i> Pendiente</span>
                      <?php endif; ?>
                    </td>
                    <td class="admin-actions-cell">
                      <a href="<?= base_url('admin/consultas/marcar/' . $inq['id']) ?>" 
                         class="btn-icon btn-toggle" 
                         title="Alternar estado">
                        <i class="fas fa-check-circle"></i>
                      </a>
                      <a href="<?= base_url('admin/consultas/eliminar/' . $inq['id']) ?>" 
                         class="btn-icon btn-delete" 
                         title="Eliminar" 
                         onclick="return confirm('¿Eliminar esta consulta?')">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="7" class="text-center">No hay consultas recibidas aún.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- TAB 5: USUARIOS -->
    <div class="admin-tab-content" id="tab-usuarios">
      <div class="admin-card">
        <div class="admin-card-header">
          <h3><i class="fas fa-users-cog"></i> Usuarios Registrados</h3>
        </div>
        <div class="admin-table-responsive">
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Correo Electrónico</th>
                <th>Rol Actual</th>
                <th>Fecha de Registro</th>
                <th>Cambiar Rol</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($users)): ?>
                <?php foreach ($users as $u): ?>
                  <tr>
                    <td>#<?= $u['id'] ?></td>
                    <td><strong><?= esc($u['name']) ?></strong></td>
                    <td><?= esc($u['email']) ?></td>
                    <td>
                      <?php if ($u['role'] === 'admin'): ?>
                        <span class="badge badge-gold"><i class="fas fa-shield-alt"></i> Administrador</span>
                      <?php else: ?>
                        <span class="badge badge-light"><i class="fas fa-user"></i> Cliente</span>
                      <?php endif; ?>
                    </td>
                    <td><small><?= date('d/m/Y', strtotime($u['created_at'])) ?></small></td>
                    <td>
                      <form action="<?= base_url('admin/usuarios/cambiar-rol/' . $u['id']) ?>" method="post" class="status-form">
                        <?= csrf_field() ?>
                        <select name="role" onchange="this.form.submit()" class="status-select" <?= $u['id'] == session()->get('id') ? 'disabled title="No podés cambiar tu propio rol"' : '' ?>>
                          <option value="client" <?= $u['role'] === 'client' ? 'selected' : '' ?>>Cliente</option>
                          <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                        </select>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- MODAL PARA CREAR / EDITAR PRODUCTO -->
<div class="cart-modal-overlay" id="productModalOverlay" onclick="if(event.target === this) closeProductModal()">
  <div class="cart-modal product-modal">
    <div class="cart-modal-header">
      <div class="cart-title-wrap">
        <i class="fas fa-drumstick-bite"></i>
        <h3 id="productModalTitle">Nuevo Producto</h3>
      </div>
      <button type="button" class="cart-close-btn" onclick="closeProductModal()">&times;</button>
    </div>

    <form id="productForm" method="post" action="<?= base_url('admin/productos/crear') ?>" class="admin-modal-form">
      <?= csrf_field() ?>
      <input type="hidden" id="productId" name="id" value="" />

      <div class="form-row">
        <div class="form-group" style="max-width: 140px;">
          <label for="prodCodeInt">Cód. Interno</label>
          <input type="number" id="prodCodeInt" name="code_int" placeholder="Ej: 1" />
        </div>
        <div class="form-group">
          <label for="prodName">Nombre del Producto *</label>
          <input type="text" id="prodName" name="name" required placeholder="Ej: Bondiola" />
        </div>
        <div class="form-group">
          <label for="prodPrice">Precio ($ ARS) *</label>
          <input type="number" step="0.01" id="prodPrice" name="price" required placeholder="Ej: 11500" />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="prodCategory">Categoría / Sección</label>
          <input type="text" id="prodCategory" name="category" placeholder="Ej: Carnicería - Cortes" />
        </div>
        <div class="form-group">
          <label for="prodTag">Etiqueta / Tag *</label>
          <select id="prodTag" name="tag" required class="admin-select">
            <option value="Cortes">Cortes</option>
            <option value="Embutidos">Embutidos</option>
            <option value="Fiambres">Fiambres</option>
            <option value="Preparados">Preparados</option>
            <option value="Despensa">Despensa</option>
            <option value="Pastas">Pastas</option>
            <option value="Parrilla">Parrilla</option>
            <option value="Condimentos">Condimentos</option>
            <option value="Fresco">Fresco</option>
            <option value="Artesanal">Artesanal</option>
          </select>
        </div>
        <div class="form-group">
          <label for="prodImage">Nombre de Imagen</label>
          <input type="text" id="prodImage" name="image" placeholder="Ej: img 2.jpg o URL" />
        </div>
      </div>

      <div class="form-group">
        <label for="prodDesc">Descripción *</label>
        <textarea id="prodDesc" name="description" rows="3" placeholder="Detalle del corte, procedencia, o uso sugerido..." required></textarea>
      </div>

      <div class="form-group">
        <label for="prodWhatsapp">Mensaje predeterminado de WhatsApp</label>
        <input type="text" id="prodWhatsapp" name="whatsapp_msg" placeholder="Ej: Hola! Quisiera pedir costillas especiales." />
      </div>

      <div class="form-group checkbox-group">
        <label>
          <input type="checkbox" id="prodActive" name="active" value="1" checked />
          Producto activo (visible en la tienda pública)
        </label>
      </div>

      <div class="cart-actions">
        <button type="button" class="btn btn-outline-danger" onclick="closeProductModal()">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="btnSaveProduct">
          <i class="fas fa-save"></i> Guardar Producto
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function switchAdminTab(tabName) {
    document.querySelectorAll('.admin-tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.admin-tab-content').forEach(c => c.classList.remove('active'));

    event.currentTarget.classList.add('active');
    const target = document.getElementById('tab-' + tabName);
    if (target) target.classList.add('active');

    window.location.hash = tabName;
  }

  // Activar tab por hash si existe
  window.addEventListener('DOMContentLoaded', () => {
    const hash = window.location.hash.replace('#', '');
    if (hash) {
      const tabBtn = document.querySelector(`button[onclick="switchAdminTab('${hash}')"]`);
      if (tabBtn) tabBtn.click();
    }
  });

  function openProductModal() {
    document.getElementById('productModalTitle').textContent = 'Nuevo Producto';
    document.getElementById('productForm').action = '<?= base_url('admin/productos/crear') ?>';
    document.getElementById('productForm').reset();
    document.getElementById('productId').value = '';
    document.getElementById('prodCodeInt').value = '';
    document.getElementById('prodCategory').value = '';
    document.getElementById('prodActive').checked = true;

    const overlay = document.getElementById('productModalOverlay');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function editProduct(p) {
    document.getElementById('productModalTitle').textContent = 'Editar Producto #' + p.id;
    document.getElementById('productForm').action = '<?= base_url('admin/productos/editar/') ?>' + p.id;
    document.getElementById('productId').value = p.id;
    document.getElementById('prodCodeInt').value = p.code_int || '';
    document.getElementById('prodName').value = p.name;
    document.getElementById('prodCategory').value = p.category || '';
    document.getElementById('prodPrice').value = p.price;
    document.getElementById('prodTag').value = p.tag;
    document.getElementById('prodImage').value = p.image || '';
    document.getElementById('prodDesc').value = p.description || '';
    document.getElementById('prodWhatsapp').value = p.whatsapp_msg || '';
    document.getElementById('prodActive').checked = p.active == 1;

    const overlay = document.getElementById('productModalOverlay');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeProductModal() {
    const overlay = document.getElementById('productModalOverlay');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }
</script>

<?= view('templates/footer') ?>
