<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #ff6600;
            padding: 20px;
            text-align: center;
            color: white;
            font-size: 24px;
        }
        nav {
            display: flex;
            justify-content: center;
            background-color: #333;
            padding: 10px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }
        .category {
            border: 1px solid #ddd;
            margin: 10px;
            padding: 15px;
            width: 250px;
            text-align: center;
        }
        .category img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <header>
        Toko Online
    </header>
    <nav>
        <a href="#">Home</a>
        <a href="#">Produk</a>
        <a href="#">Promo</a>
        <a href="#">Kontak</a>
    </nav>
    <div class="container">
        <div class="category">
            <h3>Food Beverage</h3>
        </div>
        <div class="category">
            <h3>Beauty Health</h3>
        </div>
        <div class="category">
            <h3>Home Care</h3>
        </div>
        <div class="category">
            <h3>Baby Kid</h3>
        </div>
    </div>
</body>
</html>
