<?php require_once 'header.php' ?>
<main class="noticias">
    <?php foreach($noticias as $noticia){?>
    <article class="card-noticia">
        <img src="<?= $noticia->img?>" alt="">
        <h2><?= $noticia->titulo ?></h2>
        <p><?= $noticia->resumen?></p>
        <a class="btn-showMore" href="verNoticia/<?= $noticia->id ?>">Ver Más</a>
    </article>
    <?php } ?>
</main>