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
        $status = ["Progress", "Info", "Closed", "Pending"];
        $deadValues = [8, 9, 2, 10, 20, 40, 11, 14];
        $customers = ["Carmine Pasquarelli", "Roberto Zinni", "Lemme Tartufi", "Creta Rossa", "Ilger", "Zimbra"];
        foreach ($products as $product) {
            $product->update([
                'date' => now()->format('Y-m-d'),
                'client_name' => $customers[array_rand($customers)],
                'client_image' => $images[array_rand($images)],
                'deadline_date' => now()->addDays($deadValues[array_rand($deadValues)])->format('Y-m-d'),
                'status' => $status[array_rand($status)]
            ]);
        }

        $this->info('Products updated successfully!');
    }
}
