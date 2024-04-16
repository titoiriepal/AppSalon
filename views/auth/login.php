<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email" 
            name="email"
            placeholder="Tu email"
            required
        />
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input 
            type="password"
            id="password" 
            name="password"
            placeholder="Tu Password"
            required
        />
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">


</form>

<div class="acciones">
    <a href="/crear-cuenta"> ¿Aún no tienes una cuenta? Crear una</a>
    <a href="/olvide"> ¿Olvidaste tu Password? </a>

</div>