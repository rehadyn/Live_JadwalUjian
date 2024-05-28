<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Seminar Proposal</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">

</head>

<body>
    <div class="wrapper">
        <div class="content">
            <div class="container mt-5">
                <h1 class="text-center mb-4">Jadwal Seminar Proposal</h1>

                <h2 class="mt-4">Jadwal yang Sudah Ditentukan</h2>
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

                <h2 class="mt-4">Daftar Antrian</h2>
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
                    // Handle scheduled proposals
                    let scheduledTableBody = document.getElementById('schedule-table');
                    if (data.scheduled.length === 0) {
                        scheduledTableBody.innerHTML = '<tr><td colspan="7" class="text-center">No data available</td></tr>';
                    } else {
                        data.scheduled.forEach(item => {
                            let row = document.createElement('tr');
                            let namaCell = document.createElement('td');
                            let judulCell = document.createElement('td');
                            let tanggalCell = document.createElement('td');
                            let dosenSekretarisCell = document.createElement('td');
                            let dosenPa1Cell = document.createElement('td');
                            let dosenPa2Cell = document.createElement('td');
                            let dosenPenguji1Cell = document.createElement('td');

                            namaCell.textContent = item.nama;
                            judulCell.textContent = item.judul;
                            tanggalCell.textContent = item.tanggal;
                            dosenSekretarisCell.textContent = item.dosen_sekretaris;
                            dosenPa1Cell.textContent = item.dosen_pa1;
                            dosenPa2Cell.textContent = item.dosen_pa2;
                            dosenPenguji1Cell.textContent = item.dosen_penguji1;

                            row.appendChild(namaCell);
                            row.appendChild(judulCell);
                            row.appendChild(tanggalCell);
                            row.appendChild(dosenSekretarisCell);
                            row.appendChild(dosenPa1Cell);
                            row.appendChild(dosenPa2Cell);
                            row.appendChild(dosenPenguji1Cell);
                            scheduledTableBody.appendChild(row);
                        });
                    }

                    // Handle unscheduled proposals
                    let queueTableBody = document.getElementById('queue-table');
                    if (data.unscheduled.length === 0) {
                        queueTableBody.innerHTML = '<tr><td colspan="6" class="text-center">No data available</td></tr>';
                    } else {
                        data.unscheduled.forEach(item => {
                            let row = document.createElement('tr');
                            let namaCell = document.createElement('td');
                            let judulCell = document.createElement('td');
                            let dosenSekretarisCell = document.createElement('td');
                            let dosenPa1Cell = document.createElement('td');
                            let dosenPa2Cell = document.createElement('td');
                            let dosenPenguji1Cell = document.createElement('td');

                            namaCell.textContent = item.nama;
                            judulCell.textContent = item.judul;
                            dosenSekretarisCell.textContent = item.dosen_sekretaris;
                            dosenPa1Cell.textContent = item.dosen_pa1;
                            dosenPa2Cell.textContent = item.dosen_pa2;
                            dosenPenguji1Cell.textContent = item.dosen_penguji1;

                            row.appendChild(namaCell);
                            row.appendChild(judulCell);
                            row.appendChild(dosenSekretarisCell);
                            row.appendChild(dosenPa1Cell);
                            row.appendChild(dosenPa2Cell);
                            row.appendChild(dosenPenguji1Cell);
                            queueTableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    let scheduledTableBody = document.getElementById('schedule-table');
                    let queueTableBody = document.getElementById('queue-table');
                    scheduledTableBody.innerHTML = '<tr><td colspan="7" class="text-center">Error fetching data</td></tr>';
                    queueTableBody.innerHTML = '<tr><td colspan="6" class="text-center">Error fetching data</td></tr>';
                });
        });
    </script>
</body>
<footer>
    <p class="text-center mt-5">create with <span style="color: red;">❤</span> by <a href="https://www.rehad.id/">Reza Hadiwijaya Dynasti</a></p>

</footer>

</html>