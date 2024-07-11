<?php
require '../config.php';

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // Jumlah data per halaman
$offset = ($page - 1) * $limit;

$sql = "SELECT user.id, user.username, user.email, user.nama, user.nim, user.prodi, GROUP_CONCAT(kelas.nama_kelas SEPARATOR ', ') AS courses FROM user LEFT JOIN enrolled_class ON user.id = enrolled_class.id LEFT JOIN kelas ON kelas.id_kelas = enrolled_class.id_kelas WHERE user.role = 'user' GROUP BY user.id, user.username, user.email, user.nama, user.nim, user.prodi AND (username LIKE '%$search%' OR email LIKE '%$search%' OR nama LIKE '%$search%' OR nim LIKE '%$search%' OR prodi LIKE '%$search%') LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$total_sql = "SELECT COUNT(*) FROM user WHERE role = 'user' AND (username LIKE '%$search%' OR email LIKE '%$search%' OR nama LIKE '%$search%' OR nim LIKE '%$search%' OR prodi LIKE '%$search%')";
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_row()[0];
$total_pages = ceil($total_rows / $limit);

$sql2 = "SELECT * 
        FROM kelas";
$result_courses = $conn->query($sql2);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SciTech Camp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>

<?php include 'header.php' ?>

<div class="container mt-5">
    <h1 class="mb-4 mt-5">Admin Dashboard</h1>
    <ul class="nav nav-tabs" id="adminTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="view-users-tab" data-bs-toggle="tab" data-bs-target="#view-users" type="button" role="tab" aria-controls="view-users" aria-selected="true">View Users</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="other-menu-tab" data-bs-toggle="tab" data-bs-target="#other-menu" type="button" role="tab" aria-controls="other-menu" aria-selected="false">Load CSV</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="courses-tab" data-bs-toggle="tab" data-bs-target="#courses" type="button" role="tab" aria-controls="courses" aria-selected="true">Courses</button>
        </li>
    </ul>
    <div class="tab-content" id="adminTabContent">
        <div class="tab-pane fade show active" id="view-users" role="tabpanel" aria-labelledby="view-users-tab">
            <div class="d-flex justify-content-between my-3">
                <button class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#createUserModal">Create User</button>
            </div>
            <form class="form-inline mb-3" method="GET" action="index.php">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?= htmlspecialchars($search); ?>">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Courses</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $user['id']; ?></td>
                        <td><?= $user['username']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td><?= $user['nama']; ?></td>
                        <td><?= $user['nim']; ?></td>
                        <td><?= $user['prodi']; ?></td>
                        <td>
                        <?= $user['courses']; ?>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editUserModal"s>Edit</button>
                            <a href="delete.php?id=<?= $user['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?page=<?= $page - 1; ?>&search=<?= htmlspecialchars($search); ?>">Previous</a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="index.php?page=<?= $i; ?>&search=<?= htmlspecialchars($search); ?>"><?= $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?page=<?= $page + 1; ?>&search=<?= htmlspecialchars($search); ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <div class="tab-pane fade" id="other-menu" role="tabpanel" aria-labelledby="other-menu-tab">
            <?php include '../loadcsv.php' ?>
        </div>

        <div class="tab-pane fade" id="courses" role="tabpanel" aria-labelledby="courses-tab">
            <div class="d-flex justify-content-between my-3">
                <a href="create.php" class="btn btn-primary">Tambah Kelas</a>
            </div>
            <form class="form-inline mb-3" method="GET" action="index.php">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?= htmlspecialchars($search); ?>">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Kelas</th>
                        <th>Nama Kelas</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($kelas = $result_courses->fetch_assoc()): ?>
                    <tr>
                        <td><?= $kelas['id_kelas']; ?></td>
                        <td><?= $kelas['nama_kelas']; ?></td>
                        <td>
                            <a href="edit.php?id=<?= $kelas['id_kelas']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $kelas['id_kelas']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include 'create.php' ?>
    <?php include 'edit.php' ?>
</div>
</body>
</html>
