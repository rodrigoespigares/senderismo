<table>
    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Contraseña</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Email</th>
        <th>Fecha Nacimiento</th>
        <th>Movil</th>
        <th>Rol</th>
        <th>Operaciones</th>
    </tr>
    
    <?php foreach ($usuarios as $key => $usuario) : ?>
        <tr>
            <td><?= $usuario->getId()?></td>
            <td><?= $usuario->getUsuario()?></td>
            <td><?= $usuario->getContrasena()?></td>
            <td><?= $usuario->getNombre()?></td>
            <td><?= $usuario->getApellidos()?></td>
            <td><?= $usuario->getEmail()?></td>
            <td><?= $usuario->getFechaNacimiento()?></td>
            <td><?= $usuario->getMovil()?></td>
            <td><?= $usuario->getRol()?></td>
            <td>
                <form action="<?=BASE_URL?>Admin/operaciones" method="POST">
                    <button name="editar"value="<?= $usuario->getId()?>"><img src="<?= BASE_URL ?>src/img/edit.svg" alt="editar"></button>
                    <button name="borrar"value="<?= $usuario->getId()?>"><img src="<?= BASE_URL ?>src/img/trash.svg" alt="borrar"></button>
                </form>
            </td>
        </tr>
    <?php endforeach;?>
</table>