<?php if ((isset($_POST['login']) && !isset($_SESSION['identity'])) || isset($error)) : ?>
    <h2>Login</h2>
    <form action="<?= BASE_URL ?>Login/vLogin" method="post" class="formLogin">
        <input type="text" name="isLogin" value="true" hidden>
        <div>
            <label for="email">Email</label>
            <input type="text" name="data[email]" id="email" value="<?=isset($datos['email'])?$datos['email']:""?>">
            <p class="err"><?= isset($error['email']) ? $error['email'] : "" ?></p>
        </div>
        <div>
            <label for="password">Contraseña</label>
            <input type="password" name="data[password]" id="password">
            <p class="err"><?= isset($error['password']) ? $error['password'] : "" ?></p>
        </div>
        <p>¿No tienes usuario?<a href="<?= BASE_URL ?>Login/login"> Haz click y registrate</a></p>
        <button type="submit">Login</button>
    </form>
<?php elseif (!isset($_POST['login']) || isset($_POST['register'])) : ?>
    <h2>Register</h2>
    <form action="<?= BASE_URL ?>Login/vLogin" method="post" class="formLogin">
        <input type="text" name="isLogin" value="false" hidden>
        <div>
            <label for="user">Usuario</label>
            <input type="text" name="data[user]" id="user" value="<?=isset($datos['user'])?$datos['user']:""?>">
            <p class="err"><?= isset($errores['usuario']) ? $errores['usuario'] : "" ?></p>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="text" name="data[email]" id="email" value="<?=isset($datos['email'])?$datos['email']:""?>">
            <p class="err"><?= isset($errores['email']) ? $errores['email'] : "" ?></p>
        </div>
        <div>
            <label for="password">Contraseña</label>
            <input type="password" name="data[password]" id="password">
            <p class="err"><?= isset($errores['password']) ? $errores['password'] : "" ?></p>
        </div>
        <div>
            <label for="password2">Confirma contraseña</label>
            <input type="password" name="data[password2]" id="password2">
            <p class="err"><?= isset($errores['password2']) ? $errores['password2'] : "" ?></p>
        </div>
        <div>
            <label for="name">Nombre</label>
            <input type="text" name="data[name]" id="name" value="<?=isset($datos['name'])?$datos['name']:""?>">
            <p ><?= isset($errores['name']) ? $errores['name'] : "" ?></p>
        </div>
        <div>
            <label for="subname">Apellidos</label>
            <input type="text" name="data[subname]" id="subname" value="<?=isset($datos['subname'])?$datos['subname']:""?>">
            <p class="err"><?= isset($errores['subname']) ? $errores['subname'] : "" ?></p>
        </div>
        <div>
            <label for="movil">Movil</label>
            <input type="text" name="data[movil]" id="movil" value="<?=isset($datos['movil'])?$datos['movil']:""?>">
            <p class="err"><?= isset($errores['movil']) ? $errores['movil'] : "" ?></p>
        </div>
        <div>
            <label for="date">Fecha de nacimiento</label>
            <input type="text" name="data[date]" id="date" value="<?=isset($datos['date'])?$datos['date']:""?>">
            <p class="err"><?= isset($errores['date']) ? $errores['date'] : "" ?></p>
        </div>
        <button type="submit">Registrar</button>
    </form>





<?php endif; ?>