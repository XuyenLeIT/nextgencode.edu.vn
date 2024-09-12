@extends('layouts.client')
<link rel="stylesheet" href="{{ asset('css/client/feeback.css') }}">
@section('title', 'Feedback')

@section('content')
    <div class="container">
        <h4 class="fb-title">Feedback học viên về NextGenCode</h4>
        <div class="row gx-2 container-feed lazy-content">
            @foreach ($feedbacks as $item)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="container-card">
                    <div class="card-item">
                        <div class="image">
                            <img src="{{$item->avatar}}">
                            <h5 class="text-center">{{$item->name}}</h5>
                        </div>
                        <div class="feed-content">
                            <p>{{$item->content}}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
   
        </div>
    </div>
@endsection
