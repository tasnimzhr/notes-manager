<?php
require 'auth.php';
require 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: notes-list.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category_id = $_POST['category_id'] ?: null;
    $priority = $_POST['priority'] ?? 'Medium';
    $status   = $_POST['status'] ?? 'Pending';
    $due_date = $_POST['due_date'] ?: null;

    if ($title && $content) {
        $stmt = $pdo->prepare("
            UPDATE notes SET
                title = :title,
                content = :content,
                category_id = :category_id,
                priority = :priority,
                status = :status,
                due_date = :due_date
            WHERE id = :id
        ");
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':category_id' => $category_id,
            ':priority' => $priority,
            ':status' => $status,
            ':due_date' => $due_date,
            ':id' => $id
        ]);
        header('Location: notes-list.php');
        exit;
    } else {
        $error = "Title and content are required.";
    }
}

// fetch note
$stmt = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
$stmt->execute([':id' => $id]);
$note = $stmt->fetch();
if (!$note) {
    header('Location: notes-list.php'); exit;
}


$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

require 'header.php';
?>

<h2 class="fw-bold mb-3">Edit Note</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger small"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post" class="card shadow-sm">
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Title *</label>
            <input type="text" name="title" class="form-control"
                   value="<?php echo htmlspecialchars($note['title']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Content *</label>
            <textarea name="content" rows="5" class="form-control" required><?php
                echo htmlspecialchars($note['content']);
            ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">-- None --</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?php echo $c['id']; ?>"
                            <?php if ($note['category_id'] == $c['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($c['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-select">
                    <?php foreach (['Low','Medium','High'] as $p): ?>
                        <option <?php if ($note['priority'] === $p) echo 'selected'; ?>>
                            <?php echo $p; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <?php foreach (['Pending','In Progress','Completed'] as $s): ?>
                        <option <?php if ($note['status'] === $s) echo 'selected'; ?>>
                            <?php echo $s; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-3 col-md-4">
            <label class="form-label">Due Date</label>
            <input type="date" name="due_date" class="form-control"
                   value="<?php echo $note['due_date']; ?>">
        </div>

        <div class="d-flex justify-content-between">
            <a href="notes-list.php" class="btn btn-outline-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Update Note</button>
        </div>
    </div>
</form>

<?php require 'footer.php'; ?>
