<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:update-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = \App\Models\Product::all();

        $images = ["assets/images/users/pic4.jpg", "assets/images/users/pic2.jpg", "assets/images/users/pic8.jpg"];
        foreach ($products as $product) {
            $product->update([
                'date' => now()->format('Y-m-d'),
                'client_name' => "Carmine Pasquarelli",
                'client_image' => $images[array_rand($images)],
                'deadline_date' => now()->addDays(8)->format('Y-m-d'),
                'status' => 'Progress'
            ]);
        }

        $this->info('Products updated successfully!');
    }
}
