<?php
require '../config.php';

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$sql = "SELECT user.id, user.username, user.email, user.nama, user.nim, user.prodi, GROUP_CONCAT(kelas.nama_kelas SEPARATOR ', ') AS courses 
        FROM user 
        LEFT JOIN enrolled_class ON user.id = enrolled_class.id 
        LEFT JOIN kelas ON kelas.id_kelas = enrolled_class.id_kelas 
        WHERE user.role = 'user' AND (username LIKE ? OR email LIKE ? OR nama LIKE ? OR nim LIKE ? OR prodi LIKE ?) 
        GROUP BY user.id, user.username, user.email, user.nama, user.nim, user.prodi 
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$search_param = "%$search%";
$stmt->bind_param('ssssssi', $search_param, $search_param, $search_param, $search_param, $search_param, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$total_sql = "SELECT COUNT(*) FROM user WHERE role = 'user' AND (username LIKE ? OR email LIKE ? OR nama LIKE ? OR nim LIKE ? OR prodi LIKE ?)";
$stmt_total = $conn->prepare($total_sql);
$stmt_total->bind_param('sssss', $search_param, $search_param, $search_param, $search_param, $search_param);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_rows = $total_result->fetch_row()[0];
$total_pages = ceil($total_rows / $limit);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $username = $conn->real_escape_string($_POST['username']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $prodi = $conn->real_escape_string($_POST['prodi']);
    $nim = $conn->real_escape_string($_POST['nim']);

    $update_sql = "UPDATE user SET username = ?, nama = ?, email = ?, prodi = ?, nim = ? WHERE id = ?";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param('sssssi', $username, $nama, $email, $prodi, $nim, $id);

    if ($stmt_update->execute()) {
        header('Location: index.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
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
    <script>
    function setModalData(id, username, email, nama, nim, prodi) {
        document.getElementById('id').value = id;
        document.getElementById('username').value = username;
        document.getElementById('email').value = email;
        document.getElementById('nama').value = nama;
        document.getElementById('nim').value = nim;
        document.getElementById('prodi').value = prodi;
    }
</script>

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
                        <td><?= $user['courses']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editUserModal" 
                            onclick="setModalData('<?= $user['id']; ?>', '<?= $user['username']; ?>', '<?= $user['email']; ?>', '<?= $user['nama']; ?>', '<?= $user['nim']; ?>', '<?= $user['prodi']; ?>')">Edit</button>
                            <a href="delete.php?id=<?= $user['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Modal Create User -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="create.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new-username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="new-username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-nama" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="new-nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="new-email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-prodi" class="form-label">Program Studi</label>
                        <input type="text" class="form-control" id="new-prodi" name="prodi" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="new-nim" name="nim" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>


            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="prodi" class="form-label">Program Studi</label>
                                    <input type="text" class="form-control" id="prodi" name="prodi" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim" value="" required>
                                    <input type="hidden" id="id" name="id" value="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Edit User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?= $i; ?>&search=<?= htmlspecialchars($search); ?>"><?= $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>

        <div class="tab-pane fade" id="other-menu" role="tabpanel" aria-labelledby="other-menu-tab">
            <!-- Load CSV functionality -->
        </div>

        <div class="tab-pane fade" id="courses" role="tabpanel" aria-labelledby="courses-tab">
            <!-- Courses functionality -->
        </div>
    </div>
</div>

</body>
</html>
