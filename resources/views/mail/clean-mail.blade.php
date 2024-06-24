@extends("mail.layout")

@section("content")
    <x-mail.text>{!! nl2br($messageContent) !!}</x-mail.text>

    @if($actionUrl)
        <x-mail.button href="{{$actionUrl}}">
            {{$actionText}}
        </x-mail.button>
    @endif
@endsection
