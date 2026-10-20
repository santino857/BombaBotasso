<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>La Boutique del Cerdo – Río Tercero, Córdoba</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <script>
    const BASE_URL = "<?= rtrim(base_url(), '/') ?>/";
  </script>
</head>
<body>

  <!-- NAVBAR -->
  <header class="navbar" id="navbar">
    <div class="nav-inner">
      <a href="<?= base_url('/') ?>#inicio" class="nav-logo">
        <span class="logo-main">La Boutique</span>
        <span class="logo-sub">del Cerdo</span>
      </a>
      <nav class="nav-links">
        <a href="<?= base_url('/') ?>#inicio">Inicio</a>
        <a href="<?= base_url('/') ?>#productos">Productos</a>
        <a href="<?= base_url('/') ?>#nosotros">Nosotros</a>
        <a href="<?= base_url('/') ?>#contacto">Contacto</a>
        <a href="<?= base_url('/') ?>#consultas">Consultas</a>

        <button type="button" class="cart-nav-btn" onclick="toggleCartModal()" title="Ver pedido" aria-label="Carrito de pedidos">
          <i class="fas fa-shopping-basket"></i>
          <span class="cart-badge" id="cartCountBadge">0</span>
        </button>
        
        <?php if (session()->get('isLoggedIn')): ?>
          <a href="<?= base_url('mis-pedidos') ?>" class="user-orders-link" title="Mis Pedidos">
            <i class="fas fa-receipt"></i> Mis Pedidos
          </a>
          <?php if (session()->get('role') === 'admin'): ?>
            <a href="<?= base_url('admin') ?>" class="admin-nav-link" title="Panel de Administración">
              <i class="fas fa-shield-alt"></i> Panel Admin
            </a>
          <?php endif; ?>
          <span class="user-greeting">
            <i class="fas fa-user-circle"></i> <?= esc(session()->get('name')) ?>
          </span>
          <a href="<?= base_url('logout') ?>" class="logout-link" title="Cerrar sesión">
            <i class="fas fa-sign-out-alt"></i> Salir
          </a>
        <?php else: ?>
          <a href="<?= base_url('login') ?>">Ingresar</a>
          <a href="<?= base_url('register') ?>" class="nav-register-btn">Registrarse</a>
        <?php endif; ?>
      </nav>
      <div class="nav-right-mobile">
        <button type="button" class="cart-nav-btn cart-mobile" onclick="toggleCartModal()" title="Ver pedido">
          <i class="fas fa-shopping-basket"></i>
          <span class="cart-badge" id="cartCountBadgeMobile">0</span>
        </button>
        <button class="hamburger" id="hamburger" aria-label="Menú">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
    <div class="mobile-menu" id="mobileMenu">
      <a href="<?= base_url('/') ?>#inicio" onclick="closeMobile()">Inicio</a>
      <a href="<?= base_url('/') ?>#productos" onclick="closeMobile()">Productos</a>
      <a href="<?= base_url('/') ?>#nosotros" onclick="closeMobile()">Nosotros</a>
      <a href="<?= base_url('/') ?>#contacto" onclick="closeMobile()">Contacto</a>
      <a href="<?= base_url('/') ?>#consultas" onclick="closeMobile()">Consultas</a>
      <a href="javascript:void(0)" onclick="closeMobile(); toggleCartModal();">
        <i class="fas fa-shopping-basket"></i> Mi Pedido (<span id="cartCountTextMobile">0</span>)
      </a>
      <?php if (session()->get('isLoggedIn')): ?>
        <a href="<?= base_url('mis-pedidos') ?>" onclick="closeMobile()" style="color: var(--dorado-cl);">
          <i class="fas fa-receipt"></i> Mis Pedidos
        </a>
        <?php if (session()->get('role') === 'admin'): ?>
          <a href="<?= base_url('admin') ?>" onclick="closeMobile()" style="color: var(--dorado-cl);">
            <i class="fas fa-shield-alt"></i> Panel de Administración
          </a>
        <?php endif; ?>
        <a href="<?= base_url('logout') ?>" onclick="closeMobile()" style="color: var(--rojo);">
          Cerrar Sesión (<?= esc(session()->get('name')) ?>)
        </a>
      <?php else: ?>
        <a href="<?= base_url('login') ?>" onclick="closeMobile()">Ingresar</a>
        <a href="<?= base_url('register') ?>" onclick="closeMobile()">Registrarse</a>
      <?php endif; ?>
    </div>
  </header>

  <!-- MENSAJES FLASH GLOBALES -->
  <?php if (session()->getFlashdata('exito') || session()->getFlashdata('error') || session()->getFlashdata('info')): ?>
    <div class="global-alerts-container">
      <?php if (session()->getFlashdata('exito')): ?>
        <div class="global-alert alert-success">
          <i class="fas fa-check-circle"></i>
          <span><?= esc(session()->getFlashdata('exito')) ?></span>
          <button type="button" onclick="this.parentElement.remove()" class="alert-close">&times;</button>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="global-alert alert-danger">
          <i class="fas fa-exclamation-triangle"></i>
          <span><?= esc(session()->getFlashdata('error')) ?></span>
          <button type="button" onclick="this.parentElement.remove()" class="alert-close">&times;</button>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('info')): ?>
        <div class="global-alert alert-info">
          <i class="fas fa-info-circle"></i>
          <span><?= esc(session()->getFlashdata('info')) ?></span>
          <button type="button" onclick="this.parentElement.remove()" class="alert-close">&times;</button>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>