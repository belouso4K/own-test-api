<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\AdminUserCreateRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Http\Resources\Admin\User\UserResource;
use App\Models\User;
use App\Repositories\Contracts\IUser;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;

class UsersController extends AdminController
{
    use ImageUploadTrait;

    protected $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:viewAny,'.User::class)->except(['index', 'edit']);
        $this->authorizeResource(User::class, 'user');
        $this->userRepository = app(IUser::class);
    }

    public function index()
    {
        $users = $this->userRepository
            ->getAllUsersDoesntHaveRole();
        return UserResource::collection($users);
    }

    public function create()
    {
        //
    }

    public function store(AdminUserCreateRequest $request)
    {
        $user = new User($request->all());

        if($request->hasFile('avatar')) {
            $folder = '/avatar';
            $file = $request->file('avatar');
            $fileName = $this->setImage($file, $folder);
            $user->avatar = $fileName;
        }

        $user->save();
        $user->roles()->attach($request['role_id']);

        if ($user) $this->uploadAvatar();
        return response()->json(['id' => $user->id]);
    }

    public function show(User $user)
    {

    }

    public function edit(User $user)
    {
        return new UserResource($user);
    }

    public function update(AdminUserUpdateRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request['role_id']);

        if($request->hasFile('avatar')) {
            $folder = '/avatar';
            $file = $request->file('avatar');
            $user->avatar = $this->setImage($file, $folder, $user->avatar);
            $user->save();
        }

        if ($user) $this->updateAvatar();
        return response()->json(['id' => $user->id]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }

    public function search(Request $request) {
        $query = $request->query('search');
        $users = $this->userRepository->search($query);

        return UserResource::collection($users);
    }
}
