<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Will</title>
    {{-- <style>
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    </style> --}}
</head>
<body>
    <h1 style="text-align: center; margin-bottom: 20px;">Will</h1>
      <p>Name: {{ $user->name }}</p>
      <p>Email: {{ $user->email }}</p>
      <p>Phone: {{ $user->mobile }}</p>
      <p>Address: {{ $profile->permanent_address_line_2 }}</p>
</body>
</html>