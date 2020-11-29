<form action="{{url('compras/ingreso')}}" method="get" class="form-group">
    <div class="input-group">
        <input class="form-control" type="text" name="searchText" placeholder="Buscar..." value="{{ $searchText ?? ''}}" title="Busque por tipo de comprobante,número, serie o nombre del proveedor">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary"> Buscar </button>
        </span>
    </div>
</form>

