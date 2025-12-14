<?php
require 'auth.php';
require 'db.php';
require 'header.php';


$stmt = $pdo->query("
    SELECT n.*, c.name AS category_name
    FROM notes n
    LEFT JOIN categories c ON n.category_id = c.id
    ORDER BY n.created_at DESC
");
$notes = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold mb-0">Notes</h2>
    <a href="note-add.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Note
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle table-striped">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Created</th>
                    <th style="width: 120px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!$notes): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-3">
                            No notes yet. Click "Add Note" to create one.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($notes as $i => $n): ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo htmlspecialchars($n['title']); ?></td>
                        <td><?php echo htmlspecialchars($n['category_name'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($n['priority']); ?></td>
                        <td><?php echo htmlspecialchars($n['status']); ?></td>
                        <td><?php echo $n['due_date'] ?: '-'; ?></td>
                        <td><?php echo $n['created_at']; ?></td>
                        <td>
                            <a href="note-edit.php?id=<?php echo $n['id']; ?>"
                               class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="note-delete.php?id=<?php echo $n['id']; ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Delete this note?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>
