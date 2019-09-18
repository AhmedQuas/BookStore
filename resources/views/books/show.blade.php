@extends('layout.app')

@section('content')
    <div class="container">
        <div class="row col-10 justify-content-center">
            <p class="col-12 mt-4 btn btn-primary text-center">{{$book->title}}</p>
            <div class="col-3" style="background-image: url('/storage/cover_images/{{$book->cover_image}}'); width: 100%; height: 200px; background-color: lightgreen; background-size: contain; background-position: center"></div>
            <div class="col-9">
                <p>Autor: {{$book->author}}</p>
                @if(!is_null($book->pages_number))
                    <p>Liczba stron: {{$book->pages_number}}</p>
                @endif
                @if(!is_null($book->publish_date))
                    <p>Data wydania: {{$book->publish_date}}</p>
                @endif
            </div>
            <div class="col-12 mt-5">
                <p>{{$book->description}}</p>
                <p class="btn btn-primary w-100 my-4">Download section</p>
                <a href="/books/{{$book->title_slug}}/download/{{pathinfo($book->filename, PATHINFO_EXTENSION)}}">{{$book->filename}}</a>
            </div>
        </div>
    </div>
@endsection

