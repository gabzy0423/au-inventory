<?php

/**
 * --------------------------------------------------------------------------
 * Web Routes
 * --------------------------------------------------------------------------
 * 
 * Here is where you can register web routes for your application.
 * You can map URLs to specific controller methods.
 * 
 */

// Define the router instance (injected from index.php)
/** @var \App\Core\Router $router */

$router->get('/', 'Auth\LoginController@index');
$router->post('/login', 'Auth\LoginController@store');
$router->get('/logout', 'Auth\LogoutController@destroy');

// Admin Routes
$router->get('/admin/dashboard', 'Admin\DashboardController@index');
$router->get('/admin/inventory', 'Admin\InventoryController@index');
$router->get('/admin/inventory/create', 'Admin\InventoryController@create');
$router->get('/admin/inventory/edit', 'Admin\InventoryController@updateLookup');
$router->get('/admin/inventory/edit/:id', 'Admin\InventoryController@edit');
$router->get('/admin/inventory/archive', 'Admin\InventoryController@archivePage');
$router->post('/admin/inventory', 'Admin\InventoryController@store');
$router->post('/admin/inventory/update/:id', 'Admin\InventoryController@update');
$router->post('/admin/inventory/bulk-edit', 'Admin\InventoryController@bulkEdit');
$router->post('/admin/inventory/bulk-update', 'Admin\InventoryController@bulkUpdate');
$router->post('/admin/inventory/archive/:id', 'Admin\InventoryController@archive');
$router->get('/admin/inventory/show/:id', 'Admin\InventoryController@show');
$router->get('/admin/inventory/api/:id', 'Admin\InventoryController@apiDetail');
$router->get('/admin/inventory/archived-api', 'Admin\InventoryController@apiArchived');
$router->post('/admin/inventory/restore/:id', 'Admin\InventoryController@restore');
$router->get('/admin/categories', 'Admin\CategoryController@index');
$router->get('/admin/categories/create', 'Admin\CategoryController@create');
$router->get('/admin/categories/edit/:id', 'Admin\CategoryController@edit');
$router->get('/admin/categories/show/:id', 'Admin\CategoryController@show');
$router->get('/admin/categories/archive', 'Admin\CategoryController@archivePage');
$router->post('/admin/categories', 'Admin\CategoryController@store');
$router->post('/admin/categories/update/:id', 'Admin\CategoryController@update');
$router->post('/admin/categories/archive/:id', 'Admin\CategoryController@archive');
$router->post('/admin/categories/restore/:id', 'Admin\CategoryController@restore');
$router->get('/admin/categories/archived-api', 'Admin\CategoryController@apiArchived');
$router->get('/admin/categories/assets/:id', 'Admin\CategoryController@apiAssets');

$router->get('/admin/rooms', 'Admin\RoomController@index');
$router->get('/admin/rooms/create', 'Admin\RoomController@create');
$router->get('/admin/rooms/edit/:id', 'Admin\RoomController@edit');
$router->get('/admin/rooms/archive', 'Admin\RoomController@archivePage');
$router->post('/admin/rooms', 'Admin\RoomController@store');
$router->post('/admin/rooms/update/:id', 'Admin\RoomController@update');
$router->post('/admin/rooms/archive/:id', 'Admin\RoomController@archive');
$router->post('/admin/rooms/restore/:id', 'Admin\RoomController@restore');
$router->get('/admin/rooms/archived-api', 'Admin\RoomController@apiArchived');
$router->get('/admin/rooms/assets/:id', 'Admin\RoomController@apiAssets');


$router->get('/admin/maintenance', 'Admin\ReportController@maintenance');
$router->get('/admin/reports', 'Admin\ReportController@index');
$router->get('/admin/reports/show/:id', 'Admin\ReportController@show');
$router->get('/admin/reports/resolved', 'Admin\ReportController@resolved');
$router->get('/admin/reports/vault', 'Admin\ReportController@vault');
$router->post('/admin/report/fix/:id', 'Admin\ReportController@fix');
$router->post('/admin/report/resolve/:id', 'Admin\ReportController@resolve');
$router->post('/admin/report/approve/:id', 'Admin\ReportController@approve');
$router->post('/admin/report/start/:id', 'Admin\ReportController@start');
$router->get('/admin/report/create/:id', 'Admin\ReportController@create');
$router->post('/admin/report/store', 'Admin\ReportController@store');
$router->post('/admin/report/merge', 'Admin\ReportController@merge');
$router->get('/admin/report/export', 'Admin\ReportController@export');


$router->get('/admin/users', 'Admin\UserController@index');
$router->get('/admin/users/create', 'Admin\UserController@create');
$router->get('/admin/users/show/:id', 'Admin\UserController@show');
$router->get('/admin/users/edit/:id', 'Admin\UserController@edit');
$router->get('/admin/users/archive', 'Admin\UserController@archivePage');
$router->post('/admin/users', 'Admin\UserController@store');
$router->post('/admin/users/update/:id', 'Admin\UserController@update');
$router->post('/admin/users/archive/:id', 'Admin\UserController@archive');
$router->post('/admin/users/restore/:id', 'Admin\UserController@restore');
$router->get('/admin/users/archived-api', 'Admin\UserController@apiArchived');
$router->get('/admin/users/api/:id', 'Admin\UserController@apiDetail');

$router->get('/admin/profile', 'Admin\ProfileController@index');
$router->post('/admin/profile/update', 'Admin\ProfileController@update');

// Admin Notification Routes
$router->get('/admin/notifications', 'Admin\NotificationController@index');
$router->post('/admin/notifications/read/:id', 'Admin\NotificationController@markRead');
$router->post('/admin/notifications/read-all', 'Admin\NotificationController@markAllRead');

// Staff Routes
$router->get('/staff/dashboard', 'Staff\DashboardController@index');
$router->get('/staff/profile', 'Staff\ProfileController@index');
$router->post('/staff/profile/update', 'Staff\ProfileController@update');
$router->get('/staff/inventory', 'Staff\InventoryController@index');
$router->get('/staff/inventory/api/:id', 'Staff\InventoryController@apiDetail');
$router->get('/staff/inventory/show/:id', 'Staff\InventoryController@show');
$router->get('/staff/qrscanner', 'Staff\QrScannerController@index');
$router->get('/staff/qrscanner/lookup', 'Staff\QrScannerController@lookup');
$router->get('/staff/rooms', 'Staff\RoomController@index');
$router->get('/staff/rooms/assets/:id', 'Staff\RoomController@apiAssets');
$router->get('/staff/maintenance', 'Staff\ReportController@maintenance');
$router->get('/staff/reports', 'Staff\ReportController@index');
$router->get('/staff/reports/vault', 'Staff\ReportController@vault');
$router->get('/staff/reports/public', 'Staff\ReportController@publicLogs');
$router->post('/staff/report/fix/:id', 'Staff\ReportController@fix');
$router->post('/staff/report/resolve/:id', 'Staff\ReportController@resolve');
$router->get('/staff/report/create', 'Staff\ReportController@create');
$router->get('/staff/report/create/:id', 'Staff\ReportController@create');
$router->post('/staff/report/store', 'Staff\ReportController@store');

// Staff Notification Routes
$router->get('/staff/notifications', 'Staff\NotificationController@index');
$router->post('/staff/notifications/read/:id', 'Staff\NotificationController@markRead');
$router->post('/staff/notifications/read-all', 'Staff\NotificationController@markAllRead');
$router->get('/staff/borrow', 'Staff\BorrowRequestController@index');

// API Routes
$router->get('/api/reports/check-duplicate', 'Staff\ReportController@checkDuplicate');
