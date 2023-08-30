<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?></title>
</head>
<body>
    <h1><?= $data['title'] ?></h1>
    <?php if($data['subtitle'] != ''){ ?>
    <h3><?= $data['subtitle'] ?></h3>
    <?php } ?>
    <br>
    <table border="1">
        <tr>
            <thead>
            <th>No</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Username</th>
            <th>Nominal</th>
            </thead>
        </tr>
        <?php
        $no = 1;
        $total = 0;
        foreach($data['duit'] as $fer){ ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $fer['tanggal'] ?></td>
                <td><?= $fer['keterangan'] ?></td>
                <td><?= $fer['username'] ?></td>
                <td><?= 'Rp '.number_format($fer['nominal']) ?></td>
            </tr>
        <?php $total += $fer['nominal']; } ?>
        <tr>
            <td colspan="4">Total Keseluruhan</td>
            <td><?= 'Rp '.number_format($total) ?></td>
        </tr>
    </table>
</body>
</html>