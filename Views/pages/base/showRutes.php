<?php
// how many records should be displayed on a page?
$records_per_page = 5;
// instantiate the pagination object
$pagination = new Zebra_Pagination();
// the number of total records is the number of records in the array
$pagination->records(count($rutas));
// records per page
$pagination->records_per_page($records_per_page);
// here's the magic: we need to display *only* the records for the current page
$rutas = array_slice(
    $rutas,
    (($pagination->get_page() - 1) * $records_per_page),
    $records_per_page
);
?>
<div class="all">
    <h2>Rutas de senderismo</h2>
    <div>
        <div class="utilities">
            <?php
            if ((isset($_SESSION['admin']) && $_SESSION['admin'] == true) || (isset($_SESSION['identity']) && $_SESSION['identity']['rol'] === "admin")|| (isset($_SESSION['identity']) && $_SESSION['identity']['rol'] === "owner")) :
            ?>
                <a href="<?= BASE_URL ?>Base/newRute">Nueva ruta</a>
                <?php if($_SESSION['identity']['rol'] === "owner"):?>
                    <a href="<?= BASE_URL ?>Admin/gestionUsuarios">Gestión usuarios</a>
                <?php endif;?>
            <?php
            endif;
            ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th>titulo</th>
                    <th>descripcion</th>
                    <th>desnivel (m)</th>
                    <th>distancia (m)</th>
                    <th>dificultad</th>
                    <th>operaciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($rutas as $ruta) : ?>
                    <tr>
                        <td><?= $ruta->getTitulo() ?></td>
                        <td><?= $ruta->getDescripcion() ?></td>
                        <td class="center"><?= $ruta->getDesnivel() ?></td>
                        <td class="center"><?= $ruta->getDistancia() ?></td>
                        <td class="center"><?= $ruta->getDificultad() ?></td>
                        <td class="center">
                            <form action="<?= BASE_URL ?>Base/options" method="post">
                                <?php
                                if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) :
                                ?>
                                    <button name="editar" value="<?= $ruta->getId() ?>"><img src="<?= BASE_URL ?>src/img/edit.svg" alt="editar"></button>
                                    <button name="delete" value="<?= $ruta->getId() ?>"><img src="<?= BASE_URL ?>src/img/trash.svg" alt="borrar"></button>
                                <?php endif; ?>
                                <button name="commit" value="<?= $ruta->getId() ?>"><img src="<?= BASE_URL ?>src/img/comentario.svg" alt="comentarios"></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="buscar">
            <p>Buscador: </p>
            <form action="<?= BASE_URL ?>Base/search" method="POST">
                <select name="option" id="select">
                    <option value="titulo">Titulo</option>
                    <option value="descripcion">Descripcion</option>
                    <option value="desnivel">Desnivel</option>
                    <option value="distancia">Distancia</option>
                    <option value="dificultad">Dificultad</option>
                </select>
                <input type="text" name="search">
                <button type="submit" class="botBuscar">BUSCAR</button>
                <a href="<?= BASE_URL ?>" class="botBuscar">Ver todas las anotaciones</a>
            </form>
        </div>
    </div>
    <?php
    $pagination->render();
    ?>
</div>
<div class="statistics">
    <p>El número total de rutas es de: <?= $contador?></p>
    <p>La ruta más larga tiene: <?= $distancia?> metros </p>
</div>