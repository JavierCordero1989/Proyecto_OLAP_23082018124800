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
  return redirect('home');
});


Auth::routes();

Route::get('/home', 'HomeController@index');

//Rutas para los roles
Route::group(['middleware'=>['auth']], function() {
  Route::get('roles', 'RolesController@index')          ->name('roles.index')   ->middleware('permission:roles.index');
  Route::get('roles/create', 'RolesController@create')  ->name('roles.create')  ->middleware('permission:roles.create');;
  Route::post('roles/store', 'RolesController@store')   ->name('roles.store')   ->middleware('permission:roles.store');;
  Route::get('roles/{id}', 'RolesController@show')      ->name('roles.show')    ->middleware('permission:roles.show');;
  Route::get('roles/{id}/edit', 'RolesController@edit') ->name('roles.edit')    ->middleware('permission:roles.edit');;
  Route::patch('roles/{id}', 'RolesController@update')  ->name('roles.update')  ->middleware('permission:roles.update');;
  Route::delete('roles/{id}', 'RolesController@destroy')->name('roles.destroy') ->middleware('permission:roles.destroy');;
});

//Rutas para los permisos
Route::group(['middleware'=>['auth']], function() {
  Route::get('permisos', 'PermissionsController@index')          ->name('permisos.index')  ->middleware('permission:permisos.index');
  Route::get('permisos/create', 'PermissionsController@create')  ->name('permisos.create') ->middleware('permission:permisos.create');
  Route::post('permisos/store', 'PermissionsController@store')   ->name('permisos.store')  ->middleware('permission:permisos.store');
  Route::get('permisos/{id}', 'PermissionsController@show')      ->name('permisos.show')   ->middleware('permission:permisos.show');
  Route::get('permisos/{id}/edit', 'PermissionsController@edit') ->name('permisos.edit')   ->middleware('permission:permisos.edit');
  Route::patch('permisos/{id}', 'PermissionsController@update')  ->name('permisos.update') ->middleware('permission:permisos.update');
  Route::delete('permisos/{id}', 'PermissionsController@destroy')->name('permisos.destroy')->middleware('permission:permisos.destroy');
});

//Rutas para los usuarios
Route::group(['middleware'=>['auth']], function() {
  Route::get('users', 'UserController@index')          ->name('users.index')  ->middleware('permission:users.index');
  Route::get('users/create', 'UserController@create')  ->name('users.create') ->middleware('permission:users.create');
  Route::post('users/store', 'UserController@store')   ->name('users.store')  ->middleware('permission:users.store');
  Route::get('users/{id}', 'UserController@show')      ->name('users.show')   ->middleware('permission:users.show');
  Route::get('users/{id}/edit', 'UserController@edit') ->name('users.edit')   ->middleware('permission:users.edit');
  Route::patch('users/{id}', 'UserController@update')  ->name('users.update') ->middleware('permission:users.update');
  Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy')->middleware('permission:users.destroy');
  
  Route::get('users/edit-name/{id}', 'UserController@edit_name')->name('users.edit_name')                     ->middleware('permission:users.edit_name');
  Route::patch('users/update-name/{id}', 'UserController@update_name')->name('users.update_name')             ->middleware('permission:users.update_name');
  Route::get('users/edit-password/{id}', 'UserController@edit_password')->name('users.edit_password')         ->middleware('permission:users.edit_password');
  Route::patch('users/update-password/{id}', 'UserController@update_password')->name('users.update_password') ->middleware('permission:users.update_password');
  Route::get('usuarios', 'UserController@index_table')->name('usuarios.index_table')                          ->middleware('permission:users.index_table');
});

Route::get('asignar-permisos-a-rol/create', 'AssignPermissionsToRolController@create')->name('permissionsToRol.create') ->middleware('permission:permissionsToRol.create');
Route::post('asignar-permisos-a-rol/store', 'AssignPermissionsToRolController@store') ->name('permissionsToRol.store')  ->middleware('permission:permissionsToRol.store');

Route::get('asignar-roles-a-usuario/create', 'AssignRolesToUserController@create')->name('rolesToUser.create')->middleware('permission:rolesToUser.create');
Route::post('asignar-roles-a-usuario/store', 'AssignRolesToUserController@store') ->name('rolesToUser.store') ->middleware('permission:rolesToUser.store');

Route::post('importar-excel-bd/importar', 'ExportImportExcelController@importar_desde_excel')->name('excel.import');
Route::get('importar-excel-bd/create', 'ExportImportExcelController@create')->name('excel.create')->middleware(['role:Super Admin', 'permission:excel.create']);

//Encuestadores
Route::group(['middleware'=>['auth']], function() {
    Route::get('encuestadores', 'EncuestadoresController@index')          ->name('encuestadores.index')  /*->middleware('permission:')*/;
    Route::get('encuestadores/create', 'EncuestadoresController@create')  ->name('encuestadores.create') /*->middleware('')*/;
    Route::post('encuestadores/store', 'EncuestadoresController@store')   ->name('encuestadores.store')  /*->middleware('')*/;
    Route::get('encuestadores/{id}', 'EncuestadoresController@show')      ->name('encuestadores.show')   /*->middleware('')*/;
    Route::get('encuestadores/{id}/edit', 'EncuestadoresController@edit') ->name('encuestadores.edit')   /*->middleware('')*/;
    Route::patch('encuestadores/{id}', 'EncuestadoresController@update')  ->name('encuestadores.update') /*->middleware('')*/;
    Route::delete('encuestadores/{id}', 'EncuestadoresController@destroy')->name('encuestadores.destroy')/*->middleware('')*/;
    Route::get('cambiar-contrasennia-encuestador/{id_encuestador}/cambiar', 'EncuestadoresController@cambiar_contrasennia')->name('encuestadores.cambiar-contrasennia');
    Route::patch('cambiar-contrasennia-encuestador/{id_encuestador}', 'EncuestadoresController@actualizar_contrasennia')->name('encuestadores.actualizar-contrasennia');
    Route::get('lista-encuestas/{id}', 'EncuestadoresController@lista_de_encuestas')->name('encuestadores.lista-de-encuestas');
    Route::get('agregar-contacto-encuestador/{id_encuesta}', 'EncuestadoresController@agregarContacto')->name('encuestadores.agregar-contacto');
    Route::post('agregar-contacto-encuestador/guardar/{id_encuesta}/{id_encuestador}', 'EncuestadoresController@guardarContacto')->name('encuestadores.guardar-contacto');
    Route::get('modificar-contacto/{id_contacto}/editar', 'EncuestadoresController@editarContacto')->name('encuestadores.modificar-contacto');
    Route::patch('modificar-contacto/{id_contacto}', 'EncuestadoresController@actualizarContacto')->name('encuestadores.actualizar-contacto');
});

//Supervisores
Route::group(['middleware'=>['auth']], function() {
  Route::get('supervisores', 'SupervisoresController@index')          ->name('supervisores.index')  /*->middleware('permission:')*/;
  Route::get('supervisores/create', 'SupervisoresController@create')  ->name('supervisores.create') /*->middleware('')*/;
  Route::post('supervisores/store', 'SupervisoresController@store')   ->name('supervisores.store')  /*->middleware('')*/;
  Route::get('supervisores/{id}', 'SupervisoresController@show')      ->name('supervisores.show')   /*->middleware('')*/;
  Route::get('supervisores/{id}/edit', 'SupervisoresController@edit') ->name('supervisores.edit')   /*->middleware('')*/;
  Route::patch('supervisores/{id}', 'SupervisoresController@update')  ->name('supervisores.update') /*->middleware('')*/;
  Route::delete('supervisores/{id}', 'SupervisoresController@destroy')->name('supervisores.destroy')/*->middleware('')*/;
});

//Encuestas de los graduados
Route::group(['middleware'=>['auth']], function() {
  Route::get('encuestas-graduados', 'EncuestaGraduadoController@index')          ->name('encuestas-graduados.index')  /*->middleware('permission:')*/;
  Route::get('encuestas-graduados/create', 'EncuestaGraduadoController@create')  ->name('encuestas-graduados.create') /*->middleware('')*/;
  Route::post('encuestas-graduados/store', 'EncuestaGraduadoController@store')   ->name('encuestas-graduados.store')  /*->middleware('')*/;
  Route::get('encuestas-graduados/{id}', 'EncuestaGraduadoController@show')      ->name('encuestas-graduados.show')   /*->middleware('')*/;
  Route::get('encuestas-graduados/{id}/edit', 'EncuestaGraduadoController@edit') ->name('encuestas-graduados.edit')   /*->middleware('')*/;
  Route::patch('encuestas-graduados/{id}', 'EncuestaGraduadoController@update')  ->name('encuestas-graduados.update') /*->middleware('')*/;
  Route::delete('encuestas-graduados/{id}', 'EncuestaGraduadoController@destroy')->name('encuestas-graduados.destroy')/*->middleware('')*/;
  Route::get('agregar-contacto-encuesta/{id_encuesta}', 'EncuestaGraduadoController@agregarContacto')->name('encuestas-graduados.agregar-contacto');
  Route::post('agregar-contacto-encuesta/guardar/{id_encuesta}', 'EncuestaGraduadoController@guardarContacto')->name('encuestas-graduados.guardar-contacto');
});

//Encuestas de los graduados
Route::group(['middleware'=>['auth']], function() {
  Route::get('asignar-encuestas/{id_supervisor}/{id_encuestador}', 'EncuestaGraduadoController@asignar')                      ->name('asignar-encuestas.asignar')  /*->middleware('permission:')*/;
  Route::post('asignar-encuestas-encuestador/{id_supervisor}/{id_encuestador}', 'EncuestaGraduadoController@crearAsignacion') ->name('asignar-encuestas.crear-asignacion')  /*->middleware('permission:')*/;
  Route::get('ver-encuestas-asignadas/{id_encuestador}', 'EncuestaGraduadoController@encuestasAsignadasPorEncuestador')       ->name('asignar-encuestas.lista-encuestas-asignadas');
  Route::post('filtrar-muestra/{id_supervisor}/{id_encuestador}', 'EncuestaGraduadoController@filtrar_muestra_a_asignar')     ->name('asignar-encuestas.filtrar-muestra');
  Route::post('remover-encuestas-encuestador/{id_encuestador}', 'EncuestaGraduadoController@removerEncuestas')                ->name('asignar-encuestas.remover-encuestas');
});

//Gráficos
Route::group(['middleware'=>['auth']], function() {
  Route::get('graficos-estados', 'GraficosController@graficosPorEstado')->name('graficos.graficos-por-estado')  /*->middleware('permission:')*/;
  Route::get('graficos-estados-encuestador/{id_encuestador}', 'GraficosController@graficosPorEstadoEncuestador')->name('graficos.graficos-por-encuestador');
});

// Rutas para el mantenimiento de las carreras
Route::group(['prefix'=>'carreras', 'middleware'=>'auth'], function() {
    Route::get('', 'CarrerasController@index')          ->name('carreras.index')  /*->middleware('permission:')*/;
    Route::get('/create', 'CarrerasController@create')  ->name('carreras.create') /*->middleware('')*/;
    Route::post('/store', 'CarrerasController@store')   ->name('carreras.store')  /*->middleware('')*/;
    Route::get('/{id}', 'CarrerasController@show')      ->name('carreras.show')   /*->middleware('')*/;
    Route::get('/{id}/edit', 'CarrerasController@edit') ->name('carreras.edit')   /*->middleware('')*/;
    Route::patch('/{id}', 'CarrerasController@update')  ->name('carreras.update') /*->middleware('')*/;
    Route::delete('/{id}', 'CarrerasController@destroy')->name('carreras.destroy')/*->middleware('')*/;
});

// Rutas para el mantenimiento de las universidades
Route::group(['prefix'=>'universidades', 'middleware'=>'auth'], function() {
  Route::get('', 'UniversidadesController@index')          ->name('universidades.index')  /*->middleware('permission:')*/;
  Route::get('/create', 'UniversidadesController@create')  ->name('universidades.create') /*->middleware('')*/;
  Route::post('/store', 'UniversidadesController@store')   ->name('universidades.store')  /*->middleware('')*/;
  Route::get('/{id}', 'UniversidadesController@show')      ->name('universidades.show')   /*->middleware('')*/;
  Route::get('/{id}/edit', 'UniversidadesController@edit') ->name('universidades.edit')   /*->middleware('')*/;
  Route::patch('/{id}', 'UniversidadesController@update')  ->name('universidades.update') /*->middleware('')*/;
  Route::delete('/{id}', 'UniversidadesController@destroy')->name('universidades.destroy')/*->middleware('')*/;
});

// Rutas para el mantenimiento de los grados
Route::group(['prefix'=>'grados', 'middleware'=>'auth'], function() {
  Route::get('', 'GradosController@index')          ->name('grados.index')  /*->middleware('permission:')*/;
  Route::get('/create', 'GradosController@create')  ->name('grados.create') /*->middleware('')*/;
  Route::post('/store', 'GradosController@store')   ->name('grados.store')  /*->middleware('')*/;
  Route::get('/{id}', 'GradosController@show')      ->name('grados.show')   /*->middleware('')*/;
  Route::get('/{id}/edit', 'GradosController@edit') ->name('grados.edit')   /*->middleware('')*/;
  Route::patch('/{id}', 'GradosController@update')  ->name('grados.update') /*->middleware('')*/;
  Route::delete('/{id}', 'GradosController@destroy')->name('grados.destroy')/*->middleware('')*/;
});

// Rutas para el mantenimiento de las disciplinas
Route::group(['prefix'=>'disciplinas', 'middleware'=>'auth'], function() {
  Route::get('', 'DisciplinasController@index')          ->name('disciplinas.index')  /*->middleware('permission:')*/;
  Route::get('/create', 'DisciplinasController@create')  ->name('disciplinas.create') /*->middleware('')*/;
  Route::post('/store', 'DisciplinasController@store')   ->name('disciplinas.store')  /*->middleware('')*/;
  Route::get('/{id}', 'DisciplinasController@show')      ->name('disciplinas.show')   /*->middleware('')*/;
  Route::get('/{id}/edit', 'DisciplinasController@edit') ->name('disciplinas.edit')   /*->middleware('')*/;
  Route::patch('/{id}', 'DisciplinasController@update')  ->name('disciplinas.update') /*->middleware('')*/;
  Route::delete('/{id}', 'DisciplinasController@destroy')->name('disciplinas.destroy')/*->middleware('')*/;
});

// Rutas para el mantenimiento de las áreas
Route::group(['prefix'=>'areas', 'middleware'=>'auth'], function() {
  Route::get('', 'AreasController@index')          ->name('areas.index')  /*->middleware('permission:')*/;
  Route::get('/create', 'AreasController@create')  ->name('areas.create') /*->middleware('')*/;
  Route::post('/store', 'AreasController@store')   ->name('areas.store')  /*->middleware('')*/;
  Route::get('/{id}', 'AreasController@show')      ->name('areas.show')   /*->middleware('')*/;
  Route::get('/{id}/edit', 'AreasController@edit') ->name('areas.edit')   /*->middleware('')*/;
  Route::patch('/{id}', 'AreasController@update')  ->name('areas.update') /*->middleware('')*/;
  Route::delete('/{id}', 'AreasController@destroy')->name('areas.destroy')/*->middleware('')*/;
});

// Rutas para el mantenimiento de los detalle de contacto
Route::group(['prefix'=>'detalles', 'middleware'=>'auth'], function() {
  Route::get('', 'DetalleController@index')          ->name('detalles.index')  /*->middleware('permission:')*/;
  Route::get('/create/{id}', 'DetalleController@create')  ->name('detalles.create') /*->middleware('')*/;
  Route::post('/store/{id}', 'DetalleController@store')   ->name('detalles.store')  /*->middleware('')*/;
  Route::get('/{id}', 'DetalleController@show')      ->name('detalles.show')   /*->middleware('')*/;
  Route::get('/{id}/edit', 'DetalleController@edit') ->name('detalles.edit')   /*->middleware('')*/;
  Route::patch('/{id}', 'DetalleController@update')  ->name('detalles.update') /*->middleware('')*/;
  Route::delete('/{id}', 'DetalleController@destroy')->name('detalles.destroy')/*->middleware('')*/;
});

Route::group(['prefix'=>'encuestador', 'middleware'=>'auth'], function() {
  Route::get('mis-entrevistas/{id_encuestador}',                                                    'EncuestadorController@mis_entrevistas')                ->name('encuestador.mis-entrevistas');
  Route::get('realizar-entrevista/{id_entrevista}',                                                 'EncuestadorController@realizar_entrevista')            ->name('encuestador.realizar-entrevista');
  Route::patch('actualizar-entrevista/{id_entrevista}',                                             'EncuestadorController@actualizar_entrevista')          ->name('encuestador.actualizar-entrevista');
  Route::get('agregar-contacto-entrevista/{id_entrevista}',                                         'EncuestadorController@agregar_contacto')               ->name('encuestador.agregar-contacto-entrevista');
  Route::post('agregar-contacto-entrevista-encuestador/guardar/{id_entrevista}/{id_encuestador}',   'EncuestadorController@guardar_contacto')               ->name('encuestador.guardar-contacto-entrevista-encuestador');
  Route::get('agregar-detalle-contacto/{id_contacto}/{id_entrevista}',                              'EncuestadorController@agregar_detalle_contacto')       ->name('encuestador.agregar-detalle-contacto');
  Route::post('guardar-detalle-contacto/{id_contacto}/{id_entrevista}',                             'EncuestadorController@guardar_detalle_contacto')       ->name('encuestador.guardar-detalle-contacto');
  Route::get('editar-detalle-contacto/{id_detalle_contacto}/{id_entrevista}/editar',                'EncuestadorController@editar_detalle_contacto')        ->name('encuestador.editar-detalle-contacto');
  Route::patch('actualizar-detalle-contacto/{id_detalle_contacto}/{id_entrevista}',                 'EncuestadorController@actualizar_detalle_contacto')    ->name('encuestador.actualizar-detalle-contacto');
  Route::delete('{id_detalle}/{id_entrevista}/borrar',                                              'EncuestadorController@borrar_detalle_contacto')        ->name('encuestador.borrar-detalle-contacto');
  Route::get('editar-contacto-entrevista/{id_contacto}/editar/{id_entrevista}',                     'EncuestadorController@editar_contacto_entrevista')     ->name('encuestador.modificar-contacto-entrevista');
  Route::patch('actualizar-contacto-entrevista/actualizar/{id_contacto}/{id_entrevista}',           'EncuestadorController@actualizar_contacto_entrevista') ->name('encuestador.actualizar-contacto-entrevista');
  Route::get('reportes-de-encuestador/graficos/{id_encuestador}' ,                                  'EncuestadorController@reportes_de_encuestador')        ->name('encuestador.reportes-de-encuestador');
});

//Plantilla rutas
// Route::group(['middleware'=>['auth']], function() {
//     Route::get('algo', 'Controller@index')          ->name('algo.index')  /*->middleware('permission:')*/;
//     Route::get('algo/create', 'Controller@create')  ->name('algo.create') /*->middleware('')*/;
//     Route::post('algo/store', 'Controller@store')   ->name('algo.store')  /*->middleware('')*/;
//     Route::get('algo/{id}', 'Controller@show')      ->name('algo.show')   /*->middleware('')*/;
//     Route::get('algo/{id}/edit', 'Controller@edit') ->name('algo.edit')   /*->middleware('')*/;
//     Route::patch('algo/{id}', 'Controller@update')  ->name('algo.update') /*->middleware('')*/;
//     Route::delete('algo/{id}', 'Controller@destroy')->name('algo.destroy')/*->middleware('')*/;
// });
