<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Introduce tus datos para crear una nueva cuenta</p>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input 
            type="text"
            id="nombre" 
            name="nombre"
            placeholder="Tu Nombre"
            
        />
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input 
            type="text"
            id="apellido" 
            name="apellido"
            placeholder="Tu Apellido"
            
        />
    </div>

    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input 
            type="tel"
            id="telefono" 
            name="telefono"
            placeholder="Tu Teléfono"
            
        />
    </div>

    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email" 
            name="email"
            placeholder="Tu email"
            
        />
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            id="password" 
            name="password"
            placeholder="Tu Password"
            
        />
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">


</form>

<div class="acciones">
    <a href="/"> ¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/olvide"> ¿Olvidaste tu Password? </a>

</div>