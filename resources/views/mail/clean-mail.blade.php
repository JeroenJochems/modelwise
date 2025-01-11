@extends('mail.layout')

@section("content")
    @foreach($messageContent as $p)
    {!! nl2br($p) !!}<br /><br />
    @endforeach

    @if(strlen($actionUrl))
        <a style="font-weight: bold;" href="{{$actionUrl}}">
            {{$actionText}}
        </a>
    @endif
    <br /><br />
    <img src="{{$message->embed(public_path('img/logo-black.png'))}}" />

    @isset($code)
        <br /><br /><span style="font-size:13px; color: #ccc">{{$code}}</span>
    @endisset
@endsection
