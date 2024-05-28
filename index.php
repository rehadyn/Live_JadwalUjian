<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Ujian</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
    <style>
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            /* jarak antar tombol */
        }

        .btn-secondary:hover {
            background-color: #007bff;
            /* Warna tombol primary saat di-hover */
            border-color: #007bff;
            /* Warna border tombol primary saat di-hover */
            color: #fff;
            /* Warna teks putih */
        }
    </style>
</head>

<body>
    <div class="container mt-5 text-center">
        <h1 class="mb-4">Jadwal Ujian</h1>
        <div class="btn-group" role="group">
            <a href="jadwalproposal.php" class="btn btn-secondary">Jadwal Ujian Proposal</a>
            <a href="jadwalhasil.php" class="btn btn-secondary">Jadwal Ujian Hasil</a>
        </div>
    </div>
</body>

<footer>
    <p class="text-center mt-5">create with <span style="color: red;">❤</span> by <a href="https://www.rehad.id/">Reza Hadiwijaya Dynasti</a></p>
</footer>

</html>