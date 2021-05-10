<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>KH88 Casino</h1>
    <p>Transfer Credit Request:</p>
    <p>Username: {{ $data['username'] }}</p>
    <p>Payment: {{ $data['payment'] }}</p>
    <p>Amount: USD {{ number_format( $data['outStandingCredit'],2) }}</p>
</body>
</html>