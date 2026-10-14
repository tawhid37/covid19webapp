<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Self-Assessment Form</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="/css/main.css" rel="stylesheet">
    </head>
    <body>

       @yield('content')

       <div class="footer">
           <p>This COVID 19 Self Assessment System is only for software development purpose and may not yield actual result. Any information given by users of this system will not be disclosed or store to anywhere.</p>
       </div>
    
    </body>
</html>
