<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulario System Demo</title>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f8;
    color: #333;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 40px auto;
    background-color: #ffffff;
    padding: 30px 40px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.container h2 {
    margin-bottom: 20px;
    font-size: 1.8rem;
    color: #1a202c;
    border-bottom: 2px solid #3182ce;
    padding-bottom: 8px;
}

ul.error {
    list-style: none;
    background-color: #ffe5e5;
    border: 1px solid #ff4d4d;
    color: #b20000;
    padding: 10px 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}

form div {
    margin-bottom: 15px;
}

form label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
}

form input[type="text"],
form input[type="date"],
form textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #cbd5e0;
    border-radius: 6px;
    font-size: 1rem;
}

.actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}
</style>
</head>

<body>

<section class="container">
  <h2>{{modeDsc}}</h2>

  {{if hasErrores}}
  <ul class="error">
    {{foreach errores}}
      <li>{{this}}</li>
    {{endfor errores}}
  </ul>
  {{endif hasErrores}}

  <form action="index.php?page=SystemDemoRony&mode={{mode}}&id={{id_demo}}" method="post">

    <div>
      <label for="id_demo">ID</label>
      <input type="text" name="id_demo" id="id_demo" value="{{id_demo}}" {{idReadonly}}>
      <input type="hidden" name="vlt" value="{{token}}">
    </div>

    <div>
      <label for="nombre_demo">Nombre del Demo</label>
      <input type="text" name="nombre_demo" id="nombre_demo" value="{{nombre_demo}}" {{readonly}}>
    </div>

    <div>
      <label for="descripcion">Descripción</label>
      <textarea name="descripcion" id="descripcion" {{readonly}}>{{descripcion}}</textarea>
    </div>

    <div>
      <label for="version_sistema">Versión del Sistema</label>
      <input type="text" name="version_sistema" id="version_sistema" value="{{version_sistema}}" {{readonly}}>
    </div>

    <div>
      <label for="fecha_demo">Fecha Demo</label>
      <input type="date" name="fecha_demo" id="fecha_demo" value="{{fecha_demo}}" {{readonly}}>
    </div>

    <div class="actions">
      <button id="btnCancelar">Cancelar</button>
      {{ifnot isDisplay}}
      <button id="btnConfirmar" type="submit">Confirmar</button>
      {{endifnot isDisplay}}
    </div>

  </form>
</section>

<script>
document.getElementById("btnCancelar").addEventListener("click", function(e){
    e.preventDefault();
    window.location.assign("index.php?page=SystemDemoRony");
});
</script>

</body>
</html>
