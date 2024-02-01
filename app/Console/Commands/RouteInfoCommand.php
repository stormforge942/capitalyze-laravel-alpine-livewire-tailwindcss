<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use ReflectionClass;
use ReflectionException;

class RouteInfoCommand extends Command
{
    protected $signature = 'route:info {--name=} {--output=chart.jpg}';
    protected $description = 'Generates route information for charting.';

    public function handle()
    {
        $routeName = $this->option('name');
        $outputPath = $this->option('output');

        $routes = Route::getRoutes();
        $routeInfo = $this->getRouteInformation($routes, $routeName);

        // Convert data to DOT format
        $dotContent = $this->convertToDot($routeInfo);

        // Define the output file path for the image
        $outputFile = base_path($outputPath);
        
        // Use the Graphviz 'dot' command to generate the image file from DOT content
        $process = new Process(['dot', '-Tjpg', '-o', $outputFile]);
        $process->setInput($dotContent);

        try {
            $process->mustRun();
            $this->info("Chart image has been successfully generated: {$outputFile}");
        } catch (ProcessFailedException $exception) {
            $this->error($exception->getMessage());
        }
    }

    protected function getRouteInformation($routes, $routeName)
    {
        $routeInfo = [];

        foreach ($routes as $route) {
            if ($route->getName() === $routeName) {
                $action = $route->getActionName();
                if (strpos($action, '@') === false) {
                    $reflector = new ReflectionClass($action);
                    $routeInfo[] = [
                        'uri' => $route->uri(),
                        'name' => $route->getName(),
                        'middleware' => $route->middleware(),
                        'controller' => $action,
                        'file' => $reflector->getFileName(),
                        'view' => $this->getLivewireView($reflector),
                    ];
                }
            }
        }

        return $routeInfo;
    }

    protected function getLivewireView(ReflectionClass $reflector)
    {
        $viewName = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $reflector->getShortName()));
        $viewFilePath = resource_path("views/livewire/{$viewName}.blade.php");
        
        if (!file_exists($viewFilePath)) {
            $this->error("View file for {$viewName} not found in the expected location: {$viewFilePath}");
        }
        
        $components = $this->getViewComponents($viewName);

        return [
            'name' => "{$viewName}.blade.php",
            'file' => $viewFilePath,
            'children' => $components
        ];
    }

    protected function getViewComponents($viewName)
    {
        $viewFilePath = resource_path("views/livewire/{$viewName}.blade.php");
        
        $viewContent = file_exists($viewFilePath) ? file_get_contents($viewFilePath) : null;
        if (!$viewContent) return [];
        
        preg_match_all('/<livewire:([^\s\/>]+)(\s[^>]*?)?>/', $viewContent, $matches, PREG_SET_ORDER);
        $componentsInfo = [];
        
        foreach ($matches as $match) {
            $componentTag = $match[1];
            $componentClass = $this->livewireTagToClass($componentTag);
            
            try {
                $reflector = new ReflectionClass($componentClass);
                $componentsInfo[] = [
                    'tag' => $match[0],
                    'class' => $componentClass,
                    'file' => $reflector->getFileName(),
                ];
            } catch (ReflectionException $e) {
                $this->error("Error reflecting Livewire component: " . $e->getMessage());
            }
        }

        return $componentsInfo;
    }

    private function livewireTagToClass($tag)
    {
        $className = str_replace([':', '-', '.'], ' ', $tag);
        $className = str_replace(' ', '', ucwords($className));
        return "App\\Http\\Livewire\\$className";
    }

    protected function convertToDot(array $routeInfo)
    {
        $dot = "digraph G {\n";
        $dot .= "    rankdir=LR;\n";
        $dot .= "    node [shape=box, style=filled, fillcolor=lightgrey];\n";
        
        foreach ($routeInfo as $route) {
            $controllerName = addslashes($route['controller']);

            // Create nodes and edges for the DOT graph
            $dot .= "    \"{$route['name']}\" [label=\"Route: {$route['name']}\", fillcolor=\"#a2d9ce\"];\n";
            $dot .= "    \"{$controllerName}\" [label=\"Controller: {$controllerName}\"];\n";
            $dot .= "    \"{$route['name']}\" -> \"{$controllerName}\";\n";

            $viewName = addslashes($route['view']['name']);
            $dot .= "    \"$viewName\" [label=\"View: {$viewName}\", fillcolor=\"#aed6f1\"];\n";
            $dot .= "    \"{$controllerName}\" -> \"$viewName\";\n";

            foreach ($route['view']['children'] as $childComponent) {
                $className = addslashes($childComponent['class']);
                $tagName = addslashes($childComponent['tag']);
            
                // Add Livewire attributes if present in the tag
                $attributes = '';
                if (isset($childComponent['attributes'])) {
                    foreach ($childComponent['attributes'] as $attributeName => $attributeValue) {
                        $attributes .= "{$attributeName}=\"{$attributeValue}\" ";
                    }
                    $attributes = addslashes(trim($attributes));
                }
            
            // Split the string at each colon
            $parts = explode(':', $tagName);

            // Keep only the first two parts (if available) and rejoin them with a colon
            $tagName = isset($parts[1]) ? $parts[0] . ':' . $parts[1] : $parts[0];

            // Rest of your code for adding < and /> if needed
            if (substr($tagName, 0, 1) !== '<') {
                $tagName = "<" . $tagName;
            }

            if (substr($tagName, -2) !== '/>') {
                $tagName .= '/>';
            }

            $label = ($attributes !== '') ? "Component: {$className}\nTag: {$tagName} {$attributes}" : "Component: {$className}\nTag: {$tagName}";

                            
                $dot .= "    \"$className\" [label=\"$label\", fillcolor=\"#abebc6\"];\n";
                $dot .= "    \"$viewName\" -> \"$className\";\n";
            }
        }
        
        return $dot . "}\n";
    }
}