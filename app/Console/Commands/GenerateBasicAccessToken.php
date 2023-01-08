<?php

namespace App\Console\Commands;

use App\Models\BasicAccessToken;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateBasicAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'k-board:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create tokens for api access';

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
     * @return int
     */
    public function handle(): int
    {
        // delete all expired tokens
        BasicAccessToken::withTrashed()->where('expires_at', '>=', Carbon::now())->forceDelete();

        $hours = 2;
        $accessToken = BasicAccessToken::create([
            'token' => Str::random(45),
            'expires_at' => Carbon::now()->addSeconds($hours),
        ]);
        $this->info('Access Token successfully created!');
        $this->warn($accessToken->token);
        $this->alert("This is token expires after $hours hours");
        return Command::SUCCESS;
    }
}
