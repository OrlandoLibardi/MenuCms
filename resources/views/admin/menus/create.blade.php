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
                <a href="{{ Route('menu.index') }}">Menus</a>
            </li>
            <li class="active">Criar um Menu </li>
        </ol>
    </div>
    <div class="col-md-3 padding-btn-header text-right">
        <a href="javascript:savePageTemplate();" class="btn btn-primary btn-sm salvar">Salvar</a>
        <a href="{{ Route('menu.index') }}" class="btn btn-warning btn-sm">Voltar</a>
    </div>
</div>

@endsection @section('content')
<div class="row">
<div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Dados da postagem</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    @if(isset($menu))
                    {!! Form::open(['route' => ['menu.update', 'id' => $menu->id], 'method' => 'PUT', 'id' =>
                    'form-menu']) !!}
                    {!! Form::hidden('id', $menu->id) !!}
                    @else
                    {!! Form::open(['route' => 'menu.store', 'method' => 'POST', 'id' => 'form-menu']) !!}
                    @endif
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><span class="text-red">*</span> Nome</label>
                            {!! Form::text('name', isset($menu) ? $blog->name : null, ['placeholder' =>
                            'Título...','class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><span class="text-red">*</span> Template</label>
                            {!! Form::textarea('template', isset($menu) ? $menu->content : null, ['placeholder' =>
                            'Escreva aqui...','class' => 'form-control', 'id' => 'template']) !!}                            
                        </div>
                        <a class="btn btn-success btn-sm btn-flat btn-set-default" href="javascript:loadTemplate();">Default template</a>
                        <a class="btn btn-success btn-sm btn-flat btn-set-default" href="javascript:boostrapTemplate();">Bootstrap template</a>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('style')
<!-- Adicional Styles -->
<link rel="stylesheet" href="{{ asset('assets/theme-admin/css/plugins/OLForm/OLForm.css') }}">
<!--CodeMirror-->
<link rel="stylesheet" href="{{ asset('assets/theme-admin/js/plugins/codemirror/codemirror.css') }}">
<link rel="stylesheet" href="{{ asset('assets/theme-admin/js/plugins/codemirror/duotone-dark.css') }}">
@endpush
@push('script')
<!-- Adicional Scripts -->
<script src="{{ asset('assets/theme-admin/js/plugins/OLForm/OLForm.jquery.js') }}"></script>
<script src="{{ asset('assets/theme-admin/js/plugins/codemirror/codemirror.js') }}"></script>
<script src="{{ asset('assets/theme-admin/js/plugins/codemirror/mode/clike/clike.js') }}"></script>
<script>
var editor_config = {lineNumbers: true, selectionPointer: true, theme: 'duotone-dark', mode: "text/x-csrc"};
var editor = CodeMirror.fromTextArea(document.getElementById("template"), editor_config);

$(document).ready(function(){
    /*Formulário*/
    $("#form-menu").OLForm({btn : true, listErrorPosition: 'after', listErrorPositionBlock: '.page-heading'}); 

});
    function loadTemplate()
    {
        var obj = '<ul>' + "\n";
            obj += '  foreach( __items as __item )'+ "\n";
            obj += '   <li>'+ "\n";
            obj += '     <a href="[ __item->url ]" title="[ __item->title ]" target="[ __item->target ]" class="link">'+ "\n";
            obj += '      [ __item->title ]'+ "\n";
            obj += '     </a>'+ "\n";
            obj += '   </li>'+ "\n";
            obj += '  endforeach'+ "\n";
            obj += '</ul>'+ "\n";

            editor.getDoc().setValue(obj);    
    }

    function boostrapTemplate()
    {
        obj = '<!-- bootstrap model -->'+ "\n";
        obj += '<nav class="navbar navbar-expand-lg navbar-light bg-light">'+ "\n";
        obj += ' <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"'+ "\n";
        obj += 'aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">'+ "\n";
        obj += '  <span class="navbar-toggler-icon"></span>'+ "\n";
        obj += ' </button>'+ "\n";
        obj += ' <div class="collapse navbar-collapse" id="navbarSupportedContent">'+ "\n";
        obj += '  <ul class="navbar-nav mr-auto">'+ "\n";
        obj += '  foreach( __items as __item )'+ "\n";
        obj += '   if(count(__item->childs)>0)'+ "\n";
        obj += '   <!-- sub items -->'+ "\n";
        obj += '   <li class="nav-item dropdown">'+ "\n";
        obj += '    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"'+ "\n";
        obj += 'aria-haspopup="true" aria-expanded="false">'+ "\n";
        obj += '     [ __item->title ]'+ "\n";
        obj += '    </a>'+ "\n";
        obj += '    <div class="dropdown-menu" aria-labelledby="navbarDropdown">'+ "\n";
        obj += '     foreach(__item->childs as __child)'+ "\n";
        obj += '     <!-- sub item list-->'+ "\n";
        obj += '     <a class="dropdown-item" href="[__child->url ]">[__child->title ]</a>'+ "\n";
        obj += '     endforeach'+ "\n";
        obj += '    </div>'+ "\n";
        obj += '   </li>'+ "\n";
        obj += '   else'+ "\n";
        obj += '    <li class="nav-item">'+ "\n";
        obj += '     <a class="nav-link" href="[ __item->url ]">[ __item->title ]</a>'+ "\n";
        obj += '    </li>'+ "\n";
        obj += '  endif'+ "\n";
        obj += '  endforeach'+ "\n";
        obj += '  </ul>'+ "\n";
        obj += ' </div>'+ "\n";
        obj += '</nav>'+ "\n";
        obj += '<!-- ./bootstrap model -->'+ "\n";
        editor.getDoc().setValue(obj); 
    }

    function savePageTemplate(){
        $("textarea[name=template]").val(editor.getDoc().getValue());
        $("#form-menu").submit();
    }

</script>
@endpush
