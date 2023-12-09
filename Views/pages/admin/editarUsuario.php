<script src="../views/pages/admin/app.js" dataid=<?=$id?> baseUrl=<?=BASE_URL?>></script>


<section id="editarUsuario">

    <form action="<?=BASE_URL?>Admin/vEdit" method="POST" v-for="value in user" class="formEdit">
        <h2>Editar rol del usuario</h2>
        <div v-for="(valores,key) in value" >
            <label for="user" v-if="key == 'usuario'">{{valores}}</label>
            <select name="rol" id="user" v-if="key == 'usuario'">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <p class="err" v-if="key == 'rol'"><?= isset($errores['rol']) ? $errores['rol'] : "" ?></p>
        </div>
        <div class="botones">
        <button name="editar" :value="value['id']" class="button">Editar</button>
        <a href="<?=BASE_URL?>" class="button">Cancelar</a>
        </div>
    </form>
</section>