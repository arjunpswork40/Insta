<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
        $postCount = Cache::remember('count.posts.' . $user->id, 
            now()->addSeconds(30), 
            function() use($user) {
                return $user->posts->count();
            }); 
        $followersCount =  Cache::remember('count.followers.' . $user->id, 
            now()->addSeconds(30), 
            function() use($user) {
                return $user->profile->followers->count();
            });     
        $followingCount = Cache::remember('count.following.' . $user->id, 
            now()->addSeconds(30), 
            function() use($user) {
                return $user->following->count();

            });     
        
        return view('profiles.index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user->profile);
        if (auth()->check()) {

            $data = $request->validate([
                'title' => 'required',
                'description' => 'required',
                'url' => 'url',
                'image' => ''
            ]);


            if ($request->has('image')) {
                $image_path = $request->image->store('profile', 'public');

                $image = Image::make(public_path("storage/{$image_path}"))->fit(1000, 1000);
                $image->save();
            }
            $profile = \App\Profile::where('user_id', auth()->user()->id)->first();
            $profile->updateOrCreate(['user_id' => auth()->user()->id], [
                'title' => $request->title,
                'description' => $request->description,
                'url' => $request->url,
                'image' => $image_path ?? $profile->image,
            ]);

            return redirect("/profile/{$user->id}/");
        } else {
            return redirect()->back();
        }
    }
}
