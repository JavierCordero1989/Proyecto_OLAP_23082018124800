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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/reporte-general', 'HomeController@reportes_generales')->name('home.reporte-general')->middleware('auth');

//Rutas para los roles
Route::group(['middleware'=>['auth']], function() {
  Route::get('roles', 'RolesController@index')          ->name('roles.index');
  Route::get('roles/create', 'RolesController@create')  ->name('roles.create');
  Route::post('roles/store', 'RolesController@store')   ->name('roles.store');
  Route::get('roles/{id}', 'RolesController@show')      ->name('roles.show');
  Route::get('roles/{id}/edit', 'RolesController@edit') ->name('roles.edit');
  Route::patch('roles/{id}', 'RolesController@update')  ->name('roles.update');
  Route::delete('roles/{id}', 'RolesController@destroy')->name('roles.destroy');
});

//Rutas para los permisos
Route::group(['middleware'=>['auth']], function() {
  Route::get('permisos', 'PermissionsController@index')          ->name('permisos.index');
  Route::get('permisos/create', 'PermissionsController@create')  ->name('permisos.create');
  Route::post('permisos/store', 'PermissionsController@store')   ->name('permisos.store');
  Route::get('permisos/{id}', 'PermissionsController@show')      ->name('permisos.show');
  Route::get('permisos/{id}/edit', 'PermissionsController@edit') ->name('permisos.edit');
  Route::patch('permisos/{id}', 'PermissionsController@update')  ->name('permisos.update');
  Route::delete('permisos/{id}', 'PermissionsController@destroy')->name('permisos.destroy');
});

//Rutas para los usuarios
Route::group(['middleware'=>['auth']], function() {
  Route::get('users', 'UserController@index')          ->name('users.index');
  Route::get('users/create', 'UserController@create')  ->name('users.create');
  Route::post('users/store', 'UserController@store')   ->name('users.store');
  Route::get('users/{id}', 'UserController@show')      ->name('users.show');
  Route::get('users/{id}/edit', 'UserController@edit') ->name('users.edit');
  Route::patch('users/{id}', 'UserController@update')  ->name('users.update');
  Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy');
  
  Route::get('users/edit-name/{id}', 'UserController@edit_name')               ->name('users.edit_name');
  Route::patch('users/update-name/{id}', 'UserController@update_name')         ->name('users.update_name');
  Route::get('users/edit-password/{id}', 'UserController@edit_password')       ->name('users.edit_password');
  Route::patch('users/update-password/{id}', 'UserController@update_password') ->name('users.update_password');
  Route::get('usuarios', 'UserController@index_table')                         ->name('usuarios.index_table');
});

Route::get('asignar-permisos-a-rol/create', 'AssignPermissionsToRolController@create') ->name('permissionsToRol.create');
Route::post('asignar-permisos-a-rol/store', 'AssignPermissionsToRolController@store')  ->name('permissionsToRol.store');

Route::get('asignar-roles-a-usuario/create', 'AssignRolesToUserController@create') ->name('rolesToUser.create');
Route::post('asignar-roles-a-usuario/store', 'AssignRolesToUserController@store')  ->name('rolesToUser.store');

Route::group(['middleware'=>'auth'], function(){
  Route::post('importar-excel-bd/importar', 'ExportImportExcelController@importar_desde_excel') ->name('excel.import');
  Route::get('importar-excel-bd/create', 'ExportImportExcelController@create')                  ->name('excel.create')->middleware(['role:Super Admin|Supervisor 1']);
  Route::post('importar-excel-bd/guardar-aceptados/data-file', 'ExportImportExcelController@guardarRegistrosAceptados')->name('excel.guardar-aceptados');
  Route::get('importar-archivo-contactos', 'ExportImportExcelController@createArchivoContactos')->name('excel.subir-contactos');
  Route::post('importar-archivo-contactos', 'ExportImportExcelController@subirArchivoExcelContactos')->name('excel.subir-archivo-contactos');
  Route::get('confirmacion/archivos/excel/{respuesta}', 'ExportImportExcelController@respuesta_archivo_muestra')->name('excel.respuesta-archivo');
});

//Encuestadores
Route::group(['middleware'=>['auth']], function() {
    Route::get('encuestadores', 'EncuestadoresController@index')                                                                  ->name('encuestadores.index')  /*->middleware('permission:')*/;
    Route::get('encuestadores/create', 'EncuestadoresController@create')                                                          ->name('encuestadores.create') ->middleware('role:Super Admin|Supervisor 1|Supervisor 2');
    Route::post('encuestadores/store', 'EncuestadoresController@store')                                                           ->name('encuestadores.store')  /*->middleware('')*/;
    Route::get('encuestadores/{id}', 'EncuestadoresController@show')                                                              ->name('encuestadores.show')   /*->middleware('')*/;
    Route::get('encuestadores/{id}/edit', 'EncuestadoresController@edit')                                                         ->name('encuestadores.edit')   ->middleware('role:Super Admin|Supervisor 1|Supervisor 2');
    Route::patch('encuestadores/{id}', 'EncuestadoresController@update')                                                          ->name('encuestadores.update') /*->middleware('')*/;
    Route::delete('encuestadores/{id}', 'EncuestadoresController@destroy')                                                        ->name('encuestadores.destroy')/*->middleware('')*/;
    Route::get('cambiar-contrasennia-encuestador/{id_encuestador}/cambiar', 'EncuestadoresController@cambiar_contrasennia')       ->name('encuestadores.cambiar-contrasennia');
    Route::patch('cambiar-contrasennia-encuestador/{id_encuestador}', 'EncuestadoresController@actualizar_contrasennia')          ->name('encuestadores.actualizar-contrasennia');
    Route::get('lista-encuestas/{id}', 'EncuestadoresController@lista_de_encuestas')                                              ->name('encuestadores.lista-de-encuestas');
    Route::get('agregar-contacto-encuestador/{id_encuesta}', 'EncuestadoresController@agregarContacto')                           ->name('encuestadores.agregar-contacto');
    Route::post('agregar-contacto-encuestador/guardar/{id_encuesta}/{id_encuestador}', 'EncuestadoresController@guardarContacto') ->name('encuestadores.guardar-contacto');
    Route::get('modificar-contacto/{id_contacto}/editar', 'EncuestadoresController@editarContacto')                               ->name('encuestadores.modificar-contacto');
    Route::patch('modificar-contacto/{id_contacto}', 'EncuestadoresController@actualizarContacto')                                ->name('encuestadores.actualizar-contacto');
});

//Supervisores
Route::group(['middleware'=>['auth']], function() {
  Route::get('supervisores', 'SupervisoresController@index')          ->name('supervisores.index')  /*->middleware('permission:')*/;
  Route::get('supervisores/create', 'SupervisoresController@create')  ->name('supervisores.create') ->middleware('role:Super Admin|Supervisor 1');
  Route::post('supervisores/store', 'SupervisoresController@store')   ->name('supervisores.store')  /*->middleware('')*/;
  Route::get('supervisores/{id}', 'SupervisoresController@show')      ->name('supervisores.show')   /*->middleware('')*/;
  Route::get('supervisores/{id}/edit', 'SupervisoresController@edit') ->name('supervisores.edit')   ->middleware('role:Super Admin|Supervisor 1');
  Route::patch('supervisores/{id}', 'SupervisoresController@update')  ->name('supervisores.update') /*->middleware('')*/;
  Route::delete('supervisores/{id}', 'SupervisoresController@destroy')->name('supervisores.destroy')/*->middleware('')*/;
});

//Encuestas de los graduados
Route::group(['middleware'=>['auth']], function() {
  Route::get('encuestas-graduados', 'EncuestaGraduadoController@index')                                        ->name('encuestas-graduados.index')  /*->middleware('permission:')*/;
  Route::get('encuestas-graduados/create', 'EncuestaGraduadoController@create')                                ->name('encuestas-graduados.create') /*->middleware('')*/;
  Route::post('encuestas-graduados/store', 'EncuestaGraduadoController@store')                                 ->name('encuestas-graduados.store')  /*->middleware('')*/;
  Route::get('encuestas-graduados/{id}', 'EncuestaGraduadoController@show')                                    ->name('encuestas-graduados.show')   /*->middleware('')*/;
  Route::get('encuestas-graduados/{id}/edit', 'EncuestaGraduadoController@edit')                               ->name('encuestas-graduados.edit')   /*->middleware('')*/;
  Route::patch('encuestas-graduados/{id}', 'EncuestaGraduadoController@update')                                ->name('encuestas-graduados.update') /*->middleware('')*/;
  Route::delete('encuestas-graduados/{id}', 'EncuestaGraduadoController@destroy')                              ->name('encuestas-graduados.destroy')/*->middleware('')*/;
  Route::get('agregar-contacto-encuesta/{id_encuesta}', 'EncuestaGraduadoController@agregarContacto')          ->name('encuestas-graduados.agregar-contacto');
  Route::post('agregar-contacto-encuesta/guardar/{id_encuesta}', 'EncuestaGraduadoController@guardarContacto') ->name('encuestas-graduados.guardar-contacto');
  // Route::get('lista-de-encuestas', 'EncuestaGraduadoController@listaDeEncuestas')->name('encuestas-graduados.lista-de-encuestas');
  Route::get('filtro-encuestas', 'EncuestaGraduadoController@filtro_encuestas')->name('encuestas-graduados.filtro');
  Route::get('ver-otras-entrevistas/{ids}', 'EncuestaGraduadoController@ver_otras_carreras')->name('encuestas-graduados.otras-carreras');
  Route::get('hacer-sustitucion/encuestas-graduados', 'EncuestaGraduadoController@hacer_sustitucion')->name('encuestas-graduados.hacer-sustitucion');
  Route::post('hacer-sustitucion/encuestas-graduados', 'EncuestaGraduadoController@hacer_sustitucion_post')->name('encuestas-graduados.hacer-sustitucion-post');
  Route::get('buscar-encuesta', 'EncuestaGraduadoController@buscar_encuesta')->name('encuestas-graduados.buscar-encuesta');
});

//Encuestas de los graduados
Route::group(['middleware'=>['auth']], function() {
  Route::get('asignar-encuestas/{id_supervisor}/{id_encuestador}', 'EncuestaGraduadoController@asignar')                                               ->name('asignar-encuestas.asignar')  /*->middleware('permission:')*/;
  Route::post('asignar-encuestas-encuestador/{id_supervisor}/{id_encuestador}', 'EncuestaGraduadoController@crearAsignacion')                          ->name('asignar-encuestas.crear-asignacion')  /*->middleware('permission:')*/;
  Route::get('ver-encuestas-asignadas/{id_encuestador}', 'EncuestaGraduadoController@encuestasAsignadasPorEncuestador')                                ->name('asignar-encuestas.lista-encuestas-asignadas');
  Route::post('filtrar-muestra/{id_supervisor}/{id_encuestador}', 'EncuestaGraduadoController@filtrar_muestra_a_asignar')                              ->name('asignar-encuestas.filtrar-muestra');
  Route::post('remover-encuestas-encuestador/{id_encuestador}', 'EncuestaGraduadoController@removerEncuestas')                                         ->name('asignar-encuestas.remover-encuestas');
  Route::get('remover-encuestas-encuestador/{id_entrevista}/{id_encuestador}',     'EncuestaGraduadoController@remover_encuestas_a_encuestador')       ->name('asignar-encuestas.remover-encuestas-a-encuestador');
  Route::get('realizar-entrevista/{id_entrevista}', 'EncuestaGraduadoController@realizar_entrevista')                                                  ->name('asignar-encuestas.realizar-entrevista');
  Route::get('agregar-contacto-entrevista/{id_entrevista}', 'EncuestaGraduadoController@agregar_contacto')                                             ->name('asignar-encuestas.agregar-contacto-entrevista');
  Route::patch('actualizar-entrevista/{id_entrevista}', 'EncuestaGraduadoController@actualizar_entrevista')                                            ->name('asignar-encuestas.actualizar-entrevista');
  Route::get('agregar-detalle-contacto/{id_contacto}/{id_entrevista}', 'EncuestaGraduadoController@agregar_detalle_contacto')                          ->name('asignar-encuestas.agregar-detalle-contacto');
  Route::delete('{id_detalle}/{id_entrevista}/borrar', 'EncuestaGraduadoController@borrar_detalle_contacto')                                           ->name('asignar-encuestas.borrar-detalle-contacto');
  Route::get('editar-detalle-contacto/{id_detalle_contacto}/{id_entrevista}/editar', 'EncuestaGraduadoController@editar_detalle_contacto')             ->name('asignar-encuestas.editar-detalle-contacto');
  Route::get('editar-contacto-entrevista/{id_contacto}/editar/{id_entrevista}', 'EncuestaGraduadoController@editar_contacto_entrevista')               ->name('asignar-encuestas.modificar-contacto-entrevista');
  Route::post('agregar-contacto-entrevista-supervisor/guardar/{id_entrevista}/{id_supervisor}', 'EncuestaGraduadoController@guardar_contacto')         ->name('asignar-encuestas.guardar-contacto-entrevista-supervisor');
  Route::post('guardar-detalle-contacto/{id_contacto}/{id_entrevista}', 'EncuestaGraduadoController@guardar_detalle_contacto')                         ->name('asignar-encuestas.guardar-detalle-contacto');
  Route::patch('actualizar-detalle-contacto/{id_detalle_contacto}/{id_entrevista}', 'EncuestaGraduadoController@actualizar_detalle_contacto')          ->name('asignar-encuestas.actualizar-detalle-contacto');
  Route::patch('actualizar-contacto-entrevista/actualizar/{id_contacto}/{id_entrevista}', 'EncuestaGraduadoController@actualizar_contacto_entrevista') ->name('asignar-encuestas.actualizar-contacto-entrevista');
});

//Gráficos
Route::group(['middleware'=>['auth']], function() {
  Route::get('graficos-estados', 'GraficosController@graficosPorEstado')                                         ->name('graficos.graficos-por-estado')  /*->middleware('permission:')*/;
  Route::get('graficos-estados-encuestador/{id_encuestador}', 'GraficosController@graficosPorEstadoEncuestador') ->name('graficos.graficos-por-encuestador');
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
  Route::get('getDisciplinas/area/{id}', 'DisciplinasController@disciplinasPorAreaAxios')->name('disciplinas.axios');
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
  Route::get('getAreas/axios', 'AreasController@axiosAreas')->name('areas.axios');
});

// Rutas para el mantenimiento de los detalle de contacto
Route::group(['prefix'=>'detalles', 'middleware'=>'auth'], function() {
  Route::get('', 'DetalleController@index')              ->name('detalles.index')  /*->middleware('permission:')*/;
  Route::get('/create/{id}', 'DetalleController@create') ->name('detalles.create') /*->middleware('')*/;
  Route::post('/store/{id}', 'DetalleController@store')  ->name('detalles.store')  /*->middleware('')*/;
  Route::get('/{id}', 'DetalleController@show')          ->name('detalles.show')   /*->middleware('')*/;
  Route::get('/{id}/edit', 'DetalleController@edit')     ->name('detalles.edit')   /*->middleware('')*/;
  Route::patch('/{id}', 'DetalleController@update')      ->name('detalles.update') /*->middleware('')*/;
  Route::delete('/{id}', 'DetalleController@destroy')    ->name('detalles.destroy')/*->middleware('')*/;
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

// Rutas para el supervisor 2
Route::group(['prefix'=>'supervisor/2', 'middleware'=>'auth'], function() {
    Route::group(['prefix'=>'encuestadores'], function(){
        Route::get('lista-de-encuestadores',                                                                    'Supervisor2Controller@lista_de_encuestadores')                   ->name('supervisor2.lista-de-encuestadores');
        Route::post('lista-de-encuestadores/almacenar-nuevo-encuestador',                                       'Supervisor2Controller@almacenar_nuevo_encuestador')              ->name('supervisor2.almacenar-nuevo-encuestador');
        Route::get('lista-de-encuestadores/{id_encuestador}/editar-encuestador',                                'Supervisor2Controller@editar_encuestador')                       ->name('supervisor2.editar-encuestador');
        Route::patch('lista-de-encuestadores/{id_encuestador}',                                                 'Supervisor2Controller@actualizar_datos_encuestador')             ->name('supervisor2.actualizar-datos-encuestador');
        Route::get('lista-de-encuestadores/asignar-encuestas/{id_supervisor}/{id_encuestador}',                 'Supervisor2Controller@asignar_encuestas_a_encuestador')          ->name('supervisor2.asignar-encuestas-a-encuestador');
        Route::get('lista-de-encuestadores/ver-encuestas-asignadas/{id_encuestador}',                           'Supervisor2Controller@encuestas_asignadas_por_encuestador')      ->name('supervisor2.encuestas-asignadas-por-encuestador');
        Route::get('lista-de-encuestadores/graficos-de-estados-por-encuestador/{id_encuestador}',               'Supervisor2Controller@graficos_por_estado_de_encuestador')       ->name('supervisor2.graficos-por-estado-de-encuestador');
        Route::post('lista-de-encuestadores/filtrar-muestra-de-entrevistas/{id_supervisor}/{id_encuestador}',   'Supervisor2Controller@filtrar_muestra_de_entrevistas_a_asignar') ->name('supervisor2.filtrar-muestra-de-entrevistas-a-asignar');
        Route::get('lista-de-encuestadores/remover-encuestas-encuestador/{id_entrevista}/{id_encuestador}',     'Supervisor2Controller@remover_encuestas_a_encuestador')          ->name('supervisor2.remover-encuestas-a-encuestador');
        Route::post('lista-de-encuestadores/asignar-encuestas-a-encuestador/{id_supervisor}/{id_encuestador}',  'Supervisor2Controller@crear_nueva_asignacion')                   ->name('supervisor2.crear-nueva-asignacion');
    });

    Route::group(['prefix'=>'supervisores'], function(){
        Route::get('lista-de-supervisores',                                                                                 'Supervisor2Controller@lista_de_supervisores')                                 ->name('supervisor2.lista-de-supervisores');
        Route::get('lista-de-supervisores/asignar-encuestas/{id_supervisor}/{id_supervisor_asignado}',                      'Supervisor2Controller@asignar_encuestas_a_supervisor')                        ->name('supervisor2.asignar-encuestas-a-supervisor');
        Route::get('lista-de-supervisores/ver-encuestas-asignadas/{id_supervisor}',                                         'Supervisor2Controller@encuestas_asignadas_por_supervisor')                    ->name('supervisor2.encuestas-asignadas-por-supervisor');
        Route::post('lista-de-supervisores/filtrar-muestra-de-entrevistas/{id_supervisor}/{id_supervisor_asignado}',        'Supervisor2Controller@filtrar_muestra_de_entrevistas_a_asignar_a_supervisor') ->name('supervisor2.filtrar-muestra-de-entrevistas-a-asignar-a-supervisor');
        Route::get('lista-de-supervisores/remover-encuestas-supervisor/{id_entrevista}/{id_supervisor}',                    'Supervisor2Controller@remover_encuestas_a_supervisor')                        ->name('supervisor2.remover-encuestas-a-supervisor');
        Route::post('lista-de-supervisores/asignar-encuestas-a-supervisor/{id_supervisor}/{id_supervisor_asignado}',        'Supervisor2Controller@crear_nueva_asignacion_a_supervisor')                   ->name('supervisor2.crear-nueva-asignacion-a-supervisor');
        Route::get('lista-de-supervisores/graficos-de-estados-por-supervisor/{id_supervisor}',                              'Supervisor2Controller@graficos_por_estado_de_supervisor')                     ->name('supervisor2.graficos-por-estado-de-supervisor');
        Route::get('lista-de-supervisores/realizar-entrevista/{id_entrevista}',                                             'Supervisor2Controller@realizar_entrevista')                                   ->name('supervisor2.realizar-entrevista');
        Route::get('lista-de-supervisores/agregar-contacto-entrevista/{id_entrevista}',                                     'Supervisor2Controller@agregar_contacto')                                      ->name('supervisor2.agregar-contacto-entrevista');
        Route::patch('lista-de-supervisores/actualizar-entrevista/{id_entrevista}',                                         'Supervisor2Controller@actualizar_entrevista')                                 ->name('supervisor2.actualizar-entrevista');
        Route::post('lista-de-supervisores/agregar-contacto-entrevista-supervisor/guardar/{id_entrevista}/{id_supervisor}', 'Supervisor2Controller@guardar_contacto')                                      ->name('supervisor2.guardar-contacto-entrevista-supervisor');
        Route::get('lista-de-supervisores/agregar-detalle-contacto/{id_contacto}/{id_entrevista}',                          'Supervisor2Controller@agregar_detalle_contacto')                              ->name('supervisor2.agregar-detalle-contacto');
        Route::delete('lista-de-supervisores/{id_detalle}/{id_entrevista}/borrar',                                          'Supervisor2Controller@borrar_detalle_contacto')                               ->name('supervisor2.borrar-detalle-contacto');
        Route::get('lista-de-supervisores/editar-detalle-contacto/{id_detalle_contacto}/{id_entrevista}/editar',            'Supervisor2Controller@editar_detalle_contacto')                               ->name('supervisor2.editar-detalle-contacto');
        Route::get('lista-de-supervisores/editar-contacto-entrevista/{id_contacto}/editar/{id_entrevista}',                 'Supervisor2Controller@editar_contacto_entrevista')                            ->name('supervisor2.modificar-contacto-entrevista');
        Route::post('lista-de-supervisores/guardar-detalle-contacto/{id_contacto}/{id_entrevista}',                         'Supervisor2Controller@guardar_detalle_contacto')                              ->name('supervisor2.guardar-detalle-contacto');
        Route::patch('lista-de-supervisores/actualizar-detalle-contacto/{id_detalle_contacto}/{id_entrevista}',             'Supervisor2Controller@actualizar_detalle_contacto')                           ->name('supervisor2.actualizar-detalle-contacto');
        Route::patch('lista-de-supervisores/actualizar-contacto-entrevista/actualizar/{id_contacto}/{id_entrevista}',       'Supervisor2Controller@actualizar_contacto_entrevista')                        ->name('supervisor2.actualizar-contacto-entrevista');
        Route::get('lista-de-supervisores/entrevistas-graduados',                                                           'Supervisor2Controller@lista_general_de_entrevistas')                          ->name('supervisor2.lista-general-de-entrevistas')  /*->middleware('permission:')*/;
        Route::get('lista-de-supervisores/estadisticas-generales',                                                          'Supervisor2Controller@estadisticas_generales')                                ->name('supervisor2.estadisticas_generales')  /*->middleware('permission:')*/;
        Route::post('lista-de-supervisores/agregar-nueva-entrevista',                                                       'Supervisor2Controller@agregar_nuevo_caso_entrevista')->name('supervisor2.agregar-nuevo-caso-entrevista');
        // Route::get('lista-de-supervisores/entrevistas-graduados/crear-nueva', 'EncuestaGraduadoController@create')  ->name('encuestas-graduados.create') /*->middleware('')*/;
        Route::get('lista-de-supervisores/agregar-contacto-nueva-entrevista/{id_entrevista}',                               'Supervisor2Controller@agregar_contacto_nueva_entrevista')                     ->name('supervisor2.agregar-contacto-nueva-entrevista');
        Route::post('lista-de-supervisores/agregar-contacto-nueva-entrevista/guardar/{id_entrevista}',                      'Supervisor2Controller@guardar_contacto_nueva_entrevista')                     ->name('supervisor2.guardar-contacto-nueva-entrevista');
    });
});

// Rutas para el calendario y citas
Route::group(['prefix'=>'calendario-de-citas', 'middleware'=>'auth'], function() {
  Route::get('{id_usuario}', 'CalendarioDeCitasController@ver_calendario')->name('ver-calendario');
  Route::get('agendar-cita-entrevista/{encuestador}/{mal_encuestador}/{entrevista}/{mal_entrevista}', 'CalendarioDeCitasController@agendar_cita_a_entrevista') ->name('calendario.agendar-cita');
  Route::post('agendar-cita-entrevista/guardar/{entrevista}/{encuestador}', 'CalendarioDeCitasController@guardar_cita_de_entrevista')                          ->name('calendario.guardar-cita');
  Route::get('lista-citas/obtener-citas-calendario', 'CalendarioDeCitasController@obtener_citas_calendario')->name('obtener-citas-calendario');
  Route::post('cambiar-estado-de-citas/{id_cita}/{id_usuario}','CalendarioDeCitasController@cambiar_estado_de_cita')->name('cambiar-estado-de-cita');
  Route::post('agendar-cita-desde-calendario', 'CalendarioDeCitasController@agendar_cita_desde_calendario')->name('agendar-cita-desde-calendario');
  Route::get('resumen-de-cita/{id_cita}', 'CalendarioDeCitasController@resumen_cita')->name('resumen-de-cita');
});

// Rutas para los reportes 
Route::group(['prefix'=>'reportes', 'middleware'=>'auth'], function() {
  Route::get('filtro', 'ReportesController@vista_filtro_reportes')->name('reportes.filtro');
  Route::get('generar/reporte/filtro', 'ReportesController@generar_reporte')->name('reportes.generar');
  // Route::get('', 'ReportesController@index')                                 ->name('reportes.index');
  // Route::get('filtro', 'ReportesController@filtro_reportes')                 ->name('reportes.filtro');
  // Route::post('filtro', 'ReportesController@filtrar_encuestas_para_reporte') ->name('reportes.filtro-encuestas');
});

Route::group(['prefix'=>'security'], function(){
  Route::get('remember-password', 'ResetPasswordController@anotar_cambio_de_contrasennia')->name('security.remember-password');
  Route::post('send-password-request', 'ResetPasswordController@obtener_solicitud_de_cambio')->name('security.send-password-request');
  Route::get('get-password-reset/get-requests', 'ResetPasswordController@obtener_solicitudes_de_cambio')->name('security.get-password-reset-requests')->middleware('auth');
  Route::get('change-password/user/{email}/change', 'ResetPasswordController@cambiar_contrasennia_usuario')->name('security.change-password')->middleware('auth');
  Route::post('reset-password/{id}', 'ResetPasswordController@realizar_cambio_de_contrasennia')->name('security.reset-password');
});

Route::post('pruebas', function(\Illuminate\Http\Request $request) {
  $datos_encontrados = [];

  if(isset($request->disciplinas)) {
    $disciplinas = $request->disciplinas;

    foreach($disciplinas as $disciplina) {
      $area = \App\Area::buscarPorDescriptivo($disciplina)->first();

      if(empty($area)) {
        $datos_encontrados[] = \App\Disciplina::buscarPorCodigo($disciplina)->first();
      }
      else {
        foreach($area->disciplinas as $disc_por_area) {
          $datos_encontrados[] = $disc_por_area;
        }
      }
    }
  }
  dd($datos_encontrados);
})->name('pruebas.from');

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







Route::get('usuarios', function() {

  $usuarios = \App\User::all();

  $encuestadores= [];
  $supervisores_2 = [];
  $supervisores_1 = [];
  $administradores = [];

  foreach($usuarios as $usuario) {
    if($usuario->hasRole('Encuestador')) { $encuestadores[] = $usuario->email; }
    if($usuario->hasRole('Supervisor 2')) { $supervisores_2[] = $usuario->email; }
    if($usuario->hasRole('Supervisor 1')) { $supervisores_1[] = $usuario->email; }
    if($usuario->hasRole('Super Admin')) { $administradores[] = $usuario->email; }
  }

  $datos = array(
    'encuestadores' => $encuestadores,
    'supervisores_2' => $supervisores_2,
    'supervisores_1' => $supervisores_1,
    'administradores' => $administradores
  );

  return view('pruebas.usuarios')
    ->with('datos', $datos);
})->name('usuarios');





// Para ajax para comprobar código de usuario
Route::get('findUserByCode', function(\Illuminate\Http\Request $request) {
  if($request->ajax()) {
    $codigo = $request->codigo_usuario;
    $mensaje = '';
    $encontrado = false;

    $usuario = App\User::findByUserCode($codigo)->first();

    if(!empty($usuario)) {
      $mensaje = 'El código que esta ingresando se encuentra registrado.';
      $encontrado = true;
    }

    $datos_respuesta = [
      'mensaje' => $mensaje,
      'encontrado' => $encontrado
    ];

    return response()->json($datos_respuesta);
  }
})->name('findUserByCode');

// Para ajax para comprobar email del usuario
Route::get('findUserByEmail', function(\Illuminate\Http\Request $request) {
  if($request->ajax()) {
    $email = $request->email;
    $mensaje = '';
    $encontrado = false;

    $usuario = App\User::findByEmail($email)->first();

    if(!empty($usuario)) {
      $mensaje = 'El email que esta ingresando se encuentra registrado.';
      $encontrado = true;
    }

    $datos_respuesta = [
      'mensaje' => $mensaje,
      'encontrado' => $encontrado
    ];

    return response()->json($datos_respuesta);
  }
})->name('findUserByEmail');