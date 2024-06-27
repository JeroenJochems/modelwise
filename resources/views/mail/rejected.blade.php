@extends("mail.layout")

@section("content")
    <x-mail.text>Hi {{$firstName}}</x-mail.text>
    <x-mail.text>{{ $messageContent }}</x-mail.text>
@endsection
