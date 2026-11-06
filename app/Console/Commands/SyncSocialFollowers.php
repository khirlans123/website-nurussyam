<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SocialFollowerService;

class SyncSocialFollowers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'social:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronkan jumlah pengikut (followers/subscribers) media sosial secara otomatis dari link akun resmi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai sinkronisasi pengikut media sosial...');
        $results = SocialFollowerService::syncAll();

        foreach ($results as $platform => $data) {
            $this->line("- [{$platform}]: {$data['status']} => {$data['formatted']} (raw: {$data['raw']})");
        }

        $this->info('Sinkronisasi selesai!');
        return 0;
    }
}
