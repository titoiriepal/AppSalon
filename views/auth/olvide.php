<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Introduce tu emai para recibir un correo para reestablecer tu contraseña</p>

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

    <input type="submit" class="boton" value="Enviar Instrucciones">


</form>

<div class="acciones">
    <a href="/crear-cuenta"> ¿Aún no tienes una cuenta? Crear una</a>
    <a href="/"> ¿Ya tienes una cuenta? Inicia Sesión</a>

</div>