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
            <th>Pemasukan</th>
            <th>Pengeluaran</th>
            <th>Saldo</th>
            </thead>
        </tr>
        <?php if($data['subsubtitle'] != ''){ ?>
            <tr>
                <td colspan="6"><?= $data['subsubtitle'] ?></td>
                <td><?= 'Rp '.number_format($data['saldos']['saldobefore']) ?></td>
            </tr>
        <?php } 
        $no = 1;
        $num = 0;
        if($data['saldos']['saldo'] != array()){
            foreach($data['duit'] as $fer){ ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $fer['tanggal'] ?></td>
                    <td><?= $fer['keterangan'] ?></td>
                    <td><?= $fer['username'] ?></td>
                    <?php if($fer['jenis_transaksi'] == 'masuk'){ ?> <td><?= 'Rp '.number_format($fer['nominal']); ?></td> <?php } 
                    else{ ?><td><?= 'Rp -'; ?></td><?php } 
                    if($fer['jenis_transaksi'] == 'keluar'){ ?> <td><?= 'Rp '.number_format($fer['nominal']); ?></td> <?php } 
                    else{ ?><td><?='Rp -'; ?></td><?php } ?>
                    <td><?= 'Rp '.number_format($data['saldos']['saldo'][$num++]) ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4">Total Keseluruhan</td>
                <td><?= 'Rp '.number_format($data['total_pm']) ?></td>
                <td><?= 'Rp '.number_format($data['total_pn']) ?></td>
                <td><?= 'Rp '.number_format($data['saldos']['saldo'][$num - 1]) ?></td>
            </tr>
        <?php }else{ ?>
            <tr><td colspan="7">Tidak ada data</td></tr>
        <?php } ?>
    </table>
</body>
</html>