<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <header>
        <a href="/" id="logo">LOGO</a>
        <nav>
            <ul class="reset">
                <li><a class="active" href="/">Link 1</a></li>
                <li><a href="#">Link 2</a></li>
                <li><a href="#">Link 3</a></li>
                <li><a href="#">Link 4</a></li>
                <li><a href="#">Link 5</a></li>
                <li><a href="#">Link 6</a></li>
            </ul>
        </nav>
        <a href="/sepet"><i class="fa-solid fa-cart-shopping"></i><span class="basket-count">{{ $count }}</span></a>
    </header>
    <main>
        @yield('content')
    </main>

    <footer>
        <ul class="reset">
            <li>
               <h3>Campaign Service Logo</h3>
               <p>Lorem ipsum dolor sit amet.</p>
            </li><li>
               <ol class="reset">
                    <li>Link 2</li>
                    <li>Link 1</li>
                    <li>Link 3</li>
               </ol>
            </li><li>
                <ol class="reset">
                     <li>Link 2</li>
                     <li>Link 1</li>
                     <li>Link 3</li>
                </ol>
             </li><li>
                <ol class="reset">
                     <li>Link 2</li>
                     <li>Link 1</li>
                     <li>Link 3</li>
                </ol>
             </li>
        </ul>
        <copyright>Campaign Service for Case. © 2023</copyright>
    </footer>
</body>
</html>