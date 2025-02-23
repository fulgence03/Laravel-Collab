<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collab</title>
    
    
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0iIzQzNUVCRSIgY2xhc3M9ImJpIGJpLXBlb3BsZS1maWxsIiB2aWV3Qm94PSIwIDAgMTYgMTYiPg0KICA8cGF0aCBkPSJNNyAxNHMtMSAwLTEtMSAxLTQgNS00IDUgMyA1IDQtMSAxLTEgMXptNC02YTMgMyAwIDEgMCAwLTYgMyAzIDAgMCAwIDAgNm0tNS43ODQgNkEyLjI0IDIuMjQgMCAwIDEgNSAxM2MwLTEuMzU1LjY4LTIuNzUgMS45MzYtMy43MkE2LjMgNi4zIDAgMCAwIDUgOWMtNCAwLTUgMy01IDRzMSAxIDEgMXpNNC41IDhhMi41IDIuNSAwIDEgMCAwLTUgMi41IDIuNSAwIDAgMCAwIDUiLz4NCjwvc3ZnPg0K"/>



    <link rel="stylesheet" href="././assets/compiled/css/app.css">
    <link rel="stylesheet" href="././assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="././assets/compiled/css/iconly.css">
        @vite(entrypoints: ['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="logo fs-5" style="color: #435EBE;">
        <i class="bi bi-people-fill"></i> <em>Collab</em>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
