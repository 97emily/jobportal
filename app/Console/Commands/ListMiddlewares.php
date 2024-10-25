<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Router;

class ListMiddlewares extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'middleware:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all registered middlewares';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param Router $router
     * @return mixed
     */
    public function handle(Router $router)
    {
        $this->info('Global Middleware:');
        foreach ($router->getMiddleware() as $name => $middleware) {
            $this->line("  - {$name}: {$middleware}");
        }

        $this->info('Route Middleware:');
        foreach ($router->getMiddlewareGroups() as $group => $middlewares) {
            $this->line("  - Group: {$group}");
            foreach ($middlewares as $middleware) {
                $this->line("    - {$middleware}");
            }
        }

        $this->info('Middleware Aliases:');
        foreach ($router->getMiddleware() as $alias => $middleware) {
            $this->line("  - {$alias}: {$middleware}");
        }
    }
}
