<form action="<?=BASE_URL?>Base/newRute" method="post" class="formRute">
    <div>
        <label for="title">Titulo</label>
        <input type="text" name="data[title]" id="title" value="<?= isset($relleno['title'])?$relleno['title']:""?>">
        <p class="err"><?= isset($errores['title']) ? $errores['title'] : "" ?></p>
    </div>
    <div>
        <label for="description">Descripcion</label>
        <input type="text" name="data[description]" id="description" value="<?= isset($relleno['description'])?$relleno['description']:""?>">
        <p class="err"><?= isset($errores['description']) ? $errores['description'] : "" ?></p>
    </div>
    <div>
        <label for="desnivel">Desnivel</label>
        <input type="text" name="data[desnivel]" id="desnivel" value="<?= isset($relleno['desnivel'])?$relleno['desnivel']:""?>">
        <p class="err"><?= isset($errores['desnivel']) ? $errores['desnivel'] : "" ?></p>
    </div>
    <div>
        <label for="distancia">Distancia</label>
        <input type="text" name="data[distancia]" id="distancia" value="<?= isset($relleno['distancia'])?$relleno['distancia']:""?>">
        <p class="err"><?= isset($errores['distancia']) ? $errores['distancia'] : "" ?></p>
    </div>
    <div>
        <label for="dificultad">Dificultad</label>
        <select name="data[dificultad]" id="dificultad">
            <option value="" hidden>Dificultad</option>
            <option value="facil" <?=(isset($relleno) && $relleno['dificultad']=="facil")?"selected":""?>>Facil</option>
            <option value="medio" <?=(isset($relleno) && $relleno['dificultad']=="medio")?"selected":""?>>Medio</option>
            <option value="dificil" <?=(isset($relleno) && $relleno['dificultad']=="dificil")?"selected":""?>>Dificil</option>
        </select>
        <p class="err"><?= isset($errores['dificultad']) ? $errores['dificultad'] : "" ?></p>
    </div>
    <div>
        <label for="notas">Notas</label>
        <textarea name="data[notas]" id="notas" cols="30" rows="10" value="<?= isset($relleno['notas'])?$relleno['notas']:""?>"></textarea>
        <p class="err"><?= isset($errores['notas']) ? $errores['notas'] : "" ?></p>
    </div>
    <button type="submit">Nueva Ruta</button>
    <a href="<?=BASE_URL?>">Cancelar</a>
</form>