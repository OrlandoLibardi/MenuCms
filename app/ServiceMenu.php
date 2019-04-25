<?php
namespace OrlandoLibardi\MenuCms\app;
use File;
use OrlandoLibardi\MenuCms\app\Menu;

class ServiceMenu
{

    /**
     * Lê o arquivo de configuração de páginas e retorna o caminho para salvar templates de menu
     */
    public static function getMenuPath()
    {
        return config('pages.page_path') . "/menus/";
    }
    /**
     * Salva o arquivo
     */
    public static function save($name, $content, $id=false)
    {
        $new_content = self::prepareTemplateBlade($content);
        if($id==false){
            $file = self::name($name);
        }else
        {
            $q = Menu::find($id)->first();
            $file = $q->template;
        }
        //salva o novo arquivo na pasta final
        File::put(self::getMenuPath() . $file, $new_content); 
        return $file;
    }
    /**
     * Cria um nome para o arquivo
     */
    public static function name($name)
    {
        return str_slug($name) . ".blade.php";
    }
    /**
     *  Retorna o template para visualização do usuário
     */
    public static function loadTemplate($template)
    {
        return self::prepareTemplateView( File::get( self::getMenuPath() . $template ) );
    } 
    /**
     *  Retorna o template para visualização do usuário
     */
    public static function deleteTemplate($template)
    {
        return File::delete( self::getMenuPath() . $template );
    } 
    /**
     * Prepara para o blade
     */
    public static function prepareTemplateBlade($content)
    {
        $patterns[0] = '[';
        $patterns[1] = ']';
        $patterns[2] = 'foreach';
        $patterns[3] = 'endforeach';
        $patterns[4] = 'if';
        $patterns[5] = 'endif';
        $patterns[6] = 'else';
        $patterns[7] = '__';    
        $patterns[8] = 'end@foreach'; 
        $patterns[9] = 'end@if';       
        $replaces[0]  = '{{ ';
        $replaces[1]  = ' }}';
        $replaces[2]  = '@foreach';
        $replaces[3]  = '@endforeach';
        $replaces[4]  = '@if';
        $replaces[5]  = '@endif';
        $replaces[6]  = '@else';
        $replaces[7]  = '$';
        $replaces[8]  = '@endforeach';
        $replaces[9]  = '@endif';

        return str_replace($patterns, $replaces, $content);
    }
    /**
     * Prepara para o usuário
     */
    public static function prepareTemplateView($content)
    {
        $patterns[0] = '[';
        $patterns[1] = ']';
        $patterns[2] = 'foreach';
        $patterns[3] = 'endforeach';
        $patterns[4] = 'if';
        $patterns[5] = 'endif';
        $patterns[6] = 'else';
        $patterns[7] = '__';    
        $patterns[8] = 'end@foreach';        
        $replaces[0]  = '{{ ';
        $replaces[1]  = ' }}';
        $replaces[2]  = '@foreach';
        $replaces[3]  = '@endforeach';
        $replaces[4]  = '@if';
        $replaces[5]  = '@endif';
        $replaces[6]  = '@else';
        $replaces[7]  = '$';
        $replaces[8]  = '@endforeach';

        return str_replace($replaces, $patterns, $content);
    }
}