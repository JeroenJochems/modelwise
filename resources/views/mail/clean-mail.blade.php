@extends("mail.layout")

@section("content")

    @foreach($paragraphs as $p)
        <x-mail.text>{!! nl2br($p) !!}</x-mail.text>
    @endforeach

    @if($actionUrl)
        <x-mail.button href="{{$actionUrl}}">
            {{$actionText}}
        </x-mail.button>
    @endif
@endsection
