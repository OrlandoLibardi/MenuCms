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
                <a href="{{ Route('menu.index') }}">Paínel de controle</a>
            </li>
            <li class="active">
                {{ $menu->name }}
            </li>    
        </ol>
    </div>
    <div class="col-md-3 padding-btn-header text-right">
       
    </div>
</div>

@endsection @section('content')

<div class="row">
    <div class="col-md-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Criar Items</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i>  </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                        {!! Form::open(['route' => 'menu.store', 'method' => 'POST', 'id' => 'form-menu']) !!}
                        <input type="hidden" name="item_id" value="">
                        <div class="col-md-12">
                            <div class="form-group" style="position:relative">
                                <label><span class="text-red">*</span> Título</label>
                                <input type="text" name="title" placeholder="Título..." class="form-control typeahead" data-provide="typeahead" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><span class="text-red">*</span> Url</label>
                                {!! Form::text('url', null, ['placeholder' =>
                                'Título...','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><span class="text-red">*</span> Target</label>
                                <select name="target" class="form-control">
                                    <option value="1">Mesma Janela</option>
                                    <option value="2">Nova Janela</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-sm btn-flat btn-primary btn-add">Adicionar</button>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 my-area" id="sortable">
        
    </div>
    <div class="col-md-4">

        <input type="text" class="form-control" name="real_id" placeholder="id">
        <input type="text" class="form-control" name="real_title" placeholder="title">
        <input type="text" class="form-control" name="real_url" placeholder="url">
        <input type="text" class="form-control" name="real_target"  placeholder="target">
        
        {!! Form::open(['route' => 'menu.store', 'method' => 'POST', 'id' => 'form-menu']) !!}
        <input type="text" class="form-control" name="real_order"  placeholder="order">
        {!! Form::close() !!}
        
    </div>
</div>
@endsection
@push('style')
<!-- Adicional Styles -->
<link rel="stylesheet" href="{{ asset('assets/theme-admin/css/plugins/OLForm/OLForm.css') }}">
<link rel="stylesheet" href="{{ asset('assets/theme-admin/js/plugins/jquery-ui/jquery-ui.css') }}">
<style>
.typeahead { z-index: 1051; }
ul.typeahead.dropdown-menu{
    width: 100%;
    border-radius:0px;
}
ul.typeahead.dropdown-menu li.active a{
    background: none;
    color: #999;
}
.my-area{
    padding: 25px;
    height: 100%;
    min-height: 500px;
    border: 2px dashed #dee2e6;
}
.my-area > .ibox{
    margin-bottom: 5px !important; 
}
h5.take-it{
    cursor: all-scroll;
}
.ibox-tools {
    display: inline-block;
    float: right;
}


.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active{
    border: none;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default{
    border: none;
}
</style>
@endpush
@push('script')
<!-- Adicional Scripts -->
<script src="{{ asset('assets/theme-admin/js/plugins/OLForm/OLForm.jquery.js') }}"></script>
<script src="{{ asset('assets/theme-admin/js/plugins/bootstrap3-typeahead/bootstrap3-typeahead.js') }}"></script>
<script src="{{ asset('assets/theme-admin/js/plugins/jquery-ui/jquery-ui.js') }}"></script>
<script>
 
 $area = $('#sortable');
 $area.sortable({
    start : function(event, ui) {
        var start_pos = ui.item.index();
        ui.item.data('start_pos', start_pos);
    },
    update : function(event, ui) {
        var index = ui.item.index();
        var start_pos = ui.item.data('start_pos');
        //update the html of the moved item to the current index
        $('#sortable div.ibox:nth-child(' + (index + 1) + ')').attr('data-order', index);
        
        if (start_pos < index) {
            //update the items before the re-ordered item
            for(var i=index; i > 0; i--){
                $('#sortable div.ibox:nth-child(' + i + ')').attr('data-order', i-1);
            }
        }else {
            //update the items after the re-ordered item
            for(var i=index+2;i <= $("#sortable div.ibox").length; i++){
                $('#sortable div.ibox:nth-child(' + i + ')').attr('data-order', i-1);
            }
        }

        sendOrder();
    },
    axis : 'y'
});

var $input = $(".typeahead");
$input.typeahead({
  source: [
    {name: "home", url: "/home"},
    {name: "empresa", url: "/empresa"}
  ],
  autoSelect: true
});

$input.change(function() {
  var current = $input.typeahead("getActive");
  if (current) 
  {
    if (current.name == $input.val()) 
    {
      $("input[name=url]").val(current.url)
    } 
  } 
});

$(document).on("click", "button.btn-add", function(){
    save();
});

function save()
{
    var data = {
        title : $("input[name=title]").val(),
        url   : $("input[name=url]").val(),
        target : $("select[name=target]").val(),
        order : countOrder(),
        id: findMaxid()
    };

    clearInputs();

    var obj = template(data);
    $area.append(obj);
}

function clearInputs(){
    $("input[name=title]").val('');
    $("input[name=url]").val('');
}

function countOrder()
{
    var order = 0;
    $area.find('.ibox').each(function(){
        order++;
    });
    return order;
}

function template(data)
{
    obj = '';
    obj = '<!-- item -->';
    obj += '<div class="ibox float-e-margins border-bottom ui-state-default" data-order="'+data.order+'" data-id="'+data.id+'">';
        obj += '<div class="ibox-title">';
            obj += '<h5 class="take-it">'+data.title+'</h5>';
            obj += '<div class="ibox-tools">';
                obj += '<a class="collapse-link"> <i class="fa fa-chevron-down"></i>  </a>';
            obj += '</div>';
        obj += '</div>';
        obj += '<div class="ibox-content" style="display:none;">';
            obj += '<div class="row">';
                obj += '<div class="col-md-12">';
                    obj += '<div class="form-group" style="position:relative">';
                        obj += '<label><span class="text-red">*</span> Título</label>';
                        obj += '<input type="text" name="title" data-id="'+data.id+'" placeholder="Título..." class="form-control" value="'+data.title+'">';
                    obj += '</div>';
                    obj += '<div class="form-group">';
                        obj += '<label><span class="text-red">*</span> Url</label>';
                        obj += '<input type="text" name="url" data-id="'+data.id+'" class="form-control" value="'+data.url+'">';
                    obj += '</div>';
                        obj += '<div class="form-group">';
                            obj += '<label><span class="text-red">*</span> Target</label>';
                            obj += '<select name="target" data-id="'+data.id+'" class="form-control">';
                                obj += '<option value="1" '+data.selected+'>Mesma Janela</option>';
                                obj += '<option value="2" '+data.selected+'>Nova Janela</option>';
                            obj += '</select>';
                        obj += '</div>';
                        obj += '<button class="btn btn-sm btn-flat btn-primary btn-edit" data-id="'+data.id+'">Atualizar</button>';
                        obj += '<button class="btn btn-sm btn-flat btn-danger btn-delete pull-right" data-id="'+data.id+'">Excluir</button>';
                obj += '</div>';
            obj += '</div>';
        obj += '</div>';
    obj += '</div>';        
    obj += '<!-- ./item -->';
    return obj;
}

function findMaxid()
{
    var maior = 0;
    $area.find('.ibox').each(function(){
        if($(this).attr("data-id") >= maior){
            maior = parseInt($(this).attr("data-id"))+1;
        };
    });
    return maior;
}


function sendOrder(){
    $area.find('.ibox').each(function(){
        console.log($(this).attr("data-id"), $(this).attr("data-order"));
    });
}

</script>

@endpush
