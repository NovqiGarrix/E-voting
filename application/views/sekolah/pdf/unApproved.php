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
                        <th>Nama Sekolah</th>
                        <th>NPSN</th>
                        <th>Email</th>
                        <th>Vote Method</th>
                        <th>Approval</th>
                    </tr>
                </thead>
                <?php $i = 1; ?>
                <tbody>
                    <?php foreach ($schools as $s) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $s['Name']; ?></td>
                            <td><?= $s['NPSN']; ?></td>
                            <td><?= $s['Email']; ?></td>
                            <td><?= str_replace('-', ' ', $s['voteMethod']); ?></td>
                            <td style="font-weight: 600; color: #f6c23e;">UnApproved</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>