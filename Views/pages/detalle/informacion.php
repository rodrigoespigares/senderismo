<script src="../views/pages/detalle/app.js" dataid=<?=$id?> baseUrl=<?=BASE_URL?>></script>
<section id="comentarios">
    <section class="ruta">
        <h2>Datos Ruta</h2>
        <article v-for="value in ruta">
            <div>
                <h3>{{value.titulo}}</h3>
                <p>{{value.descripcion}}</p>
            </div>
            <p><span>Desnivel:</span> {{value.desnivel}}</p>
            <p><span>Distancia:</span> {{value.distancia}}</p>
            <p><span>Dificultad:</span> {{value.dificultad}}</p>
            <div>
                <h4>Notas de la ruta:</h4>
                <p>{{value.notas}}</p>
            </div>
        </article>
    </section>
    <section v-for="comentario in comentarios" class="commentarios">
        <h2>Comentarios:</h2>    
        <article class="commentarios__article" v-for="value of comentario">
            <header class="commentarios__article__header">
                <h3>{{value.nombre}} </h3>
                <p class="commentarios__article__header__date">{{value.fecha}}</p>
            </header>
            <p>{{value.texto}}</p>
            <?php if ($_SESSION['admin'] == true) : ?>
                <details>
                    <summary>Opciones de administrador</summary>
                    
                    <form action="<?= BASE_URL ?>Base/optionsCommit" method="post">
                        <input type="text" name="id_ruta" :value="value.id_ruta" hidden>
                        <button name="delete" :value ="value.id"><img src="<?= BASE_URL ?>src/img/trash.svg" alt="borrar"></button>
                    </form>
                    
                </details>
            <?php endif; ?>
        </article>
    </section>
</section>
<section id="addCommit">
    <h2>Añade un comentario</h2>
    <?php if(!empty($_SESSION['identity'])):?>
        <form action="<?= BASE_URL?>Base/addCommit" method="post" class="formCommit">
            <div>
                <p>Hola <?=$_SESSION['identity']['usuario']?>, ¿quieres añadir un comentario?</p>
                <label for="text">Comentario:</label>
                <textarea name="data[text]" id="text" cols="100" rows="10" placeholder="Añade aquí tu cometario..."></textarea>
                <p class="err"><?= isset($errores['comentario']) ? $errores['comentario'] : "" ?></p>
            </div>
            <button type="submit" name="data[id_ruta]" value="<?=$id?>">Comentar</button>
        </form>
    <?php else:?>
        <form action="<?= BASE_URL?>Login/login" method="post" class="container">
            <button type="submit" name="login" class="log">Log in</button>
            <button type="submit" name="register" class="reg">Sign up</button>
        </form>
    <?php endif;?>
</section>

