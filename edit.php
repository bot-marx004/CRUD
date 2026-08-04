<?php
require_once 'config/database.php';
include 'includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    $_SESSION['error'] = 'Product not found!';
    header('Location: index.php');
    exit;
}
?>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="card-modern animate-in">
            <div class="card-header-modern">
                <i class="fas fa-pen me-2" style="color: #f6d365;"></i> Edit Phone
            </div>

            <form action="update.php" method="POST" class="form-modern">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="brand" class="form-label">Brand <span class="text-danger">*</span></label>
                        <?php
                        $brandOptions = ['Apple', 'Samsung', 'Google', 'OnePlus', 'Xiaomi', 'Oppo', 'Vivo', 'Huawei', 'Sony', 'Nokia', 'Motorola', 'Nothing', 'Other'];
                        $selectedBrand = $product['brand'];
                        ?>
                        <select class="form-select" id="brand" name="brand" required>
                            <option value="" disabled>Select a brand</option>
                            <?php foreach ($brandOptions as $brandOption): ?>
                                <option value="<?= htmlspecialchars($brandOption) ?>" <?= $selectedBrand === $brandOption ? 'selected' : '' ?>><?= htmlspecialchars($brandOption) ?></option>
                            <?php endforeach; ?>
                            <?php if (!empty($selectedBrand) && !in_array($selectedBrand, $brandOptions, true)): ?>
                                <option value="<?= htmlspecialchars($selectedBrand) ?>" selected><?= htmlspecialchars($selectedBrand) ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="model" name="model" value="<?= htmlspecialchars($product['model']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $product['price'] ?>" required>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stock" name="stock" value="<?= $product['stock'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control" id="color" name="color" value="<?= htmlspecialchars($product['color']) ?>" placeholder="e.g., Space Black">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label for="ram" class="form-label">RAM</label>
                        <input type="text" class="form-control" id="ram" name="ram" value="<?= htmlspecialchars($product['ram']) ?>" placeholder="e.g., 8GB">
                    </div>
                    <div class="col-md-6">
                        <label for="storage" class="form-label">Storage</label>
                        <input type="text" class="form-control" id="storage" name="storage" value="<?= htmlspecialchars($product['storage']) ?>" placeholder="e.g., 256GB">
                    </div>
                </div>

                <div class="mt-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" 
                              style="resize: vertical;"><?= htmlspecialchars($product['description']) ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                    <a href="index.php" class="btn btn-modern btn-modern-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-modern btn-modern-warning">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>