<?php
include("../../class/database.php");
include("../../class/formlibary.php");

$config = include("../../class/config.php");

$db = new Database($config['host'], $config['username'], $config['password'], $config['db_name']);

// query untuk menampilkan data
$q = "";
if (isset($_GET['submit']) && !empty($_GET['q'])) {
    $q = $_GET['q'];
    $sql_where = " WHERE nama LIKE '{$q}%'"; 
}

$title = 'Data Barang';
$sql = 'SELECT * FROM data_barang ';
$sql_count = "SELECT COUNT(*) FROM data_barang";
if (isset($sql_where)) {
    $sql .= $sql_where;
    $sql_count .= $sql_where;
}

$result_count = $db->query($sql_count);
$count = 0;
if ($result_count) {
    $r_data = $result_count->fetch_row();
    $count = $r_data[0];
}

$per_page = 10; // Sesuaikan jumlah item per halaman sesuai kebutuhan
$num_page = ceil($count / $per_page);
$limit = $per_page;

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $offset = ($page - 1) * $per_page;
} else {
    $offset = 0;
    $page = 1;
}

$sql .= " LIMIT {$offset}, {$limit}";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <div class="container">
        <?php require('../../template/header.php'); ?>
        <h2>Data Barang</h2>
        <div class="main">
            <form method="get" action="">
                <input type="text" name="q" value="<?php echo $q; ?>" placeholder="Cari nama barang">
                <input type="submit" name="submit" value="Cari">
            </form>
            <a class="tambah" href="tambah.php">Tambah Barang</a>
            <?php echo FormLibrary::generateTable($result); ?>
            <div class="pagination">
                <?php
                for ($i = 1; $i <= $num_page; $i++) {
                    echo "<a href='index.php?page={$i}'>{$i}</a> ";
                }
                ?>
            </div>
        </div>
        <?php require('../../template/footer.php'); ?>
    </div>
</body>

</html>

<?php
// Jangan lupa untuk menutup koneksi setelah selesai menggunakannya
$db->closeConnection();
?>
