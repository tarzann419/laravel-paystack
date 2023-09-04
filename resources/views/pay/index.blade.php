<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment</title>
</head>
<body>
    <h1>start payment</h1>

    <!-- errors are stored in sessions. so we check if theres any error stored in this particular session -->

    @if( session()->has('error'))  {{ session()->get('error') }}@endif
    <form action="{{ route('pay') }}" method="post">
        @csrf

        <input type="email" name="email" placeholder="enter your email">
        <input type="amount" name="amount" placeholder="enter your amount">
        <input type="submit">

    </form>
</body>
</html>