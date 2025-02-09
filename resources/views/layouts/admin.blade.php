<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        .cyber-glow {
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
        }
        .hologram-effect {
            background: linear-gradient(45deg,
                rgba(16, 185, 129, 0.1) 0%,
                rgba(34, 197, 94, 0.05) 50%,
                rgba(16, 185, 129, 0.1) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
    </style>
</head>

<body class="bg-gray-900 text-gray-100">
    @yield('content')


</body>
</html>
