<!-- Modal para el texto de eliminar -->
<div class="modal modal-danger fade" id="modalEliminar-{{$element['options']['id']}}">
    <div class="modal-dialog"> <!-- Inicio del div del MODAL-DIALOG -->

        <div class="modal-content"> <!-- Inicio del div del MODAL-CONTENT -->

            <!-- Declaracion del encabezado -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="glyphicon glyphicon-warning-sign"></i> Eliminando información...</h4>
            </div>

            <!-- Declaracion del cuerpo del modal -->
            <div class="modal-body">
                <p>El registro que seleccionó, se eliminará completamente del sistema.</p>
                <br>
                <p>¿Desea completar la acción de todos modos?</p>
            </div>

            <!-- Declaracion del pie del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <!-- <button type="submit" class="btn btn-outline">Eliminar</button> -->
                {!! Form::button('Aceptar', ['type' => 'submit', 'class' => 'btn btn-outline']) !!}
            </div>

        </div> <!-- Cierre del div MODAL-DIALOG -->

    </div> <!-- Cierre del div MODAL-DIALOG -->

</div> <!-- Cierre del div del modal -->