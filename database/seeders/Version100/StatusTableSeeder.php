<?php

use App\Models\Status;
use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class StatusTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Auto generated seed file
     * developed by developer samile (samileking9@gmail.com)
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'slug' => 'reported',
                'name' => 'Reported',
                'color_class' => 'bg-yellow-100',
                'text_color_class' => 'text-yellow-800'
            ],
            [
                'slug' => 'under_investigation',
                'name' => 'Under Investigation',
                'color_class' => 'bg-blue-100',
                'text_color_class' => 'text-blue-800'
            ],
            [
                'slug' => 'resolved',
                'name' => 'Resolved',
                'color_class' => 'bg-green-100',
                'text_color_class' => 'text-green-800'
            ],
            [
                'slug' => 'closed',
                'name' => 'Closed',
                'color_class' => 'bg-gray-100',
                'text_color_class' => 'text-gray-800'
            ],
        ];

        $this->disableForeignKeys("statuses");
        $this->delete('statuses');

        foreach ($statuses as $status) {
            Status::updateOrCreate(
                ['name' => $status['name']],
                [
                    'slug' => $status['slug'],
                    'color_class' => $status['color_class'],
                    'text_color_class' => $status['text_color_class'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $this->enableForeignKeys("statuses");
    }
}
