<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: left;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h1 class="header">Laporan Toko Wildan</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Customer</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->nama_customer }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>Rp. {{ number_format($item->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
