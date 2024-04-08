<?php
if (!isset($video)) {
    $video = null;
}
?>
<?php require_once __DIR__ . "/header.php"; ?>
<main class="container">

    <form class="container__formulario" action="<?= $video ? "/editar-video" : "/adicionar-video"; ?>" method="POST"
        enctype="multipart/form-data">
        <h2 class="formulario__titulo">Enviar vídeo!</h2>
        <input type="hidden" name="id" value="<?= $video?->id(); ?>">
        <div class="formulario__campo">
            <label class="campo__etiqueta" for="url">Link embed</label>
            <input name="url" class="campo__escrita"
                placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g" id='url'
                value="<?= $video?->url(); ?>" required />
        </div>


        <div class="formulario__campo">
            <label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
            <input name="titulo" class="campo__escrita" placeholder="Neste campo, dê o nome do vídeo" id='titulo'
                value="<?= $video?->title(); ?>" required />
        </div>

        <div class="formulario__campo">
            <label class="campo__etiqueta" for="imagem">Imagem do vídeo</label>
            <input type="file" accept="image/*" name="image" class="campo__escrita" placeholder="Selecionar imagem"
                id='imagem' value="<?= $video?->imagePath(); ?>" />
        </div>

        <input name="form-video" class="formulario__botao" type="submit" value="Enviar" />
    </form>

</main>
<?php require_once __DIR__ . "/footer.php"; ?>