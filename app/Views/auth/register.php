<?= view('templates/header') ?>

<section class="auth-section">
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-card-header">
        <div class="auth-badge-icon">
          <i class="fas fa-user-plus"></i>
        </div>
        <h2>Crear Cuenta</h2>
        <p>Registrate para una experiencia personalizada y pedidos rápidos</p>
      </div>

      <?php if (session()->getFlashdata('errores')): ?>
        <div class="auth-alert alert-danger">
          <i class="fas fa-exclamation-triangle"></i>
          <div>
            <strong>Revisá los siguientes campos:</strong>
            <ul>
              <?php foreach (session()->getFlashdata('errores') as $error): ?>
                <li><?= esc($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('register') ?>" method="post" class="auth-form">
        <?= csrf_field() ?>

        <div class="form-group">
          <label for="name"><i class="fas fa-user"></i> Nombre Completo</label>
          <input type="text" name="name" id="name" value="<?= old('name') ?>" placeholder="Ej: Santiago Rossi" required autofocus />
        </div>

        <div class="form-group">
          <label for="email"><i class="fas fa-envelope"></i> Correo Electrónico</label>
          <input type="email" name="email" id="email" value="<?= old('email') ?>" placeholder="tu@email.com" required />
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Contraseña (mín. 6)</label>
            <input type="password" name="password" id="password" placeholder="Tu contraseña" required />
          </div>

          <div class="form-group">
            <label for="password_confirm"><i class="fas fa-check-double"></i> Confirmar Contraseña</label>
            <input type="password" name="password_confirm" id="password_confirm" placeholder="Repetí tu contraseña" required />
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-auth-submit">
          <i class="fas fa-user-check"></i> Registrarse
        </button>
      </form>

      <div class="auth-footer-link">
        <p>¿Ya tenés una cuenta registrada? <a href="<?= base_url('login') ?>">Iniciá sesión acá</a></p>
      </div>

    </div>
  </div>
</section>

<?= view('templates/footer') ?>