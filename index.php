<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-image: url('https://jid.storage.googleapis.com/wp-content/uploads/2022/12/15211556/WhatsApp-Image-2022-12-15-at-21.13.50.jpeg');
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
    <!-- Konten halaman Anda -->
</body>
</html>

<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "akademik";

$koneksi    = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){ //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}else{
    echo "Koneksi berhasil";
}

$NIM        = "";
$Nama       = "";
$Alamat     = "";
$Fakultas   = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $ID         = $_GET['ID'];
    $sql1       = "delete from mahasiswa where ID = '$ID'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $ID         = $_GET['ID'];
    $sql1       = "select * from mahasiswa where ID = '$ID'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $NIM        = $r1['NIM'];
    $Nama       = $r1['Nama'];
    $Alamat     = $r1['Alamat'];
    $Fakultas   = $r1['Fakultas'];

    if ($NIM == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $NIM        = $_POST['NIM'];
    $Nama       = $_POST['Nama'];
    $Alamat     = $_POST['Alamat'];
    $Fakultas   = $_POST['Fakultas'];

    if ($NIM && $Nama && $Alamat && $Fakultas) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update mahasiswa set NIM = '$NIM',Nama='$Nama',Alamat = '$Alamat',Fakultas='$Fakultas' where ID = '$ID'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into mahasiswa(NIM,Nama,Alamat,Fakultas) values ('$NIM','$Nama','$Alamat','$Fakultas')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
        <div class="bg-image h-100" style="background-image: url('https://mdbootstrap.com/img/Photos/new-templates/tables/img2.jpg');">
           
                <div class="mask d-flex align-items-center h-100" style="background-color: rgba(0,0,0,.25);">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12">
              <div class="card-body">
                <div class="table-responsive">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="NIM" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" ID="NIM" name="NIM" value="<?php echo $NIM ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" ID="Nama" name="Nama" value="<?php echo $Nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" ID="Alamat" name="Alamat" value="<?php echo $Alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Fakultas" class="col-sm-2 col-form-label">Fakultas</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="Fakultas" ID="Fakultas">
                                <option value="">- Pilih Fakultas -</option>
                                <option value="Teknik Informatika" <?php if ($Fakultas == "Teknik Informatika") echo "selected" ?>>Teknik Informatika</option>
                                <option value="Sistem Informasi" <?php if ($Fakultas == "Sistem Informasi") echo "selected" ?>>Sistem Informasi</option>
                                <option value="Pendidikan Ekonomi"<?php if ($Fakultas == "Pendidikan Ekonomi") echo "selected" ?>>Pendidikan Ekonomi</option>
                                <option value="Pendidikan Sastra"<?php if ($Fakultas == "Pendidikan Sastra") echo "selected" ?>>Pendidikan Sastra</option>
                                <option value="Pendidikan Matematika"<?php if ($Fakultas == "Pendidikan Matematika") echo "selected" ?>>Pendidikan Matematika</option>
                                <option value="Pendidikan Mipa"<?php if ($Fakultas == "Pendidikan Mipa") echo "selected" ?>>Pendidikan Mipa</option>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="bg-image h-100" style="background-image: url('https://mdbootstrap.com/img/Photos/new-templates/tables/img2.jpg');">
                Data Mahasiswa
                <div class="mask d-flex align-items-center h-100" style="background-color: rgba(0,0,0,.25);">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card bg-dark shadow-2-strong">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-dark table-borderless mb-0">
                    <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from mahasiswa order by ID desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $ID         = $r2['ID'];
                            $NIM        = $r2['NIM'];
                            $Nama       = $r2['Nama'];
                            $Alamat     = $r2['Alamat'];
                            $Fakultas   = $r2['Fakultas'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $NIM ?></td>
                                <td scope="row"><?php echo $Nama ?></td>
                                <td scope="row"><?php echo $Alamat ?></td>
                                <td scope="row"><?php echo $Fakultas ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&ID=<?php echo $ID ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&ID=<?php echo $ID?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>
