@extends('layout.app')

@section('content')
    <h1 class="text-center mt-5">Show all books</h1>
    <div class="container">
        <div class="row">
            @if(count($books) > 0)
                @foreach($books as $book)
                    <div class="col-3 mt-4">
                        <a href="/books/{{$book->title_slug}}">
                            <div style="background-image: url('/storage/books/{{$book->cover_image}}'); width: 100%; height: 200px; background-color: lightgreen;"></div>
                            <div>
                                <p class="text-center mb-1 mt-2">{{$book->title}}</p>
                                <p class="text-center">{{$book->author}}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <p>No books found</p>
                </div>
            @endif
        </div>
    </div>
@endsection
