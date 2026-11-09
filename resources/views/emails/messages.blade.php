<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Message MMViewstetic</title>
</head>
<body>
<table>
    <tbody>
        <tr>
           <th>Nombre:</th>
            <td>{{ $dataMessage->name }}</td>
        </tr>
        <tr>
           <th>Correo:</th>
            <td>{{ $dataMessage->email }}</td>
        </tr>
        <tr>
           <th>Motivo:</th>
            <td>{{ $dataMessage->subject }}</td>
        </tr>
        <tr>
           <th>Mensaje:</th>
            <td>{{ $dataMessage->content }}</td>
        </tr>
    </tbody>
</table>
</body>
</html>
