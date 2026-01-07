<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba Lector Código</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        #codigo { padding: 10px; width: 300px; font-size: 16px; }
        #resultado { margin-top: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 8px; max-width: 400px; display: none; }
        .error { color: red; }
        .success { color: green; border-color: green; }
    </style>
</head>
<body>

<h2>Módulo de Ventas - Prueba de Escáner</h2>

<p>Escanee un producto o ingrese el código <strong>766623401517</strong> para probar.</p>

<input 
    type="text" 
    id="codigo" 
    placeholder="Escanea el producto"
    autofocus
>

<div id="resultado"></div>

<script>
document.getElementById('codigo').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();

        const codigo = this.value.trim();
        this.value = '';

        if (!codigo) return;

        $('#resultado').hide().removeClass('error success').html('Buscando...');

        $.ajax({
            url: "{{ route('venta.buscar.producto') }}",
            method: "GET",
            data: { codigo },
            success: function(res) {
                $('#resultado').show().addClass('success').html(`
                    <p><strong>Producto:</strong> ${res.nombre}</p>
                    <p><strong>Precio:</strong> Bs ${res.precio}</p>
                    <p><strong>Stock:</strong> ${res.stock}</p>
                    <p><strong>Categoría:</strong> ${res.categoria}</p>
                `);
            },
            error: function(xhr) {
                let msg = 'Producto no encontrado';
                if (xhr.status === 404 && xhr.responseJSON && xhr.responseJSON.error) {
                    msg = xhr.responseJSON.error;
                }
                $('#resultado').show().addClass('error').html(`<p>${msg}</p>`);
            }
        });
    }
});
</script>

</body>
</html>
