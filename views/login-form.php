
<?php include_once __DIR__ . '/header.php'; ?>
    <main class="container">
            
        <form class="container__formulario" method="post">
            <h2 class="formulario__titulo">Efetue login</h3>
                <div class="formulario__campo">
                    <label class="campo__etiqueta" for="email">Email</label>
                    <input name="email" type="email" class="campo__escrita" required
                        placeholder="Digite seu email" id='email' />
                </div>


                <div class="formulario__campo">
                    <label class="campo__etiqueta" for="password">Senha</label>
                    <input type="password" name="password" class="campo__escrita" required placeholder="Digite sua senha"
                        id='password' />
                </div>

                <input class="formulario__botao" type="submit" value="Entrar" />

                <div class="alerta-container">
                    <?php if($_SERVER['REQUEST_URI'] === '/login?sucesso=0'): ?>
                        <div class="alerta">
                            <?= $_SESSION['erro']; unset($_SESSION['erro']); ?>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
        </form>

    </main>

<?php include_once __DIR__ . '/footer.php'; ?>