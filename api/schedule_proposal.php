<?php
header('Content-Type: application/json');
include('../config.php');

function formatIndonesianDate($dateStr)
{
    setlocale(LC_TIME, 'id_ID.UTF-8');
    $timestamp = strtotime($dateStr);
    $formattedDate = strftime("%A, %d %B %Y", $timestamp);

    // Ensure the day names and month names are in Indonesian
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

// Get current date
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
$sql_unscheduled = "SELECT 
                        tb_data_mahasiswa.nama, 
                        tb_skripsi.judul_skripsi AS judul,
                        tb_skripsi.dosen_sekretaris,
                        tb_skripsi.dosen_pa1,
                        tb_skripsi.dosen_pa2,
                        tb_skripsi.dosen_penguji1,
                        tb_skripsi.judul_hasil
                    FROM 
                        tb_skripsi
                    INNER JOIN 
                        tb_data_mahasiswa 
                    ON 
                        tb_skripsi.id_mahasiswa = tb_data_mahasiswa.id
                    INNER JOIN 
                        tb_dokumen 
                    ON 
                        tb_skripsi.id_mahasiswa = tb_dokumen.id_mahasiswa
                    WHERE 
                        tb_skripsi.judul_skripsi IS NOT NULL AND 
                        tb_skripsi.dosen_pa1 IS NOT NULL AND 
                        tb_skripsi.dosen_pa2 IS NOT NULL AND 
                        tb_skripsi.dosen_penguji1 IS NOT NULL AND 
                        tb_dokumen.surat_persetujuan_pembimbing_pdf IS NOT NULL AND 
                        tb_skripsi.tanggal_proposal IS NULL AND 
                        tb_skripsi.judul_hasil IS NULL";

$result_unscheduled = $conn->query($sql_unscheduled);
$unscheduled = array();

if ($result_unscheduled->num_rows > 0) {
    while ($row = $result_unscheduled->fetch_assoc()) {
        $unscheduled[] = $row;
    }
}

echo json_encode(['scheduled' => $scheduled, 'unscheduled' => $unscheduled]);

$conn->close();
