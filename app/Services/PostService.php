<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostService
{

    public static function addPost($data) {

        $post = new Post();

        if($data->hasFile('img')) {

            $image = $data->file('img');
            $image_path = $image->getPathname();
            $filename = time().'_'.preg_replace('/\s+/', '_', strtolower(self::translit($image->getClientOriginalName())));
            $tmp = $image->storeAs('/posts', $filename, 'public');
        }

        $post->title = $data['title'];
        $post->desc = $data['desc'];
        if (!empty($data['excerpt'])) {
            $post->excerpt = $data['excerpt'];
        }

        $post->meta_title = !empty($data['meta_title']) ? $data['meta_title'] : null;
        $post->meta_desc = !empty($data['meta_desc']) ? $data['meta_desc'] : null;
        $post->meta_keywords = !empty($data['keywords']) ? $data['keywords'] : null;

        $post->status = $data['radio'] ? '1' : '0';
        $post->img = $filename;

        $post->save();
        if (!empty($data['tags'])) {
            $post->tags()->attach(explode(",", $data['tags']));

            $post->refresh();
        }

//
//        $post->meta_title = $data['meta_title'];
//        $post->meta_desc = $data['meta_desc'];
//        $post->meta_keywords =$data['keywords'];
        return $post;
    }

    public static function updatePost($data, $post) {

        $post = Post::withTrashed()->where( 'slug', '=', $post->slug)->first();
        if(!isset($post)) {
            abort(404);
        }

        if (isset($data['img'])) { /*$post->img != $data['img']*/
            if (Storage::disk('public')->exists('/posts/'.$post->img)) {

                Storage::disk('public')->delete('/posts/'.$post->img);

                $image = $data->file('img');
                $image_path = $image->getPathname();
                $filename = time().'_'.preg_replace('/\s+/', '_', strtolower(self::translit($image->getClientOriginalName())));
                $tmp = $image->storeAs('/posts', $filename, 'public');

                $post->img = $filename;
            }
        }

        $post->meta_title = $data['meta_title'];
        $post->meta_desc = $data['meta_desc'];
        $post->meta_keywords = $data['keywords'];

        $post->title = $data['title'];
        $post->desc = $data['desc'];
        $post->excerpt = $data['excerpt'];
        $post->status = $data['radio'] ? '1' : '0';
        $post->save();

        $post->tags()->sync(json_decode($data['tags'], true));//replace1

            //replace1
//        if (empty($data['tags'])) {
//            $post->tags()->detach();
//        } else {
//            //$post->tags()->sync(explode(",", $data['tags']));
//            $post->tags()->sync($data['tags']);
//        }

        return $post;
    }

    public static function translit($str)
    {
        $tr = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
            "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
            "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"'","э"=>"e","ю"=>"yu","я"=>"ya",
            " "=>"_","?"=>"_","/"=>"_","\\"=>"_",
            "*"=>"_",":"=>"_","*"=>"_","\""=>"_","<"=>"_",
            ">"=>"_","|"=>"_"
        );
        return strtr($str,$tr);
    }

}
