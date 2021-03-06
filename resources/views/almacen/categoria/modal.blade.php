<div id="modal-delete-{{$cat->id}}" class="modal fade modal-slide-in-right" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="{{url ('/almacen/categoria/'.$cat->id.'')}}" method="post">
        {{csrf_field()}}
        {{ method_field('DELETE') }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¡Atencion!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Esta seguro que desea eliminar esta categoria?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>
</div>