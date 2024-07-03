<?php
header('Content-Type: application/json');
include('../config.php');

function formatIndonesianDate($dateStr)
{
    setlocale(LC_TIME, 'id_ID.UTF-8');
    $timestamp = strtotime($dateStr);
    $formattedDate = strftime("%A, %d %B %Y", $timestamp);

    $dayNames = array(
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    );

    $monthNames = array(
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    );

    foreach ($dayNames as $en => $id) {
        $formattedDate = str_replace($en, $id, $formattedDate);
    }

    foreach ($monthNames as $en => $id) {
        $formattedDate = str_replace($en, $id, $formattedDate);
    }

    return $formattedDate;
}

$currentDate = date('Y-m-d');

// Get scheduled proposals
$sql = "SELECT 
            tb_data_mahasiswa.nama, 
            tb_skripsi.judul_skripsi AS judul, 
            tb_skripsi.tanggal_proposal AS tanggal,
            tb_skripsi.dosen_sekretaris,
            tb_skripsi.dosen_pa1,
            tb_skripsi.dosen_pa2,
            tb_skripsi.dosen_penguji1
        FROM 
            tb_skripsi
        INNER JOIN 
            tb_data_mahasiswa 
        ON 
            tb_skripsi.id_mahasiswa = tb_data_mahasiswa.id
        WHERE 
            tb_skripsi.tanggal_proposal IS NOT NULL";

$result = $conn->query($sql);
$scheduled = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['tanggal'] >= $currentDate) {
            $row['tanggal'] = formatIndonesianDate($row['tanggal']);
            $scheduled[] = $row;
        }
    }
}

// Get unscheduled proposals
$sql_queue = "SELECT 
                    tb_data_mahasiswa.nama, 
                    tb_skripsi.judul_skripsi AS judul,
                    tb_skripsi.dosen_sekretaris,
                    tb_skripsi.dosen_pa1,
                    tb_skripsi.dosen_pa2,
                    tb_skripsi.dosen_penguji1,
                    tb_skripsi.status_sempro
                FROM 
                    tb_skripsi
                INNER JOIN 
                    tb_data_mahasiswa 
                ON 
                    tb_skripsi.id_mahasiswa = tb_data_mahasiswa.id
                WHERE 
                    tb_skripsi.status_sempro = 'pending'";

$result_queue = $conn->query($sql_queue);
$queue = array();

if ($result_queue->num_rows > 0) {
    while ($row = $result_queue->fetch_assoc()) {
        if (!empty($row['nama']) && !empty($row['judul']) && !empty($row['dosen_sekretaris']) && !empty($row['dosen_pa1']) && !empty($row['dosen_pa2']) && !empty($row['dosen_penguji1'])) {
            $queue[] = $row;
        }
    }
}

echo json_encode(['scheduled' => $scheduled, 'queue' => $queue]);

$conn->close();
