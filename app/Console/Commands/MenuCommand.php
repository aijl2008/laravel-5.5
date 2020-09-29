<?php

namespace App\Console\Commands;

use App\Models\Rbac\Menu;
use Illuminate\Console\Command;
use Illuminate\Routing\Router;

class MenuCommand extends Command
{

    protected $signature = 'rbac:menu';
    protected $description = '导入菜单';

    public function __construct(Router $router)
    {
        parent::__construct();
        $this->router = $router;
        $this->routes = $router->getRoutes();
    }

    function handle()
    {
        if (count($this->routes) == 0) {
            return $this->error("Your application doesn't have any routes.");
        }
        foreach ($this->getRoutes() as $group => $menus) {
            $this->info("正在导入{$group}");
            $Group = new Menu([
                'name' => $group,
                'url' => '###',
                'ico' => '',
                'target' => '',
                'parent_id' => 0,
                'order_no' => 0,
                'status' => 1
            ]);
            $Group->save();
            foreach ($menus as $menu) {
                $this->info("正在导入{$menu['url']}");
                $Menu = new Menu([
                    'name' => $menu['name'],
                    'url' => $menu['url'],
                    'ico' => '',
                    'target' => '',
                    'parent_id' => $Group->id,
                    'order_no' => 0,
                    'status' => 1
                ]);
                $Menu->save();
            }
        }
        $this->info("成功");
    }

    /**
     * Compile the routes into a displayable format.
     *
     * @return array
     */
    protected function getRoutes()
    {
        $results = [];
        foreach ($this->routes as $i => $route) {
            if ($route->uri() == '/') {
                continue;
            }
            if ($route->uri() == 'dashboard') {
                continue;
            }
            if (strpos($route->uri(), '{') !== false) {
                $this->line("1.跳过" . $route->uri());
                continue;
            }
            if (strpos($route->uri(), 'rbac/') === 0) {
                $this->line("2.跳过" . $route->uri());
                continue;
            }
            if (strpos($route->uri(), 'api/') === 0) {
                $this->line("3.跳过" . $route->uri());
                continue;
            }
            if (!in_array('GET', $route->methods())) {
                $this->line("4.跳过" . $route->uri());
                continue;
            }
            $exploded = explode('/', $route->uri(), 2);
            $results[$exploded[0]][] = [
                'name' => isset($exploded[1])?$exploded[1]:$exploded[0] ,
                'url' => '/' . $route->uri()
            ];
        }
        return $results;
    }

}
