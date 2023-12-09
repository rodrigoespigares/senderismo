<script src="../views/pages/editar/app.js" dataid=<?=$id?> baseUrl=<?=BASE_URL?>></script>

<section id="editar">
    <form action="<?=BASE_URL?>Base/vEdit" method="POST" v-for="value in ruta" class="formEdit">
        <h2>Editar</h2>
        <div v-for="(valores,key) in value">
            <label :for="key" v-if="key != 'id' && key != 'id_usuario'">{{key}}</label>
            <input type="text" :id="key" :name="key" v-if="key != 'id' && key != 'id_usuario' && key != 'notas' && key !='dificultad'" :value="valores">
            <textarea :id="key" :name="key" cols="100" rows="10" v-if="key == 'notas'" :value="valores"></textarea>
            <select :name="key" id="key" v-if="key == 'dificultad'" v-model="valores">
                <option value="facil" >Facil</option>
                <option value="medio" >Medio</option>
                <option value="dificil" >Dificil</option>
            </select>
            <p class="err" v-if="key == 'titulo'"><?= isset($errores['title']) ? $errores['title'] : "" ?></p>
            <p class="err" v-if="key == 'descripcion'"><?= isset($errores['description']) ? $errores['description'] : "" ?></p>
            <p class="err" v-if="key == 'desnivel'"><?= isset($errores['desnivel']) ? $errores['desnivel'] : "" ?></p>
            <p class="err" v-if="key == 'distancia'"><?= isset($errores['distancia']) ? $errores['distancia'] : "" ?></p>
            <p class="err" v-if="key == 'notas'"><?= isset($errores['notas']) ? $errores['notas'] : "" ?></p>
            <p class="err" v-if="key == 'dificultad'"><?= isset($errores['dificultad']) ? $errores['dificultad'] : "" ?></p>
        </div>
        <div class="botones">
        <button name="editar" :value="value['id']" class="button">Editar</button>
        <a href="<?=BASE_URL?>" class="button">Cancelar</a>
        </div>
    </form>
</section>