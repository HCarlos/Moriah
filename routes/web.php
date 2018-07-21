<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home_alumno', 'HomeController@index_alumno')->name('home_alumno');
Route::get('/imagenes/{root}/{archivo}', 'Funciones\FuncionesController@showFile')->name('callFile/');

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');
//$this->post('register', 'Auth\RegisterController@register');

Route::group(['middleware' => 'auth'], function () {

// Password Reset Routes...

/*
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');
*/

    Route::get('edit', 'Auth\EditUserDataController@showEditUserData')->name('edit');
    Route::put('Edit', 'Auth\EditUserDataController@update')->name('Edit');
    Route::get('showEditProfilePhoto/', 'Auth\EditUserDataController@showEditProfilePhoto')->name('showEditProfilePhoto/');
    Route::get('showEditProfileEmail/', 'Auth\EditUserDataController@showEditProfileEmail')->name('showEditProfileEmail/');
    Route::put('changeEmailUser/', 'Auth\EditUserDataController@changeEmailUser')->name('changeEmailUser/');

    Route::post('subirFotoProfile/', 'Storage\StorageProfileController@subirArchivoProfile')->name('subirArchivoProfile/');
    Route::get('quitarFotoProfile/', 'Storage\StorageProfileController@quitarArchivoProfile')->name('quitarArchivoProfile/');

    Route::get('/index/{id}/{npage}/{tpaginas}/','Catalogos\CatalogosListController@index')->name('listItem');
    Route::post('/catalogo/search/','Catalogos\CatalogosListController@indexSearch')->name('listItemSearch');

    Route::get('catalogos/{id}/{idItem}/{action}', 'Catalogos\CatalogosController@index')->name('catalogos/');
    Route::get('catalogos/ficha-clone/{id}/{idItem}/{action}', 'Catalogos\CatalogosController@clone')->name('catalogosFichasClone/');
    Route::get('catalogos/subir-imagen-ficha/{id}/{idItem}/{action}', 'Catalogos\CatalogosController@subirImagen')->name('catalogosSubirImagenFichas/');

//        Route::get('/catajax/{id}', 'Catalogos\CatalogosListController@ajaxIndex')->name('ajaxIndexCatList');

    // Empresas
    Route::get('/index_empresa/{npage}/{tpaginas}','SIIFAC\EmpresaController@index')->name('empresaIndex');
    Route::get('/new_empresa/{idItem}', 'SIIFAC\EmpresaController@new')->name('empresaNew');
    Route::get('/edit_empresa/{idItem}', 'SIIFAC\EmpresaController@edit')->name('empresaEdit');
    Route::post('/store_empresa','SIIFAC\EmpresaController@store')->name('empresaStore/');
    Route::put('/update_empresa/{emp}','SIIFAC\EmpresaController@update')->name('empresaUpdate/');
    Route::get('/destroy_empresa/{id}', 'SIIFAC\EmpresaController@destroy')->name('empresaDestroy/');

    // Almacenes
    Route::get('/index_almacen/{npage}/{tpaginas}','SIIFAC\AlmacenController@index')->name('almacenIndex');
    Route::get('/new_almacen/{idItem}', 'SIIFAC\AlmacenController@new')->name('almacenNew');
    Route::get('/edit_almacen/{idItem}', 'SIIFAC\AlmacenController@edit')->name('almacenEdit');
    Route::post('/store_almacen','SIIFAC\AlmacenController@store')->name('almacenStore/');
    Route::put('/update_almacen/{alma}','SIIFAC\AlmacenController@update')->name('almacenUpdate/');
    Route::get('/destroy_almacen/{id}', 'SIIFAC\AlmacenController@destroy')->name('almacenDestroy/');

    // Productos
    Route::get('/index_producto/{npage}/{tpaginas}','SIIFAC\ProductoController@index')->name('productoIndex');
    Route::get('/new_producto/{idItem}', 'SIIFAC\ProductoController@new')->name('productoNew');
    Route::get('/edit_producto/{idItem}', 'SIIFAC\ProductoController@edit')->name('productoEdit');
    Route::post('/store_producto','SIIFAC\ProductoController@store')->name('productoStore/');
    Route::put('/update_producto/{prod}','SIIFAC\ProductoController@update')->name('productoUpdate/');
    Route::get('/destroy_producto/{id}', 'SIIFAC\ProductoController@destroy')->name('productoDestroy/');
    Route::get('/imagen_producto/{idItem}', 'SIIFAC\ProductoController@imagen')->name('productoImagen');
    Route::post('/subir_imagen_producto/{oProducto}','Storage\StorageProductoController@subirArchivoProducto')->name('storageProductoUpload/');
    Route::get('/quitar_imagen_producto/{idItem}','Storage\StorageProductoController@quitarArchivoProducto')->name('storageProductoRemove/');
    Route::get('/actualizar_inventario', 'SIIFAC\ProductoController@actualizar_inventario')->name('actualizarInventario');
    Route::get('/imprimir_existencias/', 'Externos\ExistenciasController@imprimir_existencias')->name('imprimirExistencias/');
    Route::get('/tarjeta_movtos_prod/{producto_id}', 'Externos\TarjetaMovtosController@imprimir_tarjeta_movtos')->name('imprimirTarjetasMovto/');

    // Paquetes
    Route::get('/index_paquete/{npage}/{tpaginas}','SIIFAC\PaqueteController@index')->name('paqueteIndex');
    Route::get('/new_paquete/{idItem}', 'SIIFAC\PaqueteController@new')->name('paqueteNew');
    Route::get('/edit_paquete/{idItem}', 'SIIFAC\PaqueteController@edit')->name('paqueteEdit');
    Route::post('/store_paquete','SIIFAC\PaqueteController@store')->name('paqueteStore/');
    Route::put('/update_paquete/{paq}','SIIFAC\PaqueteController@update')->name('paqueteUpdate/');
    Route::get('/destroy_paquete/{id}', 'SIIFAC\PaqueteController@destroy')->name('paqueteDestroy/');
    Route::get('/imagen_paquete/{idItem}', 'SIIFAC\PaqueteController@imagen')->name('paqueteImagen');
    Route::post('/subir_imagen_paquete/{oPaquete}','Storage\StoragePaqueteController@subirArchivoPaquete')->name('storagePaqueteUpload/');
    Route::get('/quitar_imagen_paquete/{idItem}','Storage\StoragePaqueteController@quitarArchivoPaquete')->name('storagePaqueteRemove/');

    // Paquete Detalles
    Route::get('/index_paquete_detalle/{npage}/{tpaginas}/{id}','SIIFAC\PaqueteDetalleController@index')->name('paqueteDetalleIndex');
    Route::get('/new_paquete_detalle_ajax/{paquete_id}/{paquete_detalle_id}', 'SIIFAC\PaqueteDetalleController@new_ajax')->name('paqueteDetalleNewAjax');
    Route::post('/store_paquete_detalle_ajax','SIIFAC\PaqueteDetalleController@store_ajax')->name('paqueteDetalleStoreAjax/');
    Route::get('/edit_paquete_detalle_ajax/{paquete_id}/{paquete_detalle_id}', 'SIIFAC\PaqueteDetalleController@edit_ajax')->name('paqueteDetalleEditAjax');
    Route::put('/update_paquete_detalle_ajax','SIIFAC\PaqueteDetalleController@update_ajax')->name('paqueteDetalleUpdateAjax/');
    Route::get('/destroy_paquete_detalle/{id}', 'SIIFAC\PaqueteDetalleController@destroy')->name('paqueteDetalleDestroy/');

    // Pedidos
    Route::get('/index_pedido/{npage}/{tpaginas}','SIIFAC\PedidoController@index')->name('pedidoIndex');
    Route::get('/new_pedido/{idItem}', 'SIIFAC\PedidoController@new')->name('pedidoNew');
    Route::post('/store_pedido','SIIFAC\PedidoController@store')->name('pedidoStore/');
    Route::get('/destroy_pedido/{id}', 'SIIFAC\PedidoController@destroy')->name('pedidoDestroy/');

    // Pedido Detalles
    Route::get('/index_pedido_detalle/{npage}/{tpaginas}/{id}','SIIFAC\PedidoDetalleController@index')->name('pedidoDetalleIndex');
    Route::get('/new_pedido_detalle_ajax/{pedido_id}/{pedido_detalle_id}', 'SIIFAC\PedidoDetalleController@new_ajax')->name('pedidoDetalleNewAjax');
    Route::post('/store_pedido_detalle_ajax','SIIFAC\PedidoDetalleController@store_ajax')->name('pedidoDetalleStoreAjax/');
    Route::get('/destroy_pedido_detalle/{id}', 'SIIFAC\PedidoDetalleController@destroy')->name('pedidoDetalleDestroy/');

    // Ventas
    Route::get('/index_ventas/{fecha}','SIIFAC\VentaController@index')->name('ventasIndex');
    Route::post('/index_ventas','SIIFAC\VentaController@index_post')->name('ventasPostIndex');
    Route::get('/select_paquete_ajax', 'SIIFAC\VentaController@new_paquete_ajax')->name('selectPaqueteNewAjax/');
    Route::get('/select_pedido_ajax', 'SIIFAC\VentaController@new_pedido_ajax')->name('selectPedidoNewAjax/');
    Route::get('/select_normal_ajax', 'SIIFAC\VentaController@new_normal_ajax')->name('selectPedidoNewAjax/');
    Route::post('/store_venta_paquete_ajax','SIIFAC\VentaController@store_paquete_ajax')->name('ventaPaqueteStoreAjax/');
    Route::post('/store_venta_pedido_ajax','SIIFAC\VentaController@store_pedido_ajax')->name('ventaPedidoStoreAjax/');
    Route::post('/store_venta_normal_ajax','SIIFAC\VentaController@store_normal_ajax')->name('ventaNormalStoreAjax/');
    Route::get('/edit_venta_detalle/{venta_id}', 'SIIFAC\VentaController@edit')->name('ventaDetalleEdit');
    Route::get('/destroy_venta/{id}', 'SIIFAC\VentaController@destroy')->name('ventaDestroy/');
    Route::get('/form_pagar_venta/{venta_id}', 'SIIFAC\VentaController@call_pagar_venta_ajax')->name('callPagarVentaAjax/');
    Route::post('/pagar_venta_ajax','SIIFAC\VentaController@pagar_venta_ajax')->name('pagarVentaAjax/');

    // Venta_Detalles
    Route::get('/destroy_ventadetalle/{id}', 'SIIFAC\VentaDetalleController@destroy')->name('ventaDetalleDestroy/');
    Route::get('/form_venta_detalle_nueva_ajax/{venta_id}', 'SIIFAC\VentaDetalleController@new_venta_detalle_ajax')->name('selectVentaDetalleNewAjax/');
    Route::post('/store_venta_detalle_normal_ajax','SIIFAC\VentaDetalleController@store_normal_ajax')->name('ventaDetalleNormalAjax/');
//    Route::get('/excel/1','SIIFAC\ExcelController@toexcel')->name('toExcelTest/');
    Route::get('/print_venta_detalle/{venta_id}', 'Externos\TicketController@print_tiket')->name('printTicket/');


    // Compras
    Route::get('/index_compra/','SIIFAC\CompraController@index')->name('compraIndex');
    Route::get('/form_compra_nueva_ajax/','SIIFAC\CompraController@nueva_compra_ajax')->name('formCompraNuevaAjax');
    Route::post('/store_compra_nueva_ajax','SIIFAC\CompraController@store_compra_nueva_ajax')->name('compraNuevaAjax/');
    Route::get('/form_compra_editar_ajax/{compra_id}','SIIFAC\CompraController@editar_compra_ajax')->name('formCompraEditarAjax');
    Route::put('/store_compra_editada_ajax','SIIFAC\CompraController@store_compra_editada_ajax')->name('compraEditadaAjax/');
    Route::get('/destroy_compra/{id}', 'SIIFAC\CompraController@destroy')->name('compraDestroy/');

    // Compra Detalless
    Route::get('/index_compra_detalle_ajax/{compra_id}','SIIFAC\CompraDetalleController@index')->name('compraDetalleIndex');
    Route::get('/form_compra_detalle_nueva_ajax/{compra_id}', 'SIIFAC\CompraDetalleController@new_compra_detalle_ajax')->name('selectCompraDetalleNewAjax/');
    Route::post('/store_compra_detalle_ajax','SIIFAC\CompraDetalleController@store_compra_detalle_ajax')->name('compraDetalleAjax/');
    Route::get('/destroy_compra_detalle/{id}', 'SIIFAC\CompraDetalleController@destroy')->name('compraDetalleDestroy/');

    // Usuarios
    Route::get('/index_usuario/{npage}/{tpaginas}','SIIFAC\UsuarioController@index')->name('usuarioIndex');
    Route::get('/new_usuario/{idItem}', 'SIIFAC\UsuarioController@new')->name('usuarioNew');
    Route::get('/edit_usuario/{idItem}', 'SIIFAC\UsuarioController@edit')->name('usuarioEdit');
    Route::post('/store_usuario','SIIFAC\UsuarioController@store')->name('usuarioStore/');
    Route::put('/update_usuario/{user}','SIIFAC\UsuarioController@update')->name('usuarioUpdate/');
    Route::get('/destroy_usuario/{id}', 'SIIFAC\UsuarioController@destroy')->name('usuarioDestroy/');

    // Roles
    Route::post('/create_role','Catalogos\RoleController@create')->name('roleCreate/');
    Route::put('/update_role/{rol}','Catalogos\RoleController@update')->name('roleUpdate/');
    Route::get('/destroy_role/{id}/{idItem}/{action}', 'Catalogos\RoleController@destroy')->name('roleDestroy/');

    // Permissions
    Route::post('/create_permission','Catalogos\PermissionController@create')->name('permissionCreate/');
    Route::put('/update_permission/{perm}','Catalogos\PermissionController@update')->name('permissionUpdate/');
    Route::get('/destroy_permission/{id}/{idItem}/{action}', 'Catalogos\PermissionController@destroy')->name('permissionDestroy/');

    // Asignaciones Roles -> Usuarios
    Route::get('/list_left_config/{ida}/{iduser}/','Asignaciones\AsignacionListController@index')->name('asignItem/');
    Route::get('/asign_role_user/{idUser}/{nameRoles}/{cat_id}','Asignaciones\RoleUsuarioController@asignar')->name('assignRoleToUser/');
    Route::get('/unasign_role_user/{idUser}/{nameRoles}/{cat_id}','Asignaciones\RoleUsuarioController@desasignar')->name('unAssignRoleToUser/');

    // Asignaciones Permissions -> Roles
    Route::get('/asign_permission_role/{idRole}/{namePermissions}/{cat_id}','Asignaciones\PermisoRoleController@asignar')->name('assignPermissionToRole/');
    Route::get('/unasign_permission_role/{idRole}/{namePermissions}/{cat_id}','Asignaciones\PermisoRoleController@desasignar')->name('unAssignPermissionToRole/');

//    Route::resource('excel','Externos\ExcelController');

    Route::get('producto/existencias-excel','Externos\ExcelController@show')->name('productoExistenciaList');
    Route::get('archivos-config','Externos\ExcelController@archivos_config')->name('archivosConfig/');
    Route::post('subirArchivoBase/', 'Storage\StorageExternosController@subirArchivoBase')->name('subirArchivoBase/');
    Route::get('quitarArchivoBase/{driver}/{archivo}', 'Storage\StorageExternosController@quitarArchivoBase')->name('quitarArchivoBase/');
//    Route::get('storage/excel/{filename}',function () {
//        return view('/home');
//    });



});

Route::get('/admin', function () {
    return view('/admin/dashboard');
})->name('dashboard')->middleware(['auth', 'admin']);
