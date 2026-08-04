<?php
require_once 'config/database.php';
include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="card-modern animate-in">
            <div class="card-header-modern">
                <i class="fas fa-plus-circle me-2" style="color: #11998e;"></i> Add New Phone
            </div>

            <form action="store.php" method="POST" class="form-modern">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="e.g., iPhone 15 Pro" required>
                    </div>
                    <div class="col-md-6">
                        <label for="brand" class="form-label">Brand <span class="text-danger">*</span></label>
                        <select class="form-select" id="brand" name="brand" required>
                            <option value="" selected disabled>Select a brand</option>
                            <option value="Apple">Apple</option>
                            <option value="Samsung">Samsung</option>
                            <option value="Google">Google</option>
                            <option value="OnePlus">OnePlus</option>
                            <option value="Xiaomi">Xiaomi</option>
                            <option value="Oppo">Oppo</option>
                            <option value="Vivo">Vivo</option>
                            <option value="Huawei">Huawei</option>
                            <option value="Sony">Sony</option>
                            <option value="Nokia">Nokia</option>
                            <option value="Motorola">Motorola</option>
                            <option value="Nothing">Nothing</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="model" name="model" placeholder="e.g., A2848" required>
                    </div>
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="0.00" required>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stock" name="stock" placeholder="0" required>
                    </div>
                    <div class="col-md-6">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control" id="color" name="color" placeholder="e.g., Space Black">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label for="ram" class="form-label">RAM</label>
                        <input type="text" class="form-control" id="ram" name="ram" placeholder="e.g., 8GB">
                    </div>
                    <div class="col-md-6">
                        <label for="storage" class="form-label">Storage</label>
                        <input type="text" class="form-control" id="storage" name="storage" placeholder="e.g., 256GB">
                    </div>
                </div>

                <div class="mt-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" 
                              placeholder="Write a short description…" style="resize: vertical;"></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                    <a href="index.php" class="btn btn-modern btn-modern-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-modern btn-modern-success">
                        <i class="fas fa-save"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>