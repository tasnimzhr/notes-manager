<?php

session_start();


require 'auth.php';
require 'db.php';


require 'header.php';


$totalNotes = $pdo->query("SELECT COUNT(*) AS c FROM notes")->fetch()['c'];

$totalCategories = $pdo->query("SELECT COUNT(*) AS c FROM categories")->fetch()['c'];


$statusStmt = $pdo->query("SELECT status, COUNT(*) AS c FROM notes GROUP BY status");
$statuses = [];
$statusCounts = [];
foreach ($statusStmt as $row) {
    $statuses[] = $row['status'];
    $statusCounts[] = (int)$row['c'];
}


$catStmt = $pdo->query("
    SELECT c.name, COUNT(n.id) AS total
    FROM categories c
    LEFT JOIN notes n ON n.category_id = c.id
    GROUP BY c.id, c.name
    ORDER BY c.name
");
$catLabels = [];
$catCounts = [];
foreach ($catStmt as $row) {
    $catLabels[] = $row['name'];
    $catCounts[] = (int)$row['total'];
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Dashboard</h2>
        <p class="text-muted mb-0">Overview of your notes and categories</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-summary border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-uppercase text-muted small">Total Notes</h6>
                <h2 class="fw-bold mb-0"><?php echo $totalNotes; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-summary border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-uppercase text-muted small">Categories</h6>
                <h2 class="fw-bold mb-0"><?php echo $totalCategories; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-summary border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-uppercase text-muted small">Statuses</h6>
                <?php foreach ($statuses as $i => $st): ?>
                    <div class="d-flex justify-content-between small">
                        <span><?php echo htmlspecialchars($st); ?></span>
                        <span class="fw-semibold"><?php echo $statusCounts[$i]; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-3">Notes by Category</h5>
        <canvas id="catChart" height="100"></canvas>
    </div>
</div>

<script>
const catLabels = <?php echo json_encode($catLabels); ?>;
const catData   = <?php echo json_encode($catCounts); ?>;

const ctx = document.getElementById('catChart').getContext('2d');
const catChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: catLabels,
        datasets: [{
            label: 'Number of Notes',
            data: catData,
            backgroundColor: [
                '#ff9aa2', 
                '#ffb7b2',
                '#ffdac1',
                '#e2f0cb',
                '#b5ead7',
                '#c7ceea'
            ],
            borderColor: '#ffffff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

</script>

<?php require 'footer.php'; ?>
