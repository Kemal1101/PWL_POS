<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007bff;
            padding: 20px;
            text-align: center;
            color: white;
            font-size: 24px;
        }
        .container {
            padding: 20px;
            max-width: 800px;
            margin: auto;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        Halaman Transaksi
    </header>
    <div class="container">
        <h2>Riwayat Transaksi</h2>
        <table>
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>TRX001</td>
                <td>2024-02-19</td>
                <td>Rp 500.000</td>
                <td>Sukses</td>
            </tr>
            <tr>
                <td>TRX002</td>
                <td>2024-02-18</td>
                <td>Rp 750.000</td>
                <td>Pending</td>
            </tr>
            <tr>
                <td>TRX003</td>
                <td>2024-02-17</td>
                <td>Rp 1.000.000</td>
                <td>Dibatalkan</td>
            </tr>
        </table>
    </div>
</body>
</html>
