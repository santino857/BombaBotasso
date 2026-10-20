<?= view('templates/header') ?>

<section class="client-portal-section" style="padding: 120px 20px 80px; min-height: 80vh; background: var(--crema);">
  <div style="max-width: 1100px; margin: 0 auto;">
    
    <!-- HEADER DEL PORTAL DE CLIENTE -->
    <div style="background: linear-gradient(135deg, var(--marron) 0%, var(--negro) 100%); color: var(--blanco); border-radius: var(--radio); padding: 2.5rem; margin-bottom: 2rem; box-shadow: var(--sombra); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
      <div>
        <span style="display: inline-block; background: rgba(200,149,44,.25); color: var(--dorado-cl); padding: 0.3rem 0.85rem; border-radius: 50px; font-size: 0.85rem; font-weight: 700; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 1px;">
          <i class="fas fa-user-check"></i> Espacio de Cliente
        </span>
        <h1 style="font-family: var(--font-display); font-size: 2.3rem; margin: 0 0 0.5rem; color: var(--blanco);">
          Hola, <?= esc($userName) ?>
        </h1>
        <p style="color: var(--gris-cl); font-size: 1rem; margin: 0;">
          <i class="fas fa-envelope" style="opacity: 0.7; margin-right: 0.3rem;"></i> <?= esc($userEmail) ?> · Seguí el estado de tus compras y consultas en <strong>La Boutique del Cerdo</strong>.
        </p>
      </div>

      <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="<?= base_url('/#productos') ?>" class="btn btn-primary" style="box-shadow: 0 4px 15px rgba(192,57,43,.4);">
          <i class="fas fa-drumstick-bite"></i> Ver Catálogo
        </a>
        <a href="https://wa.me/5493571523376?text=<?= urlencode('Hola! Soy ' . $userName . ' y tengo una consulta sobre mis pedidos.') ?>" target="_blank" class="btn btn-whatsapp">
          <i class="fab fa-whatsapp"></i> Chat de Atención
        </a>
      </div>
    </div>

    <!-- PESTAÑAS DE NAVEGACIÓN CLIENTE -->
    <div style="display: flex; gap: 0.75rem; margin-bottom: 1.5rem; border-bottom: 2px solid var(--gris-cl); padding-bottom: 0.5rem; overflow-x: auto;">
      <button type="button" class="client-tab-btn active" onclick="switchClientTab('pedidos')" id="tab-btn-pedidos" style="background: none; border: none; padding: 0.75rem 1.5rem; font-family: var(--font-body); font-weight: 700; font-size: 1.05rem; cursor: pointer; color: var(--rojo); border-bottom: 3px solid var(--rojo); display: flex; align-items: center; gap: 0.5rem;">
        <i class="fas fa-receipt"></i> Mis Pedidos (<?= count($orders) ?>)
      </button>
      <button type="button" class="client-tab-btn" onclick="switchClientTab('consultas')" id="tab-btn-consultas" style="background: none; border: none; padding: 0.75rem 1.5rem; font-family: var(--font-body); font-weight: 700; font-size: 1.05rem; cursor: pointer; color: var(--gris-med); border-bottom: 3px solid transparent; display: flex; align-items: center; gap: 0.5rem;">
        <i class="fas fa-comments"></i> Mis Consultas (<?= count($myInquiries) ?>)
      </button>
      <button type="button" class="client-tab-btn" onclick="switchClientTab('resenas')" id="tab-btn-resenas" style="background: none; border: none; padding: 0.75rem 1.5rem; font-family: var(--font-body); font-weight: 700; font-size: 1.05rem; cursor: pointer; color: var(--gris-med); border-bottom: 3px solid transparent; display: flex; align-items: center; gap: 0.5rem;">
        <i class="fas fa-star"></i> Mis Reseñas (<?= count($myComments) ?>)
      </button>
    </div>

    <!-- TAB 1: MIS PEDIDOS -->
    <div class="client-tab-content" id="client-tab-pedidos">
      <?php if (!empty($orders)): ?>
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
          <?php foreach ($orders as $order): ?>
            <article style="background: var(--blanco); border-radius: var(--radio); border: 1px solid var(--gris-cl); box-shadow: var(--sombra-card); overflow: hidden; transition: var(--trans);">
              
              <!-- ORDER HEADER -->
              <div style="background: #faf6f0; border-bottom: 1px solid var(--gris-cl); padding: 1.25rem 1.75rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                  <span style="font-size: 0.85rem; color: var(--gris-med); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Pedido #<?= esc($order['id']) ?></span>
                  <div style="font-size: 1.15rem; font-weight: 700; color: var(--marron);">
                    <i class="far fa-calendar-alt"></i> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?> hs
                  </div>
                </div>

                <div style="display: flex; align-items: center; gap: 1rem;">
                  <?php 
                    $statusConfig = [
                      'pending'   => ['label' => 'Pendiente de confirmación', 'color' => '#d35400', 'bg' => '#fdebd0', 'icon' => 'fa-clock'],
                      'confirmed' => ['label' => 'Confirmado y en preparación', 'color' => '#2980b9', 'bg' => '#d4e6f1', 'icon' => 'fa-check-circle'],
                      'delivered' => ['label' => 'Entregado / Retirado', 'color' => '#27ae60', 'bg' => '#d5f5e3', 'icon' => 'fa-box-open'],
                      'cancelled' => ['label' => 'Cancelado', 'color' => '#c0392b', 'bg' => '#fadbd8', 'icon' => 'fa-times-circle'],
                    ];
                    $st = $statusConfig[$order['status']] ?? ['label' => ucfirst($order['status']), 'color' => '#555', 'bg' => '#eee', 'icon' => 'fa-info-circle'];
                  ?>
                  <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 1rem; border-radius: 50px; font-weight: 700; font-size: 0.85rem; background: <?= $st['bg'] ?>; color: <?= $st['color'] ?>;">
                    <i class="fas <?= $st['icon'] ?>"></i> <?= $st['label'] ?>
                  </span>

                  <span style="font-size: 1.35rem; font-weight: 800; color: var(--rojo);">
                    $ <?= number_format($order['total'], 0, ',', '.') ?>
                  </span>
                </div>
              </div>

              <!-- ORDER BODY -->
              <div style="padding: 1.75rem;">
                
                <!-- LISTA DE PRODUCTOS DEL PEDIDO -->
                <div style="margin-bottom: 1.25rem;">
                  <h4 style="font-family: var(--font-display); font-size: 1.1rem; color: var(--marron); margin-bottom: 0.75rem;">
                    <i class="fas fa-drumstick-bite" style="color: var(--rojo); margin-right: 0.3rem;"></i> Cortes y Productos incluidos:
                  </h4>
                  
                  <?php if (!empty($order['items'])): ?>
                    <div style="background: #faf8f5; border-radius: 8px; padding: 1rem; border: 1px solid #eee;">
                      <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem;">
                        <thead>
                          <tr style="text-align: left; border-bottom: 1px solid #ddd; color: var(--gris-med); font-size: 0.85rem;">
                            <th style="padding: 0.4rem 0.5rem;">Producto</th>
                            <th style="padding: 0.4rem 0.5rem; text-align: center;">Cantidad</th>
                            <th style="padding: 0.4rem 0.5rem; text-align: right;">Precio Unit.</th>
                            <th style="padding: 0.4rem 0.5rem; text-align: right;">Subtotal</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($order['items'] as $item): ?>
                            <tr style="border-bottom: 1px dashed #e8ddd0;">
                              <td style="padding: 0.6rem 0.5rem; font-weight: 600; color: var(--negro);">
                                <?= esc($item['product_name'] ?? 'Producto #' . $item['product_id']) ?>
                                <?php if (!empty($item['tag'])): ?>
                                  <span style="font-size: 0.75rem; background: var(--rojo-suave); color: var(--rojo-osc); padding: 0.15rem 0.5rem; border-radius: 4px; margin-left: 0.4rem;"><?= esc($item['tag']) ?></span>
                                <?php endif; ?>
                              </td>
                              <td style="padding: 0.6rem 0.5rem; text-align: center;"><?= (int) $item['quantity'] ?></td>
                              <td style="padding: 0.6rem 0.5rem; text-align: right; color: var(--gris-med);">$ <?= number_format($item['unit_price'], 0, ',', '.') ?></td>
                              <td style="padding: 0.6rem 0.5rem; text-align: right; font-weight: 700; color: var(--marron);">$ <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  <?php else: ?>
                    <div style="background: #faf8f5; border-radius: 8px; padding: 1rem; font-family: monospace; font-size: 0.9rem; white-space: pre-line; color: var(--gris-osc); border: 1px solid #eee;">
                      <?= esc($order['items_summary']) ?>
                    </div>
                  <?php endif; ?>
                </div>

                <!-- INFO DE ENTREGA Y NOTAS -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1rem; background: #fffcf8; border-radius: 8px; padding: 1rem; border: 1px solid var(--gris-cl);">
                  <div>
                    <strong style="font-size: 0.85rem; color: var(--gris-med); text-transform: uppercase;"><i class="fas fa-map-marker-alt" style="color: var(--rojo);"></i> Lugar de entrega / retiro:</strong>
                    <p style="margin: 0.25rem 0 0; color: var(--gris-osc); font-size: 0.95rem;">
                      <?= !empty($order['customer_address']) ? esc($order['customer_address']) : 'Retiro por mostrador en Belgrano 243' ?>
                    </p>
                  </div>
                  <div>
                    <strong style="font-size: 0.85rem; color: var(--gris-med); text-transform: uppercase;"><i class="fas fa-phone" style="color: var(--rojo);"></i> Teléfono de contacto:</strong>
                    <p style="margin: 0.25rem 0 0; color: var(--gris-osc); font-size: 0.95rem;">
                      <?= !empty($order['customer_phone']) ? esc($order['customer_phone']) : 'No especificado' ?>
                    </p>
                  </div>
                  <?php if (!empty($order['notes'])): ?>
                    <div style="grid-column: 1 / -1;">
                      <strong style="font-size: 0.85rem; color: var(--gris-med); text-transform: uppercase;"><i class="fas fa-sticky-note" style="color: var(--dorado);"></i> Notas del cliente:</strong>
                      <p style="margin: 0.25rem 0 0; color: var(--gris-osc); font-size: 0.95rem; font-style: italic;">
                        "<?= esc($order['notes']) ?>"
                      </p>
                    </div>
                  <?php endif; ?>
                </div>

                <!-- ACTIONS FOOTER -->
                <div style="margin-top: 1.25rem; display: flex; justify-content: flex-end; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                  <?php 
                    $waCheckMsg = "Hola! Quisiera consultar por el estado de mi Pedido #{$order['id']} a nombre de {$order['customer_name']}.";
                    $waLink = "https://wa.me/5493571523376?text=" . urlencode($waCheckMsg);
                  ?>
                  <a href="<?= $waLink ?>" target="_blank" class="btn btn-whatsapp btn-sm" style="font-size: 0.85rem; padding: 0.5rem 1.2rem;">
                    <i class="fab fa-whatsapp"></i> Consultar estado por WhatsApp
                  </a>
                </div>

              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div style="background: var(--blanco); border-radius: var(--radio); padding: 4rem 2rem; text-align: center; box-shadow: var(--sombra-card); border: 1px solid var(--gris-cl);">
          <i class="fas fa-shopping-basket" style="font-size: 4rem; color: var(--gris-cl); margin-bottom: 1.5rem; display: block;"></i>
          <h3 style="font-family: var(--font-display); font-size: 1.7rem; color: var(--marron); margin-bottom: 0.5rem;">Aún no realizaste ningún pedido</h3>
          <p style="color: var(--gris-med); max-width: 500px; margin: 0 auto 1.5rem;">Armá tu carrito con nuestros cortes de cerdo frescos, embutidos caseros o selecciones para la parrilla.</p>
          <a href="<?= base_url('/#productos') ?>" class="btn btn-primary">
            <i class="fas fa-drumstick-bite"></i> Explorar Cortes y Productos
          </a>
        </div>
      <?php endif; ?>
    </div>

    <!-- TAB 2: MIS CONSULTAS -->
    <div class="client-tab-content" id="client-tab-consultas" style="display: none;">
      <?php if (!empty($myInquiries)): ?>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
          <?php foreach ($myInquiries as $inq): ?>
            <div style="background: var(--blanco); border-radius: var(--radio); padding: 1.5rem; border: 1px solid var(--gris-cl); box-shadow: var(--sombra-card);">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; flex-wrap: wrap; gap: 0.5rem;">
                <span style="font-size: 0.85rem; color: var(--gris-med);">
                  <i class="far fa-clock"></i> <?= date('d/m/Y H:i', strtotime($inq['created_at'])) ?> hs
                </span>
                <?php if ($inq['status'] === 'answered'): ?>
                  <span style="background: #d5f5e3; color: #27ae60; padding: 0.25rem 0.75rem; border-radius: 50px; font-weight: 700; font-size: 0.8rem;">
                    <i class="fas fa-check-circle"></i> Respondida
                  </span>
                <?php else: ?>
                  <span style="background: #fdebd0; color: #d35400; padding: 0.25rem 0.75rem; border-radius: 50px; font-weight: 700; font-size: 0.8rem;">
                    <i class="fas fa-hourglass-half"></i> En espera de respuesta
                  </span>
                <?php endif; ?>
              </div>
              <p style="margin: 0; font-size: 1rem; color: var(--gris-osc); line-height: 1.6;">
                <?= nl2br(esc($inq['message'])) ?>
              </p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div style="background: var(--blanco); border-radius: var(--radio); padding: 3rem 2rem; text-align: center; box-shadow: var(--sombra-card); border: 1px solid var(--gris-cl);">
          <i class="fas fa-envelope-open" style="font-size: 3rem; color: var(--gris-cl); margin-bottom: 1rem; display: block;"></i>
          <p style="color: var(--gris-med); margin-bottom: 1rem;">No tenés consultas registradas todavía.</p>
          <a href="<?= base_url('/#consultas') ?>" class="btn btn-primary btn-sm">Enviar una consulta</a>
        </div>
      <?php endif; ?>
    </div>

    <!-- TAB 3: MIS RESEÑAS -->
    <div class="client-tab-content" id="client-tab-resenas" style="display: none;">
      <?php if (!empty($myComments)): ?>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
          <?php foreach ($myComments as $com): ?>
            <div style="background: var(--blanco); border-radius: var(--radio); padding: 1.5rem; border: 1px solid var(--gris-cl); box-shadow: var(--sombra-card);">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap;">
                <div style="color: #f39c12; font-size: 1.1rem; letter-spacing: 2px;">
                  <?= str_repeat('★', (int) $com['stars']) . str_repeat('☆', 5 - (int) $com['stars']) ?>
                </div>
                <span style="font-size: 0.8rem; color: var(--gris-med);">
                  <i class="far fa-clock"></i> <?= date('d/m/Y', strtotime($com['created_at'])) ?>
                </span>
              </div>
              <p style="margin: 0; font-size: 0.95rem; color: var(--gris-osc); font-style: italic;">
                "<?= esc($com['comment']) ?>"
              </p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div style="background: var(--blanco); border-radius: var(--radio); padding: 3rem 2rem; text-align: center; box-shadow: var(--sombra-card); border: 1px solid var(--gris-cl);">
          <i class="fas fa-star" style="font-size: 3rem; color: var(--gris-cl); margin-bottom: 1rem; display: block;"></i>
          <p style="color: var(--gris-med); margin-bottom: 1rem;">Aún no dejaste ninguna opinión sobre nuestros cortes.</p>
          <a href="<?= base_url('/#consultas') ?>" class="btn btn-primary btn-sm">Dejar una Reseña</a>
        </div>
      <?php endif; ?>
    </div>

  </div>
</section>

<script>
  function switchClientTab(tabName) {
    const tabs = ['pedidos', 'consultas', 'resenas'];
    tabs.forEach(t => {
      const content = document.getElementById('client-tab-' + t);
      const btn = document.getElementById('tab-btn-' + t);
      if (content && btn) {
        if (t === tabName) {
          content.style.display = 'block';
          btn.style.color = 'var(--rojo)';
          btn.style.borderBottom = '3px solid var(--rojo)';
        } else {
          content.style.display = 'none';
          btn.style.color = 'var(--gris-med)';
          btn.style.borderBottom = '3px solid transparent';
        }
      }
    });
  }
</script>

<?= view('templates/footer') ?>
