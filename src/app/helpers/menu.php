<?php namespace Redooor\Redminstore\App\Helpers;

class Menu
{
    public static function rePrint($menus, $class = null)
    {
        echo '<ul' . ($class ? ' class="' . $class . '"' : '') . '>';
        
        foreach ($menus as $menu) {
            if  (!$menu['hide']) {
                if  (!array_key_exists('path', $menu)) {
                    echo '<li><span>' . \Lang::get('redminstore::menus.' . $menu['name']) . '</span>';
                } else if ($menu['path'] == '') {
                    echo '<li><span>' . \Lang::get('redminstore::menus.' . $menu['name']) . '</span>';
                } else {
                    if (\Request::is($menu['path']) or \Request::is($menu['path'] . '/*')) {
                        echo '<li class="active">';
                    } else {
                        echo '<li>';
                    }
                    echo '<a href="' . \URL::to($menu['path']) . '">' . \Lang::get('redminstore::menus.' . $menu['name']) . '</a>';
                }
                // If got children menu
                if  (array_key_exists('children', $menu)) {
                    RHelper::printMenu($menu['children']);
                }
                echo '</li>';
            }
        }
        echo '</ul>';
    }
}
