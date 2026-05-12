<header>
        <div class="header-left">
            <div class="logo">🏢 MEXIMOTIX</div>
            <div class="page-title">Dashboard</div>
        </div>
        <div class="header-right">
            <div class="user-info">
                <p><strong>Usuario:</strong> <?php echo htmlspecialchars($_SESSION["usuario"] ?? 'Usuario'); ?></p>
                <p style="font-size: 12px; color: #999;">Conectado</p>
            </div>
        </div>
    </header>