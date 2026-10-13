<?= view('templates/header') ?>

<section class="auth-section">
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-card-header">
        <div class="auth-badge-icon">
          <i class="fas fa-user-lock"></i>
        </div>
        <h2>Iniciar Sesión</h2>
        <p>Accedé a tu cuenta para gestionar tus pedidos y consultas</p>
      </div>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="auth-alert alert-danger">
          <i class="fas fa-exclamation-circle"></i>
          <span><?= esc(session()->getFlashdata('error')) ?></span>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('exito')): ?>
        <div class="auth-alert alert-success">
          <i class="fas fa-check-circle"></i>
          <span><?= esc(session()->getFlashdata('exito')) ?></span>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('login') ?>" method="post" class="auth-form">
        <?= csrf_field() ?>

        <div class="form-group">
          <label for="email"><i class="fas fa-envelope"></i> Correo Electrónico</label>
          <input type="email" name="email" id="email" value="<?= old('email') ?>" placeholder="tu@email.com" required autofocus />
        </div>

        <div class="form-group">
          <label for="password"><i class="fas fa-key"></i> Contraseña</label>
          <input type="password" name="password" id="password" placeholder="Tu contraseña" required />
        </div>

        <button type="submit" class="btn btn-primary btn-auth-submit">
          <i class="fas fa-sign-in-alt"></i> Ingresar al Sistema
        </button>
      </form>

      <div class="auth-footer-link">
        <p>¿No tenés una cuenta todavía? <a href="<?= base_url('register') ?>">Registrate acá</a></p>
      </div>

      <!-- CREDENCIALES DE DEMOSTRACIÓN -->
      <div class="auth-demo-box">
        <div class="demo-box-title">
          <i class="fas fa-info-circle"></i> Cuentas de demostración disponibles:
        </div>
        <div class="demo-credentials">
          <div>
            <strong>Administrador:</strong> <code>admin@boutique.com</code> / <code>admin123</code>
          </div>
          <div>
            <strong>Cliente:</strong> <code>cliente@boutique.com</code> / <code>cliente123</code>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<?= view('templates/footer') ?>