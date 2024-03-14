<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Redis;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use RecursiveRegexIterator;

class CacheManagement extends Component
{

    public $results = [];

    public function mount()
    {
        $results = [];

        $directory = new RecursiveDirectoryIterator(base_path('app'));
        $iterator = new RecursiveIteratorIterator($directory);
        $phpFiles = new RegexIterator($iterator, '/^.+\.php$/i', RegexIterator::GET_MATCH);

        foreach ($phpFiles as $file) {
            $filePath = $file[0];
            $content = file_get_contents($filePath);

            if (preg_match_all('/\$cacheKey\s*=\s*([^;]+)/', $content, $matches, PREG_OFFSET_CAPTURE)) {
                foreach ($matches[1] as $match) {
                    $assignmentFull = $match[0];
                    $lineNumber = substr_count(substr($content, 0, $match[1]), "\n") + 1; 
                    
                    $firstSpecialCharPos = strcspn($assignmentFull, "{ .");
                    $assignmentPrefix = $firstSpecialCharPos !== strlen($assignmentFull) ? 
                                        substr($assignmentFull, 0, $firstSpecialCharPos) : 
                                        $assignmentFull;

                    $results[] = [
                        'filePath' => $filePath,
                        'lineNumber' => $lineNumber,
                        'assignment' => $assignmentFull,
                        'assignmentPrefix' => $assignmentPrefix,
                    ];
                }
            }
        }

        $this->results = $results;
    }

    
    public function clearCacheByPrefix($prefix)
    {
        $decodedPrefix = html_entity_decode($prefix);
        $decodedPrefix = trim($decodedPrefix, "'");

        $pattern = $decodedPrefix . '*';
        $keys = Redis::connection()->select(1); 
        $keys = Redis::keys($pattern);
        foreach ($keys as $key) {
            Redis::del($key);
        }
    
        $formattedPattern = ucwords(trim(str_replace('_', ' ', trim(trim($decodedPrefix, '_'))), " \t\n\r\0\x0B"));
        session()->flash('message', "Cache cleared successfully for {$formattedPattern}");
        
    }
    
    
    public function clearAllCache()
    {
        foreach ($this->results as $result) {
            $prefix = $result['assignmentPrefix'];

            $decodedPrefix = html_entity_decode($prefix);
            $decodedPrefix = trim($decodedPrefix, "'");
            // Your logic to clear cache by prefix here
            $pattern = $decodedPrefix . '*';
            $keys = Redis::connection()->select(1); 
            $keys = Redis::keys($pattern);
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    
        session()->flash('message', 'All caches cleared successfully.');
    }
    
    

    

    public function render()
    {
        return view('livewire.admin.cache-management', ['results' => $this->results ?? []]);
    }
}
