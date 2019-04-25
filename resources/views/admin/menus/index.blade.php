@extends('admin.layout.admin') @section( 'breadcrumbs' )
<!-- breadcrumbs -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Menus</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/admin">Paínel de controle</a>
            </li>
            <li class="active">Menus </li>
        </ol>
    </div>
    <div class="col-md-3 padding-btn-header text-right">
        @can('create')
        <a href="{{ Route('menu.create') }}" class="btn btn-success btn-sm">Novo Menu</a>
        @else
        <a href="javascript:;" class="btn btn-success btn-sm disabled alert-action">Novo Menu</a>
        @endcan
    </div>
</div>

@endsection @section('content')

<div class="row">
    <div class="col-md-8">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Menus cadastradas</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i>  </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="results">
                            <thead>
                                <tr>
                                    <td width="10"><input type="checkbox" name="excludeAll"></td>
                                    <td>Name</td>
                                    <td width="200">Template</td>
                                    <td width="300">Usage</td>
                                    <td width="150">Criado em:</td>
                                    <td width="150">Atualizado em:</td>
                                    <td width="50">Administrar</td>
                                    <td width="50">Editar</td>
                                </tr>
                            </thead>
                            <tbody>
                                @can('edit')
                                @foreach ($menus as $menu)
                                    <tr>
                                        <td><input type="checkbox" name="exclude" value="{{ $menu->id }}"> </td>
                                        <td>{{ $menu->name }}</td>
                                        <td>{{ $menu->template }}</td>
                                        <td>&#123;&#123; OlCmsMenu::show('{{$menu->alias}}') &#125;&#125; 	 	</td>
                                        <td>{{ $menu->created_at }}</td>
                                        <td>{{ $menu->updated_at }}</td>
                                        <td width="50" class="text-center">
                                            <a href="{{ Route('menu-items.show', ['alias' => $menu->alias]) }}" class="btn btn-sm btn-flat btn-info">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            @include('admin.includes.btn_edit', ['route' => route('menu.edit', ['id' => $menu->id])])
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                @foreach ($menus as $menu)
                                    <tr>
                                        <td><input type="checkbox" name="exclude" value="{{ $menu->id }}"> </td>
                                        <td>{{ $menu->name }}</td>
                                        <td>{{ $menu->template }}</td>
                                        <td></td>
                                        <td>{{ $menu->created_at }}</td>
                                        <td>{{ $menu->updated_at }}</td>
                                        <td width="50" class="text-center">
                                        <a href="javascript:;" class="btn btn-sm btn-flat btn-info">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        </a>
                                        </td>
                                        <td class="text-center">
                                            @include('admin.includes.btn_edit_disabled', ['route' => route('menu.edit', ['id' => $menu->id])])
                                        </td>
                                    </tr>
                                @endforeach
                                @endcan
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<input name="route_create" value="{{ Route('menu.create') }}" type="hidden">
<input name="route_delete" value="/admin/menu/destroy/" type="hidden">
<input name="route_status" value="/admin/menu/status/" type="hidden">
@endsection
@push('style')
<!-- Adicional Styles -->
<link rel="stylesheet" href="{{ asset('assets/theme-admin/css/plugins/OLForm/OLForm.css') }}">
@endpush
@push('script')
<!-- Adicional Scripts -->
<script src="{{ asset('assets/theme-admin/js/plugins/OLForm/OLForm.jquery.js') }}"></script>
<!-- exclude -->
<script src="{{ asset('assets/theme-admin/js/plugins/OLForm/OLExclude.jquery.js') }}"></script>
<script>
$("#templates").OLForm({listErrorPosition: 'after', listErrorPositionBlock: '.modal-header', btn : true}, locationIn);
function locationIn(a){ window.location = $("input[name=route_create]").val() }
/*Exclude*/
$("#results").OLExclude({'action' : $("input[name=route_delete]").val(), 'inputCheckName' : 'exclude', 'inputCheckAll' : 'excludeAll'});

$(document).on("click", "a.btn-status:not(.disabled)", function(){
    var $this = $(this),
    _url  = $("input[name=route_status]").val(),
    _id = $this.attr("data-id"),
    _status = $this.attr("data-status");
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $("meta[name=csrf-token]").attr("content") } });
    $.ajax({
        data: {'id' : _id, 'status' : _status},
        method: 'PUT',
        url: _url,
        beforeSend: function() {
            $this.addClass("disabled");
        },
        success: function(exr) {
            toggleStatus($this, _status);
        },
        error: function(exr, sender) {
            console.log(exr);

        },
        complete: function() {
            //$this.removeClass("disabled");
        },
    });
});

function toggleStatus($this, status){
    if(status == 1){
        $this.attr("class", "btn btn-default btn-sm btn-status")
             .attr("data-status", 0)
             .attr("title", "Colocar Online?");
    }else{
        $this.attr("class", "btn btn-primary btn-sm btn-status")
             .attr("data-status", 1)
             .attr("title", "Colocar Offline?");
    }
}

</script>

@endpush
