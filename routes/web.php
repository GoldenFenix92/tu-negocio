<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController; // Import ServiceController
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\StockAlertController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CashControlController; // Import CashControlController
use App\Http\Controllers\CouponController; // Import CouponController
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ManualController; // Import ManualController
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController; // Import DashboardController

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Client Routes
    Route::get('/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('clients.index')->middleware('can:clients.view');
    Route::get('/clients/create', [App\Http\Controllers\ClientController::class, 'create'])->name('clients.create')->middleware('can:clients.create');
    Route::post('/clients', [App\Http\Controllers\ClientController::class, 'store'])->name('clients.store')->middleware('can:clients.create');
    Route::get('/clients/{client}', [App\Http\Controllers\ClientController::class, 'show'])->name('clients.show')->middleware('can:clients.view');
    Route::get('/clients/{client}/edit', [App\Http\Controllers\ClientController::class, 'edit'])->name('clients.edit')->middleware('can:clients.edit');
    Route::put('/clients/{client}', [App\Http\Controllers\ClientController::class, 'update'])->name('clients.update')->middleware('can:clients.edit');
    Route::delete('/clients/{client}', [App\Http\Controllers\ClientController::class, 'destroy'])->name('clients.destroy')->middleware('can:clients.delete');
    Route::post('clients/{id}/restore', [App\Http\Controllers\ClientController::class, 'restore'])->name('clients.restore')->middleware('can:clients.delete');
    Route::delete('clients/{client}/image', [App\Http\Controllers\ClientController::class, 'destroyImage'])->name('clients.destroyImage')->middleware('can:clients.edit');
    Route::get('clients/{client}/discount', [App\Http\Controllers\ClientController::class, 'getDiscount'])->name('clients.get_discount')->middleware('can:pos.access');

    // Category Routes
    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index')->middleware('can:categories.view');
    Route::get('/categories/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create')->middleware('can:categories.create');
    Route::post('/categories', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store')->middleware('can:categories.create');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit')->middleware('can:categories.edit');
    Route::put('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update')->middleware('can:categories.edit');
    Route::delete('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('can:categories.delete');
    Route::patch('categories/{category}/toggle', [App\Http\Controllers\CategoryController::class, 'toggle'])->name('categories.toggle')->middleware('can:categories.edit');
    Route::delete('categories/{category}/image', [App\Http\Controllers\CategoryController::class, 'destroyImage'])->name('categories.destroyImage')->middleware('can:categories.edit');

    // Supplier Routes
    Route::get('/suppliers', [App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers.index')->middleware('can:suppliers.view');
    Route::get('/suppliers/create', [App\Http\Controllers\SupplierController::class, 'create'])->name('suppliers.create')->middleware('can:suppliers.create');
    Route::post('/suppliers', [App\Http\Controllers\SupplierController::class, 'store'])->name('suppliers.store')->middleware('can:suppliers.create');
    Route::get('/suppliers/{supplier}/edit', [App\Http\Controllers\SupplierController::class, 'edit'])->name('suppliers.edit')->middleware('can:suppliers.edit');
    Route::put('/suppliers/{supplier}', [App\Http\Controllers\SupplierController::class, 'update'])->name('suppliers.update')->middleware('can:suppliers.edit');
    Route::delete('/suppliers/{supplier}', [App\Http\Controllers\SupplierController::class, 'destroy'])->name('suppliers.destroy')->middleware('can:suppliers.delete');
    Route::patch('suppliers/{supplier}/toggle', [App\Http\Controllers\SupplierController::class, 'toggle'])->name('suppliers.toggle')->middleware('can:suppliers.edit');
    Route::delete('suppliers/{supplier}/image', [App\Http\Controllers\SupplierController::class, 'destroyImage'])->name('suppliers.destroyImage')->middleware('can:suppliers.edit');

    // Product Routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('can:products.view');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('can:products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('can:products.create');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('can:products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('can:products.edit');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('can:products.delete');
    Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore')->middleware('can:products.delete');
    Route::delete('products/{product}/image', [ProductController::class, 'destroyImage'])->name('products.destroyImage')->middleware('can:products.edit');

    // Service Routes
    Route::get('services', [ServiceController::class, 'index'])->name('services.index')->middleware('can:services.view');
    Route::get('services/create', [ServiceController::class, 'create'])->name('services.create')->middleware('can:services.create');
    Route::post('services', [ServiceController::class, 'store'])->name('services.store')->middleware('can:services.create');
    Route::get('services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit')->middleware('can:services.edit');
    Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update')->middleware('can:services.edit');
    Route::put('services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggleStatus')->middleware('can:services.edit');
    Route::post('services/{id}/restore', [ServiceController::class, 'restore'])->name('services.restore')->middleware('can:services.delete');
    Route::delete('services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy')->middleware('can:services.delete');

    // Stock Movements Routes
    Route::resource('stock_movements', StockMovementController::class)->except(['show', 'edit', 'update', 'destroy'])->middleware('can:stock_management.access');

    // User Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('can:user_management.view');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('can:user_management.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('can:user_management.create');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('can:user_management.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('can:user_management.edit');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('can:user_management.delete');
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore')->middleware('can:user_management.delete');

    // Stock Alerts Routes
    Route::get('/stock-alerts', [StockAlertController::class, 'index'])->name('stock_alerts.index')->middleware('can:stock_management.access');
    Route::get('/stock-alerts/export-pdf', [StockAlertController::class, 'exportPdf'])->name('stock_alerts.export_pdf')->middleware('can:stock_management.access');
    Route::get('/stock-alerts/pdf-preview', [StockAlertController::class, 'pdfPreview'])->name('stock_alerts.pdf_preview')->middleware('can:stock_management.access');

    // POS Routes
    Route::get('/pos', [App\Http\Controllers\PosController::class, 'index'])->name('pos.index')->middleware('can:pos.access');
    Route::get('/pos/search-products', [App\Http\Controllers\PosController::class, 'searchProducts'])->name('pos.search_products')->middleware('can:pos.access');
    Route::post('/pos/add-product', [App\Http\Controllers\PosController::class, 'addProduct'])->name('pos.add_product')->middleware('can:pos.access');
    Route::post('/pos/complete-sale', [App\Http\Controllers\PosController::class, 'completeSale'])->name('pos.complete_sale')->middleware('can:pos.access');
    Route::post('/pos/check-voucher-folio', [App\Http\Controllers\PosController::class, 'checkVoucherFolio'])->name('pos.check_voucher_folio')->middleware('can:pos.access');
    Route::get('/pos/generate-pdf/{sale}', [App\Http\Controllers\PosController::class, 'generatePdf'])->name('pos.generate_pdf')->middleware('can:pos.access');
    Route::get('/pos/pdf-preview/{sale}', [App\Http\Controllers\PosController::class, 'pdfPreview'])->name('pos.pdf_preview')->middleware('can:pos.access');
    Route::get('/pos/validate-coupon/{couponName}', [App\Http\Controllers\PosController::class, 'validateCoupon'])->name('pos.validate_coupon')->middleware('can:pos.access');

    // Coupon Routes
    Route::resource('coupons', CouponController::class)->except(['show'])->middleware('can:coupons.view');
    Route::post('coupons/{id}/restore', [CouponController::class, 'restore'])->name('coupons.restore')->middleware('can:coupons.delete');
    Route::post('coupons/update-client-discount', [CouponController::class, 'updateClientDiscount'])->name('coupons.update_client_discount')->middleware('can:coupons.edit');
    Route::get('coupons/get-client-discount', [CouponController::class, 'getClientDiscount'])->name('coupons.get_client_discount')->middleware('can:pos.access');

    // Appointment Routes (available for all authenticated users)
    Route::resource('appointments', AppointmentController::class);
    Route::get('appointments/search-clients', [AppointmentController::class, 'searchClients'])->name('appointments.search_clients');
    Route::get('appointments/search-items', [AppointmentController::class, 'searchItems'])->name('appointments.search_items');

    // Sales Management Routes (CRUD)
    Route::get('/sales-history', [App\Http\Controllers\PosController::class, 'salesHistory'])->name('pos.sales_history')->middleware('can:sales_history.view');
    Route::get('/sales-history/export-pdf', [App\Http\Controllers\PosController::class, 'exportAllPdf'])->name('pos.export_all_pdf')->middleware('can:sales_history.view');
    Route::get('/sales-history/pdf-preview', [App\Http\Controllers\PosController::class, 'exportAllPdfPreview'])->name('pos.export_all_pdf_preview')->middleware('can:sales_history.view');
    Route::get('/sales/{sale}', [App\Http\Controllers\PosController::class, 'showSale'])->name('pos.show_sale')->middleware('can:sales_history.view');
    Route::get('/sales/{sale}/edit', [App\Http\Controllers\PosController::class, 'edit'])->name('pos.edit_sale')->middleware('can:sales_history.edit');
    Route::put('/sales/{sale}', [App\Http\Controllers\PosController::class, 'update'])->name('pos.update_sale')->middleware('can:sales_history.edit');
    Route::delete('/sales/{sale}/cancel', [App\Http\Controllers\PosController::class, 'cancelSale'])->name('pos.cancel_sale')->middleware('can:sales_history.cancel');
    Route::post('/sales/{id}/restore', [App\Http\Controllers\PosController::class, 'restore'])->name('pos.restore_sale')->middleware('can:sales_history.delete');
    Route::delete('/sales/{sale}', [App\Http\Controllers\PosController::class, 'destroy'])->name('pos.destroy_sale')->middleware('can:sales_history.delete');

    // Cash Control Routes
    Route::get('/cash-control', [App\Http\Controllers\CashControlController::class, 'index'])->name('cash_control.index')->middleware('can:cash_control.access');
    Route::post('/cash-control/cash-count', [App\Http\Controllers\CashControlController::class, 'cashCount'])->name('cash_control.cash_count')->middleware('can:cash_control.access');
    Route::post('/cash-control/cash-cut', [App\Http\Controllers\CashControlController::class, 'cashCut'])->name('cash_control.cash_cut')->middleware('can:cash_control.access');
    Route::post('/cash-control/cash-cut/{cashCut}/close', [App\Http\Controllers\CashControlController::class, 'closeCashCut'])->name('cash_control.close_cash_cut')->middleware('can:cash_control.access');
    Route::get('/cash-control/reports', [App\Http\Controllers\CashControlController::class, 'reports'])->name('cash_control.reports')->middleware('can:cash_control.access');
    Route::get('/cash-control/reports/pdf', [App\Http\Controllers\CashControlController::class, 'exportReportsPdf'])->name('cash_control.export_reports_pdf')->middleware('can:cash_control.access');
    Route::get('/cash-control/reports/pdf-preview', [App\Http\Controllers\CashControlController::class, 'reportsPdfPreview'])->name('cash_control.reports_pdf_preview')->middleware('can:cash_control.access');
    Route::get('/cash-control/cash-counts', [App\Http\Controllers\CashControlController::class, 'cashCountsHistory'])->name('cash_control.cash_counts')->middleware('can:cash_control.access');
    Route::get('/cash-control/cash-counts/{cashCount}', [App\Http\Controllers\CashControlController::class, 'showCashCount'])->name('cash_control.show_cash_count')->middleware('can:cash_control.access');
    Route::get('/cash-control/cash-counts/{cashCount}/pdf', [App\Http\Controllers\CashControlController::class, 'generateCashCountPdf'])->name('cash_control.generate_cash_count_pdf')->middleware('can:cash_control.access');
    Route::get('/cash-control/cash-counts/{cashCount}/pdf-preview', [App\Http\Controllers\CashControlController::class, 'cashCountPdfPreview'])->name('cash_control.cash_count_pdf_preview')->middleware('can:cash_control.access');
    Route::get('/cash-control/cash-cuts', [App\Http\Controllers\CashControlController::class, 'cashCutsHistory'])->name('cash_control.cash_cuts')->middleware('can:cash_control.access');
    Route::get('/cash-control/cash-cuts/{cashCut}', [App\Http\Controllers\CashControlController::class, 'showCashCut'])->name('cash_control.show_cash_cut')->middleware('can:cash_control.access');
    Route::get('/cash-control/cash-cuts/{cashCut}/pdf', [App\Http\Controllers\CashControlController::class, 'generateCashCutPdf'])->name('cash_control.generate_cash_cut_pdf')->middleware('can:cash_control.access');
    Route::get('/cash-control/cash-cuts/{cashCut}/pdf-preview', [CashControlController::class, 'cashCutPdfPreview'])->name('cash_control.cash_cut_pdf_preview')->middleware('can:cash_control.access');
    Route::get('/cash-control/movement', [CashControlController::class, 'showCashMovementForm'])->name('cash_control.movement_form')->middleware('can:cash_control.access');
    Route::post('/cash-control/withdrawal', [CashControlController::class, 'processCashWithdrawal'])->name('cash_control.process_withdrawal')->middleware('can:cash_control.access');
    Route::post('/cash-control/deposit', [CashControlController::class, 'processCashDeposit'])->name('cash_control.process_deposit')->middleware('can:cash_control.access');

    // Database Management Routes
    Route::get('/database', [App\Http\Controllers\DatabaseController::class, 'index'])->name('database.index')->middleware('can:database.access');
    Route::get('/database/backup', [App\Http\Controllers\DatabaseController::class, 'backupForm'])->name('database.backup_form')->middleware('can:database.access');
    Route::post('/database/backup', [App\Http\Controllers\DatabaseController::class, 'createBackup'])->name('database.create_backup')->middleware('can:database.access');
    Route::get('/database/restore', [App\Http\Controllers\DatabaseController::class, 'restoreForm'])->name('database.restore_form')->middleware('can:database.access');
    Route::post('/database/restore/process', [App\Http\Controllers\DatabaseController::class, 'processBackupFile'])->name('database.restore_process')->middleware('can:database.access');
    Route::post('/database/restore/process-server', [App\Http\Controllers\DatabaseController::class, 'processServerBackupFile'])->name('database.restore_process_server')->middleware('can:database.access');
    Route::get('/database/restore/process-csv', [App\Http\Controllers\DatabaseController::class, 'processCsvBackup'])->name('database.restore_process_csv_get')->middleware('can:database.access');
    Route::post('/database/restore/process-csv', [App\Http\Controllers\DatabaseController::class, 'processCsvBackup'])->name('database.restore_process_csv')->middleware('can:database.access');
    Route::get('/database/restore/show-content', [App\Http\Controllers\DatabaseController::class, 'showServerBackupContent'])->name('database.restore_show_content')->middleware('can:database.access');
    Route::post('/database/restore/show-content', [App\Http\Controllers\DatabaseController::class, 'showServerBackupContent'])->name('database.restore_show_content_post')->middleware('can:database.access');
    Route::post('/database/restore', [App\Http\Controllers\DatabaseController::class, 'restoreBackup'])->name('database.restore_backup')->middleware('can:database.access');
    Route::post('/database/restore-csv', [App\Http\Controllers\DatabaseController::class, 'restoreCsvBackup'])->name('database.restore_csv_backup')->middleware('can:database.access');
    Route::post('/database/preview-sql-content', [App\Http\Controllers\DatabaseController::class, 'previewSqlContent'])->name('database.preview_sql_content')->middleware('can:database.access');
    Route::post('/database/preview-csv-content', [App\Http\Controllers\DatabaseController::class, 'previewCsvContent'])->name('database.preview_csv_content')->middleware('can:database.access');
    Route::get('/database/delete', [App\Http\Controllers\DatabaseController::class, 'deleteForm'])->name('database.delete_form')->middleware('can:database.access');
    Route::post('/database/delete', [App\Http\Controllers\DatabaseController::class, 'deleteDatabase'])->name('database.delete_database')->middleware('can:database.access');
    Route::get('/database/test-csv', [App\Http\Controllers\DatabaseController::class, 'testCsvFunctionality'])->name('database.test_csv')->middleware('can:database.access');
    Route::post('/database/restore-csv-simple', [App\Http\Controllers\DatabaseController::class, 'restoreCsvSimple'])->name('database.restore_csv_simple')->middleware('can:database.access');

    // Cash Session Routes
    Route::get('/cash-sessions/start', [App\Http\Controllers\CashSessionController::class, 'startForm'])->name('cash_sessions.start_form')->middleware('can:cash_control.access');
    Route::post('/cash-sessions/start', [App\Http\Controllers\CashSessionController::class, 'start'])->name('cash_sessions.start')->middleware('can:cash_control.access');
    Route::get('/cash-sessions/{cashSession}', [App\Http\Controllers\CashSessionController::class, 'show'])->name('cash_sessions.show')->middleware('can:cash_control.access');
    Route::post('/cash-sessions/{cashSession}/close', [App\Http\Controllers\CashSessionController::class, 'close'])->name('cash_sessions.close')->middleware('can:cash_control.access');
    Route::post('/cash-sessions/close-active', [App\Http\Controllers\CashSessionController::class, 'closeActive'])->name('cash_sessions.close_active')->middleware('can:cash_control.access');
    Route::post('/cash-sessions/check-active-session', [App\Http\Controllers\CashSessionController::class, 'checkActiveSessionAjax'])->name('cash_sessions.check_active_session')->middleware('can:cash_control.access');
    Route::get('/cash-sessions/{cashSession}/report', [App\Http\Controllers\CashSessionController::class, 'report'])->name('cash_sessions.report')->middleware('can:cash_control.access');
    Route::get('/cash-sessions', [App\Http\Controllers\CashSessionController::class, 'index'])->name('cash_sessions.index')->middleware('can:cash_control.access');
    Route::post('/cash-sessions/{cashSession}/admin-force-close', [App\Http\Controllers\CashSessionController::class, 'adminForceClose'])->name('cash_sessions.admin_force_close')->middleware('can:user_management.edit');
    Route::get('/cash-sessions/{cashSession}/admin-close', [App\Http\Controllers\CashSessionController::class, 'adminClose'])->name('cash_sessions.admin_close')->middleware('can:user_management.edit');

    // Historical Sales Routes
    Route::middleware(['can:sales_history.view'])->group(function () {

    });

    // Settings Routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index')->middleware('can:user_management.view'); // Assuming admin access
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update')->middleware('can:user_management.edit');
    Route::get('/settings/suggest-colors', [SettingsController::class, 'suggestColors'])->name('settings.suggest_colors');
    Route::get('/settings/suggest-fonts', [SettingsController::class, 'suggestFonts'])->name('settings.suggest_fonts');

    // Admin Role Management Route
    Route::get('/admin/role-management', function () {
        $roleCounts = [
            'admin' => \App\Models\User::where('role', 'admin')->count(),
            'supervisor' => \App\Models\User::where('role', 'supervisor')->count(),
            'empleado' => \App\Models\User::where('role', 'empleado')->count(),
        ];
        return view('admin.role-management', compact('roleCounts'));
    })->name('admin.role_management')->middleware('can:user_management.view');

    // Manual Routes
    Route::get('/manual', [ManualController::class, 'index'])->name('manual.index');
    Route::get('/manual/{type}', [ManualController::class, 'show'])->name('manual.show');

});

require __DIR__.'/auth.php';
