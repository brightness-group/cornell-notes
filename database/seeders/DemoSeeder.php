<?php

namespace Database\Seeders;

use App\Models\DemoFolder;
use App\Models\DemoNote;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DemoNote::truncate();
        DemoFolder::truncate();

        foreach (config('diligentnotes.demo.folder') as $value) {
            $folder = DemoFolder::create(['name' => $value['name'], 'welcome' => $value['welcome']]);

            foreach ($value['note'] as $note) {
                $folder->notes()->create([
                    'title' => $note['title'],
                    'content' => $note['content'],
                    'welcome' => $value['welcome']
                ]);
            }
        }
    }
}
