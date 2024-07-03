<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Ujian Hasil</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <div class="wrapper">
        <div class="content">
            <div class="container mt-5">
                <h1 class="text-center mb-4">Jadwal Ujian Proposal</h1>
                <h2>Jadwal yang Sudah Ditentukan</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Judul Proposal</th>
                            <th>Tanggal</th>
                            <th>Ketua Ujian</th>
                            <th>Pembimbing Akademik 1</th>
                            <th>Pembimbing Akademik 2</th>
                            <th>Dosen Penanggap</th>
                        </tr>
                    </thead>
                    <tbody id="schedule-table">
                        <!-- Data akan dimuat di sini oleh JavaScript -->
                    </tbody>
                </table>

                <h2>Daftar Antrian</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Judul Proposal</th>
                            <th>Ketua Ujian</th>
                            <th>Pembimbing Akademik 1</th>
                            <th>Pembimbing Akademik 2</th>
                            <th>Dosen Penanggap</th>
                        </tr>
                    </thead>
                    <tbody id="queue-table">
                        <!-- Data akan dimuat di sini oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('api/schedule_proposal.php')
                .then(response => response.json())
                .then(data => {
                    let scheduledTableBody = document.getElementById('schedule-table');
                    if (data.scheduled.length === 0) {
                        scheduledTableBody.innerHTML = '<tr><td colspan="7" class="text-center">No data available</td></tr>';
                    } else {
                        data.scheduled.forEach(item => {
                            let row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${item.nama}</td>
                                <td>${item.judul}</td>
                                <td>${item.tanggal}</td>
                                <td>${item.dosen_sekretaris}</td>
                                <td>${item.dosen_pa1}</td>
                                <td>${item.dosen_pa2}</td>
                                <td>${item.dosen_penguji1}</td>
                            `;
                            scheduledTableBody.appendChild(row);
                        });
                    }

                    let queueTableBody = document.getElementById('queue-table');
                    if (data.queue.length === 0) {
                        queueTableBody.innerHTML = '<tr><td colspan="6" class="text-center">No data available</td></tr>';
                    } else {
                        data.queue.forEach(item => {
                            let row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${item.nama}</td>
                                <td>${item.judul}</td>
                                <td>${item.dosen_sekretaris}</td>
                                <td>${item.dosen_pa1}</td>
                                <td>${item.dosen_pa2}</td>
                                <td>${item.dosen_penguji1}</td>
                            `;
                            queueTableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    document.getElementById('schedule-table').innerHTML = '<tr><td colspan="7" class="text-center">Error fetching data</td></tr>';
                    document.getElementById('queue-table').innerHTML = '<tr><td colspan="6" class="text-center">Error fetching data</td></tr>';
                });
        });
    </script>
</body>
<footer>
    <p class="text-center mt-5">create with <span style="color: red;">❤</span> by <a href="https://www.rehad.id/">Reza Hadiwijaya Dynasti</a></p>

</footer>

</html>