<section class="content">
        <div class="row">
            @foreach($mis_entrevistas as $entrevista)
                <div class="col-md-6">
                    <div class="box box-primary {{--collapsed-box--}}" >
                        <!-- Encabezado del cuadro -->
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                {!! $entrevista->nombre_completo !!}
                            </h3>
          
                            <!-- Botones de la parte superior derecha -->
                            <div class="box-tools pull-right">
                                <div class='btn-group'>
                                    <!-- Boton para minimizar/maximiar cada cuadro -->
                                    <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
        
                                </div>
                            </div>
                        </div>
    
                        <!-- Imagen del cuadro -->
                        <div class="box-body">
                            <div class="col-md-12">
                                <p>Cédula: {!! $entrevista->identificacion_graduado !!}</p>
                                <p>{!! $entrevista->carrera->nombre !!} - {!! $entrevista->universidad->nombre !!}</p>
                                <p>Año de graduación: {!! $entrevista->annio_graduacion !!}</p>
                            </div>
                        </div>
    
                        <!-- Botones del cuadro, parte inferior -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <a href="{!! route('encuestador.realizar-entrevista', $entrevista->id) !!}" class="btn btn-primary btn-sm col-sm-12">
                                        <i class="fa fa-plus-square"></i> Realizar encuesta
                                    </a>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
          