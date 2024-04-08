<?php
if (!isset ($user)) {
    $user = null;
}
?>
<?php require_once __DIR__ . "/header.php"; ?>
<main class="container">

    <form class="container__formulario" action="/login" method="POST" enctype="multipart/form-data">
        <h2 class="formulario__titulo">Efetue login</h3>
            <div class="formulario__campo">
                <label class="campo__etiqueta" for="email">E-Mail</label>
                <input type="email" name="email" class="campo__escrita" required placeholder="Digite seu email"
                    id='email' required />
            </div>


            <div class="formulario__campo">
                <label class="campo__etiqueta" for="senha">Senha</label>
                <input type="password" name="password" class="campo__escrita" required placeholder="Digite sua senha"
                    id='password' required />
            </div>

            <input class="formulario__botao" type="submit" value="Entrar" />
    </form>

</main>
<?php require_once __DIR__ . "/footer.php"; ?>