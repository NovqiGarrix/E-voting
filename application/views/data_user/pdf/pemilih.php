<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <style>
        .judulPDF {
            text-align: center;
            margin-top: 1rem;
            margin-bottom: 3rem;
        }

        table {
            width: 100%;
        }

        table th,
        table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, .2);
        }
    </style>
</head>

<body>
    <h3 class="judulPDF"><?= $title; ?></h3>
    <div class="table-responsive">
        <div class="card-body">
            <table class="table table-striped" id="tabel">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Email</th>
                        <th>Jenis Kelamin</th>
                        <th>Kandidat</th>
                    </tr>
                </thead>
                <?php $i = 1; ?>
                <tbody>
                    <?php foreach ($pemilih as $s) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $s['NISN']; ?></td>
                            <td><?= $s['Name']; ?></td>
                            <td><?= $s['Kelas']; ?></td>
                            <td><?= $s['Email']; ?></td>
                            <td><?= $s['jenisKelamin']; ?></td>
                            <?php if ($s['Kandidat']) : ?>
                                <td><?= $s['Kandidat']; ?></td>
                            <?php else : ?>
                                <td>Belum Memilih</td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>