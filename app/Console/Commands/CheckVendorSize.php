<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckVendorSize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendor:size';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the size of each library in the vendor directory';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $vendorDir = base_path('vendor'); // Đường dẫn đến thư mục vendor
        $directories = scandir($vendorDir);

        $sizes = [];

        foreach ($directories as $dir) {
            if ($dir === '.' || $dir === '..') {
                continue;
            }

            $path = $vendorDir . '/' . $dir;
            if (is_dir($path)) {
                $size = $this->folderSize($path);
                $sizes[$dir] = $size;
            }
        }

        arsort($sizes);

        $this->info("Library sizes in the vendor directory:");
        foreach ($sizes as $library => $size) {
            $this->line($library . ' - ' . $this->formatSize($size));
        }

        return Command::SUCCESS;
    }

    /**
     * Calculate the folder size recursively.
     *
     * @param string $dir
     * @return int
     */
    private function folderSize($dir)
    {
        $size = 0;
        foreach (scandir($dir) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $dir . '/' . $file;
            $size += is_dir($path) ? $this->folderSize($path) : filesize($path);
        }
        return $size;
    }

    /**
     * Format size into human-readable format.
     *
     * @param int $size
     * @return string
     */
    private function formatSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $unit = 0;
        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }
        return round($size, 2) . ' ' . $units[$unit];
    }
}
