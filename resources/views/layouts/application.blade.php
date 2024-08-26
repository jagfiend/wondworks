<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}{{ isset($title) ? " - $title" : '' }}</title>

    <style>
        :root {
            --bg-color: #111111;
            --text-color: #dedede;
        }

        html, body {
            margin: 0;
            background: var(--bg-color);
            color: var(--text-color);
            font-size: 16px;
            font-family: monospace;
        }

        h1 {
            margin-bottom: 0;
        }

        a {
            color: var(--text-color);
            text-decoration: none;

            &:hover, &:active {
                text-decoration: underline;
            }
        }

        .container {
            width: calc(100% - 2em);
            padding: 1em;
            margin: auto;
        }

        @media (min-width: 768px) {
            .container {
                width: 768px;
                padding: 1em 2em;
            }
        }

        @media (min-width: 1024px) {
            .container {
                width: 1024px;
            }
        }
    </style>
</head>
<body>
    @yield('header')

    <main class="container">
        @yield('content')
    </main>
</body>
</html>
