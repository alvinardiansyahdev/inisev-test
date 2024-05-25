<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Mail;

class Post extends Model
{
    protected $fillable = [
        'website_id',
        'title',
        'content'
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function notify(User $user, Website $website)
    {
        return Mail::raw($this->content, function ($message) use ($user, $website) {
            $message->subject($this->title)
                ->to($user->email)
                ->from(str_replace('www.', 'subscription@', $website->url));
        });
    }
}
