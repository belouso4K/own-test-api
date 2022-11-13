<?php

namespace App\Observers;

use App\Models\Tag;

class AdminTagObserver
{
    /**
     * Handle the Tag "created" event.
     *
     * @param  \App\Models\Tag  $tag
     * @return void
     */
    public function creating(Tag $tag)
    {
       if($tag->isDirty('slug')) {
           $tag->slug = \Str::slug($tag->tag);
           $check = Tag::where('slug', '=', $tag->slug)->exists();
           if ($check) {
               $tag->slug = \Str::slug($tag->tag) . time();
           }
       }
    }

    public function created(Tag $tag)
    {
        //
    }

    /**
     * Handle the Tag "updated" event.
     *
     * @param  \App\Models\Tag  $tag
     * @return void
     */
    public function updated(Tag $tag)
    {
        //
    }

    /**
     * Handle the Tag "deleted" event.
     *
     * @param  \App\Models\Tag  $tag
     * @return void
     */
    public function deleted(Tag $tag)
    {
        //
    }

    /**
     * Handle the Tag "restored" event.
     *
     * @param  \App\Models\Tag  $tag
     * @return void
     */
    public function restored(Tag $tag)
    {
        //
    }

    /**
     * Handle the Tag "force deleted" event.
     *
     * @param  \App\Models\Tag  $tag
     * @return void
     */
    public function forceDeleted(Tag $tag)
    {
        //
    }
}
