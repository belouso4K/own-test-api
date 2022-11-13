<?php

namespace App\Observers;

use App\Models\Post;

class AdminPostObserver
{
    public function creating(Post $post)
    {
        $this->getAlias($post);
    }

    public function created(Post $post)
    {
        //
    }

    public function updating(Post $post)
    {
        if ($post->isDirty('title')) {

            $post->slug = \Str::slug($post->title);
            $check = Post::where('slug', '=', $post->slug)->exists();
            if ($check) {
                $post->slug = \Str::slug($post->title) . time();
            }
        }

    }

    public function deleting(Post $post)
    {
//        dd('fffff');
        $post->update(['status' => '0']);
    }

    public function deleted(Post $post)
    {
//        $post->update(['status' => '0']);
    }

    public function restored(Post $post)
    {
        //
    }

    public function forceDeleted(Post $post)
    {

    }

    public function getAlias(Post $post)
    {
        if (empty($post->slug)) {
            $post->slug = \Str::slug($post->title);
            $check = Post::where('slug', '=', $post->slug)->exists();
            if ($check) {
                $post->slug = \Str::slug($post->title) . time();
            }
        }
    }
}
