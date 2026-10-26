<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="If you are looking for a creative or speculative fiction series, you might be looking for leacent books">
    <meta name="keywords" content="books,  web app">
    <meta name="author" content="aowebtech">
    <link rel="icon" href="https://res.cloudinary.com/dqi7g7lky/image/upload/v1793002438/WhatsApp_Image_0008-10-26_at_01.07.28-removebg-preview-removebg-preview_giyzud.png" type="image/x-icon">
    <link rel="shortcut icon" href="https://res.cloudinary.com/dqi7g7lky/image/upload/v1793002438/WhatsApp_Image_0008-10-26_at_01.07.28-removebg-preview-removebg-preview_giyzud.png" type="image/x-icon">
    <title>@yield('title')  | Leacent BookApp -Admin Area By aowebtech</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    @include('layouts.authentication.css')
  </head>
  <body>
    @yield('main_content')
    @include('layouts.authentication.scripts')
</body>

</html>
