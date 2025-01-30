<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Factura</title>
</head>

<body>
    <h1>Factura</h1>
    <p>Nombre: {{ $data['nombre_cliente'] }}</p>
    <p>Teléfono: {{ $data['numero_telefono'] }}</p>
    <p>Dirección: {{ $data['direccion'] }}</p>
    <p>Número de Registro: {{ $data['registro_num'] }}</p>
    <p>Giro: {{ $data['giro'] }}</p>
    <p>Documento: {{ $data['documento'] }}</p>
    <p>Email: {{ $data['email'] }}</p>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['cart'] as $item)
                <tr>
                    <td>{{ $item['product_name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['precio_producto'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Total: {{ $data['total'] }}</p>
</body>

</html>
