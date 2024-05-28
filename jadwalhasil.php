<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Ujian Hasil</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex: 1;
        }

        footer {
            background: #f8f9fa;
            padding: 20px 0;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="content">
            <div class="container mt-5">
                <h1 class="text-center mb-4">Jadwal Ujian Hasil</h1>

                <h2 class="mt-4">Jadwal yang Sudah Ditentukan</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Judul Hasil</th>
                            <th>Tanggal</th>
                            <th>Dosen Ketua</th>
                            <th>Dosen Sekretaris</th>
                            <th>Dosen PA1</th>
                            <th>Dosen PA2</th>
                            <th>Dosen Penguji 1</th>
                            <th>Dosen Penguji 2</th>
                        </tr>
                    </thead>
                    <tbody id="schedule-table">
                        <!-- Data akan dimuat di sini oleh JavaScript -->
                    </tbody>
                </table>

                <h2 class="mt-4">Daftar Antrian</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Judul Hasil</th>
                            <th>Dosen Ketua</th>
                            <th>Dosen Sekretaris</th>
                            <th>Dosen PA1</th>
                            <th>Dosen PA2</th>
                            <th>Dosen Penguji 1</th>
                            <th>Dosen Penguji 2</th>
                        </tr>
                    </thead>
                    <tbody id="queue-table">
                        <!-- Data akan dimuat di sini oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
        <footer>
            <p class="text-center mt-5">create with <span style="color: red;">❤</span> by <a href="https://www.rehad.id/">Reza Hadiwijaya Dynasti</a></p>
        </footer>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('api/schedule_hasil.php')
                .then(response => response.json())
                .then(data => {
                    // Handle scheduled results
                    let scheduledTableBody = document.getElementById('schedule-table');
                    if (data.scheduled.length === 0) {
                        scheduledTableBody.innerHTML = '<tr><td colspan="9" class="text-center">No data available</td></tr>';
                    } else {
                        data.scheduled.forEach(item => {
                            let row = document.createElement('tr');
                            let namaCell = document.createElement('td');
                            let judulCell = document.createElement('td');
                            let tanggalCell = document.createElement('td');
                            let dosenKetuaCell = document.createElement('td');
                            let dosenSekretarisCell = document.createElement('td');
                            let dosenPa1Cell = document.createElement('td');
                            let dosenPa2Cell = document.createElement('td');
                            let dosenPenguji1Cell = document.createElement('td');
                            let dosenPenguji2Cell = document.createElement('td');

                            namaCell.textContent = item.nama;
                            judulCell.textContent = item.judul;
                            tanggalCell.textContent = item.tanggal;
                            dosenKetuaCell.textContent = item.dosen_ketua;
                            dosenSekretarisCell.textContent = item.dosen_sekretaris;
                            dosenPa1Cell.textContent = item.dosen_pa1;
                            dosenPa2Cell.textContent = item.dosen_pa2;
                            dosenPenguji1Cell.textContent = item.dosen_penguji1;
                            dosenPenguji2Cell.textContent = item.dosen_penguji2;

                            row.appendChild(namaCell);
                            row.appendChild(judulCell);
                            row.appendChild(tanggalCell);
                            row.appendChild(dosenKetuaCell);
                            row.appendChild(dosenSekretarisCell);
                            row.appendChild(dosenPa1Cell);
                            row.appendChild(dosenPa2Cell);
                            row.appendChild(dosenPenguji1Cell);
                            row.appendChild(dosenPenguji2Cell);
                            scheduledTableBody.appendChild(row);
                        });
                    }

                    // Handle unscheduled results
                    let queueTableBody = document.getElementById('queue-table');
                    if (data.unscheduled.length === 0) {
                        queueTableBody.innerHTML = '<tr><td colspan="8" class="text-center">No data available</td></tr>';
                    } else {
                        data.unscheduled.forEach(item => {
                            let row = document.createElement('tr');
                            let namaCell = document.createElement('td');
                            let judulCell = document.createElement('td');
                            let dosenKetuaCell = document.createElement('td');
                            let dosenSekretarisCell = document.createElement('td');
                            let dosenPa1Cell = document.createElement('td');
                            let dosenPa2Cell = document.createElement('td');
                            let dosenPenguji1Cell = document.createElement('td');
                            let dosenPenguji2Cell = document.createElement('td');

                            namaCell.textContent = item.nama;
                            judulCell.textContent = item.judul;
                            dosenKetuaCell.textContent = item.dosen_ketua;
                            dosenSekretarisCell.textContent = item.dosen_sekretaris;
                            dosenPa1Cell.textContent = item.dosen_pa1;
                            dosenPa2Cell.textContent = item.dosen_pa2;
                            dosenPenguji1Cell.textContent = item.dosen_penguji1;
                            dosenPenguji2Cell.textContent = item.dosen_penguji2;

                            row.appendChild(namaCell);
                            row.appendChild(judulCell);
                            row.appendChild(dosenKetuaCell);
                            row.appendChild(dosenSekretarisCell);
                            row.appendChild(dosenPa1Cell);
                            row.appendChild(dosenPa2Cell);
                            row.appendChild(dosenPenguji1Cell);
                            row.appendChild(dosenPenguji2Cell);
                            queueTableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    let scheduledTableBody = document.getElementById('schedule-table');
                    let queueTableBody = document.getElementById('queue-table');
                    scheduledTableBody.innerHTML = '<tr><td colspan="9" class="text-center">Error fetching data</td></tr>';
                    queueTableBody.innerHTML = '<tr><td colspan="8" class="text-center">Error fetching data</td></tr>';
                });
        });
    </script>
</body>
<footer>
    <p class="text-center mt-5">create with <span style="color: red;">❤</span> by <a href="https://www.rehad.id/">Reza Hadiwijaya Dynasti</a></p>

</footer>

</html>