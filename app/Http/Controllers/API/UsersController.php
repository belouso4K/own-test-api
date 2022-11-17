<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('show');
    }

    public function show( Request $request ){
        return new UserResource(auth()->user());
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50|string',
            'email' => 'required|email',
            'new_password' => 'required_with:new_password',
            'existing_password' => 'sometimes|string|min:6',
            'confirm_password' => 'sometimes|same:new_password'
        ]);

        $user = $request->user();

        if ($user->avatar != $request['avatar']) {
            if (Storage::disk('public')->exists('/avatar/'.$user->avatar)) {
                if ($user->avatar !== 'avatar.png') {
                    Storage::disk('public')->delete('/avatar/'.$user->avatar);
                }

                $image = $request->file('avatar');
                $image_path = $image->getPathname();
                $filename = time().'_'.preg_replace('/\s+/', '_', strtolower(self::translit($image->getClientOriginalName())));
                $tmp = $image->storeAs('/avatar', $filename, 'public');

                $user->avatar = $filename;
            }
        }

        if (Hash::check($request['existing_password'], $user->password)) {
            $user->password = bcrypt($request['new_password']);
        }

        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->save();

        if ($user) {
            return response()->json($user, 200);

        } else {
            return response()->json($user, 500);
        }
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

//    public function getUser(){
//        return Auth::guard('api')->user();
//    }
}
