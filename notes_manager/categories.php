<?php
require 'auth.php';
require 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    if ($name) {
        $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (:name, :description)");
        $stmt->execute([':name' => $name, ':description' => $description]);
        header('Location: categories.php'); exit;
    } else {
        $error = "Category name is required.";
    }
}


if (isset($_GET['delete'])) {
    $delId = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
    $stmt->execute([':id' => $delId]);
    header('Location: categories.php'); exit;
}


$categories = $pdo->query("SELECT * FROM categories ORDER BY created_at DESC")->fetchAll();

require 'header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold mb-0">Categories</h2>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Add Category</h5>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger small"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Existing Categories</h5>

                <div class="table-responsive">
                    <table class="table align-middle table-striped">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th style="width: 80px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!$categories): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    No categories yet.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($categories as $i => $c): ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo htmlspecialchars($c['name']); ?></td>
                                    <td><?php echo htmlspecialchars($c['description']); ?></td>
                                    <td><?php echo $c['created_at']; ?></td>
                                    <td>
                                        <a href="categories.php?delete=<?php echo $c['id']; ?>"
                                           class="btn btn-sm btn-outline-danger"
                                           onclick="return confirm('Delete this category? Notes will lose this category.');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>
