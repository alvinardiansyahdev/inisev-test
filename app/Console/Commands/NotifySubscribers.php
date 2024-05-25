<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifySubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribers:notify';

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
        $users = User::with([
            'subscriptions.posts' => function ($query) {
                $query->where('notified_to_user', false);
            }
        ])->get();

        dispatch(function () use ($users) {
            $users->each(function ($user) {
                $user->subscriptions->each(function ($subscription) use ($user) {
                    $subscription->posts->each(function ($post) use ($user, $subscription) {
                        $post->notify(
                            user: $user,
                            website: $subscription
                        );
                    });
                });
            });
        });
    }
}
