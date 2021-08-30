@extends('layouts.app')

@section('content')
<div class="container">
@if(count($posts) > 0)
    @foreach($posts as $post)
        <div class="row">
        <div class="col-6 offset-3">
        <a href="/profile/{{ $post->user->id }}">
            <img src="/storage/{{ $post->image }}" class="w-100" alt="">
            </a>
        </div>
        </div>
<hr>
        <div class="row pt-2 pb-4">
        <div class="col-6 offset-3" >
            <div>
                
                <p>
                    <span class="font-weight-bold">
                        <a href="/profile/{{ $post->user->id }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                    </span>
                    {{ $post->caption }}
                </p>
            </div>
        </div>
    </div>
    @endforeach

    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>
    @else

     <div class="row">
        <div class="col-6 offset-3">
        <a href="/profile/{{ Auth::id() }}" class="btn btn-success">
            Go To My Profile
            </a>
        </div>
        </div>

        <div class="row pt-5" >
        <div class="col-6 offset-3 py-4" style="border: 1px solid #3333;">
        @if(count($profiles) > 0)
            <h4 class="pb-1"><u><b>Visit Recent Profiles</b></u></h4>
            @foreach($profiles as $profile)
                <div class="d-flex align-items-center">
                    <div class="pr-3">
                        <img src="{{ $profile->profileImage() }}" class="rounded-circle w-100" style="max-width: 40px;" alt="">
                    </div>
                    <div>
                        <div class="font-weight-bold">
                            <a href="/profile/{{ $profile->user->id }}">
                                <span class="text-dark">{{ $profile->user->username }}</span>
                            </a>
                            @if($profile->user_id == auth()->user()->id)
                                <span class="text-success pl-8">[Your account]</span>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
        @else
            <h4 class="pb-1">Empty recent profiles!!!!..</h4>
            @endif
        </div>

        @endif


</div>
@endsection
