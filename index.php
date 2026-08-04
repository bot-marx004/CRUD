<?php
require_once 'config/database.php';

if (empty($_SESSION['user'])) {
    $_SESSION['error'] = 'Please sign in to view the inventory.';
    header('Location: login.php');
    exit;
}

include 'includes/header.php';

// Get search query
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build query
if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM products 
                           WHERE name LIKE ? 
                           OR brand LIKE ? 
                           OR model LIKE ? 
                           OR description LIKE ?
                           ORDER BY created_at DESC");
    $searchTerm = "%$search%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
} else {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
}

$products = $stmt->fetchAll();
?>

<div class="card-modern animate-in">

    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color: #1a1a2e;">
            <i class="fas fa-th-list me-2" style="color: #667eea;"></i> Product Inventory
        </h4>
        <p class="text-muted small mb-0">Manage your phone collection</p>
    </div>
    <div class="d-flex gap-2">
        <a href="export_pdf.php<?= !empty($search) ? '?search=' . urlencode($search) : '' ?>" 
           class="btn btn-modern btn-modern-danger" target="_blank">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <a href="create.php" class="btn btn-modern btn-modern-success">
            <i class="fas fa-plus-circle"></i> Add Phone
        </a>
    </div>
</div>

<!-- Export info -->
<?php if (!empty($search)): ?>
    <div class="mb-3">
        <small class="text-muted">
            Showing results for: "<?= htmlspecialchars($search) ?>"
           
            </a>
        </small>
    </div>
<?php endif; ?>

    <!-- Search -->
<div class="row g-3 mb-4">
    <div class="col-md-8 col-lg-6">
        <form action="index.php" method="GET" class="d-flex gap-2">
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search by name, brand, or model..." 
                       value="<?= htmlspecialchars($search) ?>" class="form-control">
            </div>
            <button type="submit" class="btn btn-modern btn-modern-primary">
                <i class="fas fa-arrow-right"></i>
            </button>
            <?php if (!empty($search)): ?>
                <a href="index.php" class="btn btn-modern btn-modern-secondary">
                    <i class="fas fa-times"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>
</div>

    <!-- Table -->
    <?php if (count($products) > 0): ?>
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Specs</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $index => $product): ?>
                        <tr class="animate-in animate-in-d<?= ($index % 3) + 1 ?>">
                            <td><span class="fw-bold text-muted">#<?= $index + 1 ?></span></td>
                            <td>
                                <div class="fw-semibold"><?= htmlspecialchars($product['name']) ?></div>
                                <small class="text-muted"><?= htmlspecialchars($product['model']) ?></small>
                            </td>
                            <td><span class="badge-brand"><?= htmlspecialchars($product['brand']) ?></span></td>
                            <td><span class="fw-bold">$<?= number_format($product['price'], 2) ?></span></td>
                            <td>
                                <?php if ($product['stock'] > 0): ?>
                                    <span class="badge-stock-in"><i class="fas fa-check-circle me-1"></i> <?= $product['stock'] ?></span>
                                <?php else: ?>
                                    <span class="badge-stock-out"><i class="fas fa-times-circle me-1"></i> Out of Stock</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small class="text-muted d-block"><?= htmlspecialchars($product['ram'] ?? '—') ?> / <?= htmlspecialchars($product['storage'] ?? '—') ?></small>
                                <small class="text-muted"><?= htmlspecialchars($product['color'] ?? '') ?></small>
                            </td>
                            <td style="text-align: center;">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="edit.php?id=<?= $product['id'] ?>" 
                                       class="btn btn-modern-warning btn-icon" title="Edit" style="color: #fff;">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $product['id'] ?>" 
                                       class="btn btn-modern-danger btn-icon" title="Delete" 
                                       onclick="return confirm('Delete <?= htmlspecialchars($product['name']) ?>?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <small class="text-muted">Showing <?= count($products) ?> product(s)</small>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-box-open icon"></i>
            <h4>No products found</h4>
            <p class="text-muted">
                <?php if (!empty($search)): ?>
                    No results for "<?= htmlspecialchars($search) ?>"
                <?php else: ?>
                    Your inventory is empty. Start adding phones!
                <?php endif; ?>
            </p>
            <?php if (!empty($search)): ?>
                <a href="index.php" class="btn btn-modern btn-modern-secondary">View All</a>
            <?php else: ?>
                <a href="create.php" class="btn btn-modern btn-modern-primary">
                    <i class="fas fa-plus-circle me-2"></i> Add First Phone
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>