<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Callback Page</title>
</head>
<body>
    <h1>Callback Page</h1>
    <p>Status</p>
    <p>ref</p>
    <p>amount</p>
    <p>fees</p>
    <p>email</p>


    <table>
        <thead>
            <tr>Status</tr>
            <tr>ref</tr>
            <tr>amount</tr>
            <tr>fees</tr>
            <tr>email</tr>
        </thead>
        <tbody>
            <td>{{ $data->status }}</td>
            <td>{{ $data->reference }}</td>
            <td>{{ $data->amount }}</td>
            <td>{{ $data->fees }}</td>
            <td>{{ $data->customer->email }}</td>
        </tbody>
    </table>
</body>
</html>