<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            padding: 20px;
            text-align: center;
            color: white;
            font-size: 24px;
        }
        .container {
            padding: 20px;
            max-width: 600px;
            margin: auto;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.1);
        }
        .profile-pic {
            text-align: center;
        }
        .profile-pic img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }
        .info {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        Profil Pengguna
    </header>
    <div class="container">
        <div class="profile-pic">
        </div>
        <div class="info">
            <h2>Nama: {{ $name }}</h2>
            <p>Umur: {{ $umur }}</p>
            <p>NIM: {{ $nim }}</p>
        </div>
    </div>
</body>
</html>
