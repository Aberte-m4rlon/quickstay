<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'QuickStay') }}</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome (for social icons) -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f9fafb;
      min-height: 100vh;
    }

    /* Optional: smooth gradient + pattern background */
    .gradient-bg {
      background: linear-gradient(135deg, #1e3a8a, #2563eb, #60a5fa);
    }

    /* Decorative circles (subtle like Freepik template) */
    .bg-pattern::before,
    .bg-pattern::after {
      content: "";
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.08);
      filter: blur(50px);
    }
    .bg-pattern::before {
      top: -100px;
      left: -100px;
      width: 300px;
      height: 300px;
    }
    .bg-pattern::after {
      bottom: -120px;
      right: -120px;
      width: 350px;
      height: 350px;
    }
  </style>
</head>

<body class="antialiased bg-pattern">
  {{ $slot }}
</body>
</html>
