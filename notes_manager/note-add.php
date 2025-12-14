<?php
require 'auth.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category_id = $_POST['category_id'] ?: null;
    $priority = $_POST['priority'] ?? 'Medium';
    $status   = $_POST['status'] ?? 'Pending';
    $due_date = $_POST['due_date'] ?: null;

    if ($title && $content) {
        $stmt = $pdo->prepare("
            INSERT INTO notes (title, content, category_id, priority, status, due_date)
            VALUES (:title, :content, :category_id, :priority, :status, :due_date)
        ");
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':category_id' => $category_id,
            ':priority' => $priority,
            ':status' => $status,
            ':due_date' => $due_date
        ]);
        header('Location: notes-list.php');
        exit;
    } else {
        $error = "Title and content are required.";
    }
}


$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

require 'header.php';
?>

<h2 class="fw-bold mb-3">Add Note</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger small"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post" class="card shadow-sm">
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Title *</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Content *</label>
            <textarea name="content" rows="5" class="form-control" required></textarea>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">-- None --</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?php echo $c['id']; ?>">
                            <?php echo htmlspecialchars($c['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-select">
                    <option>Low</option>
                    <option selected>Medium</option>
                    <option>High</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option selected>Pending</option>
                    <option>In Progress</option>
                    <option>Completed</option>
                </select>
            </div>
        </div>

        <div class="mb-3 col-md-4">
            <label class="form-label">Due Date</label>
            <input type="date" name="due_date" class="form-control">
        </div>

        <div class="d-flex justify-content-between">
            <a href="notes-list.php" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Note</button>
        </div>
    </div>
</form>

<?php require 'footer.php'; ?>
