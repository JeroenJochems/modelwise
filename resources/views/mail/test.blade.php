@extends("mail.layout")

@section("content")
    <x-mail.text>Voorkeur voor: {{$names}}</x-mail.text>
    <x-mail.text><a href="{{$link}}">Bekijk presentatie</a></x-mail.text>
@endsection
