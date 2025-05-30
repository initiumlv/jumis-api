<?php

namespace Initium\Jumis\Api\Commands;

use Illuminate\Console\Command;

class PublishConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jumis:publish-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the Jumis API configuration file';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->call('vendor:publish', [
            '--provider' => 'Initium\Jumis\Api\JumisServiceProvider',
            '--tag' => 'config'
        ]);

        $this->info('Jumis API configuration file has been published successfully.');
        $this->info('Please set the following environment variables in your .env file:');
        $this->info('JUMIS_USERNAME=your_username');
        $this->info('JUMIS_PASSWORD=your_password');
        $this->info('JUMIS_DATABASE=your_database');
        $this->info('JUMIS_API_KEY=your_api_key');
        $this->info('JUMIS_ENDPOINT=your_endpoint');

        return self::SUCCESS;
    }
} 