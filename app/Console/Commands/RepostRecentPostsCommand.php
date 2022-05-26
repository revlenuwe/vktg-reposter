<?php

namespace App\Console\Commands;

use App\Services\RepostManager;
use Illuminate\Console\Command;

class RepostRecentPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reposter:recent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repost recent VK Groups posts to Telegram Channels';

    protected $repostManager;

    /**
     * Create a new command instance.
     *
     * @param RepostManager $repostManager
     */
    public function __construct(RepostManager $repostManager)
    {
        $this->repostManager = $repostManager;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->repostManager->massRepost();
    }
}
