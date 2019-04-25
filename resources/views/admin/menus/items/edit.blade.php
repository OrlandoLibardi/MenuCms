@extends('admin.layout.admin') @section( 'breadcrumbs' )
<!-- breadcrumbs -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Menus</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/admin">Paínel de controle</a>
            </li>
            <li>
                <a href="{{ Route('menu.index') }}">Menu</a>
            </li>
            <li class="active">
                {{ $selected->menu->name }}
            </li>
        </ol>
    </div>
    <div class="col-md-3 padding-btn-header text-right">
            <a href="{{ Route('menu.index') }}" class="btn btn-warning btn-sm">Voltar</a>
    </div>
</div>

@endsection @section('content')

<div class="row">
    
    
    
    <div class="col-md-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Criar Items no menu</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    {!! Form::open(['route' => ['menu-items.update', 'id' => $selected->id], 'method' => 'PUT', 'id' =>
                    'form-menu']) !!}
                    <input type="hidden" name="id" value="{{ $selected->id }}">
                    <input type="hidden" name="menu_id" value="{{ $selected->menu->id }}">
                    <input type="hidden" name="order_at" value="{{ $selected->order_at }}">
                    <div class="col-md-12">
                        <div class="form-group" style="position:relative">
                            <label><span class="text-red">*</span> Título</label>
                            <input type="text" name="title" value="{{ $selected->title }}" placeholder="Título..." class="form-control typeahead"
                                data-provide="typeahead" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><span class="text-red">*</span> Url</label>
                            {!! Form::text('url', $selected->url, ['placeholder' =>
                            'Url de destino...','class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><span class="text-red">*</span> Target</label>
                            <select name="target" class="form-control">
                                <option value="1">Mesma Janela</option>
                                <option value="2">Nova Janela</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><span class="text-red">*</span> Item Parente</label>
                            <select name="parent_id" class="form-control">
                                <option value="">Selecione</option>
                                @if(!empty($items))
                                    @php $i = 1 @endphp
                                    @foreach($items as $item)
                                         @php $activeOption = ($item->parent_id==$selected->id) ? "selected" : ""; @endphp   
                                        <option value="{{ $item->id }}" {{$activeOption}}>{{$i}} {{ $item->title }}</option>
                                       
                                        @if(count($item->childs) > 0)
                                            @include('admin.menus.items.option', ['childs' => $item->childs, 'i' => $i, 'selected' => $selected->id])
                                        @endif
                                       
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                   
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    
<input name="url_return" type="hidden" value="{{ Route('menu-items.show', ['alias' => $selected->menu->alias]) }}">

</div>
@endsection
@push('style')
<!-- Adicional Styles -->
<link rel="stylesheet" href="{{ asset('assets/theme-admin/css/plugins/OLForm/OLForm.css') }}">
<style>
    .typeahead {
        z-index: 1051;
    }

    ul.typeahead.dropdown-menu {
        width: 100%;
        border-radius: 0px;
    }

    ul.typeahead.dropdown-menu li.active a {
        background: none;
        color: #999;
    }
</style>
@endpush
@push('script')
<!-- Adicional Scripts -->
<script src="{{ asset('assets/theme-admin/js/plugins/OLForm/OLForm.jquery.js') }}"></script>
<!-- typeahead -->
<script src="{{ asset('assets/theme-admin/js/plugins/bootstrap3-typeahead/bootstrap3-typeahead.js') }}"></script>
<!-- exclude -->
<script src="{{ asset('assets/theme-admin/js/plugins/OLForm/OLExclude.jquery.js') }}"></script>
<script>

    /*
    * TypeaHead - autocomplete for input title
    */    
    var all_pages = @php echo json_encode($pages) @endphp;

    var $input = $(".typeahead");
    $input.typeahead({
        source: all_pages,
        autoSelect: true
    });

    $input.change(function () {
        var current = $input.typeahead("getActive");
        if (current) {
            if (current.name == $input.val()) {
                $("input[name=url]").val( '/' + current.alias )
            }
        }
    });

    
    /*
    * Save 
    */
    $("#form-menu").OLForm({btn : false, listErrorPosition: 'after', listErrorPositionBlock: '.page-heading', urlRetun : $("input[name=url_return]").val() });
    
    function reloadPage()
    {
        window.location.href=$("input[name=url_return]").val();
    }

</script>

@endpush