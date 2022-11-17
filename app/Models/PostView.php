<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{

    protected $table = 'post_views';

    public function postView()
    {
        return $this->belongsTo(Post::class);
    }

    public static function createViewLog($post) {
        $postViews = new PostView();
        $postViews->post_id = $post->id;
        $postViews->url = request()->url();
        $postViews->session_id = request()->getSession()->getId();
        $postViews->user_id = (auth()->check())?auth()->id():null;
        $postViews->ip = request()->ip();
        $postViews->agent = request()->header('User-Agent');
        $postViews->save();
    }
}
