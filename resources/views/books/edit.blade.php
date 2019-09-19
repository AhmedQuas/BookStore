@extends('layout.app')

@section('content')
    <h1 class="text-center">Edit: "{{$book->title}}"
        <br/> by {{$book->author}}
    </h1>
    <div class="row justify-content-center mt-4">
        <div class="col-9">
            <form action='/books/{{$book->title_slug}}' method='POST' enctype='multipart/form-data'>
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="form-group row">
                    <label for="inputTitle" class="col-sm-2 col-form-label" >Book title</label>
                    <div class="col-sm-10">
                        <input type="text" name='title' class="form-control" id="inputTitle" value="{{$book->title}}" placeholder="Enter book title here" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="author" class="col-sm-2 col-form-label">Author</label>
                    <div class="col-sm-10">
                        <input type="text" name='author' class="form-control" id="author" value="{{$book->author}}" placeholder="Place for author name & surname">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="publishDate" class="col-sm-2 col-form-label">Publish date</label>
                    <div class="col-sm-10">
                        <input type="number" name='publish_date' class="form-control" id="publishDate"  @if(!is_null($book->publish_date)) value='{{$book->publish_date}}' @endif placeholder="Yearly publish date">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="publishDate" class="col-sm-2 col-form-label">Number of pages</label>
                    <div class="col-sm-10">
                        <input type="number" name='pages_number' class="form-control" id="publishDate" @if(!is_null($book->publish_date)) value='{{$book->pages_number}}' @endif placeholder="How many pages have got this book?">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name='description' rows="5" id="description" placeholder="Write here a short description of this book">@if(!is_null($book->description)) {{$book->description}} @endif</textarea>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <p class="col-sm-2">Current book cover image</p>
                    <div class="col-sm-10" style="background-image: url('/storage/cover_images/{{$book->cover_image}}'); width: 100%; height: 200px; background-size: contain; background-position: center; background-repeat: no-repeat;" ></div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2">Current book file</p>
                    <a href="/books/{{$book->title_slug}}/download/{{pathinfo($book->filename, PATHINFO_EXTENSION)}}">{{$book->filename}}</a>
                </div>
                <hr/>
                <div class="form-group row">
                    <label for="coverImage" class="col-sm-2 col-form-label">Book cover image</label>
                    <div class="col-sm-10">
                        <input type="file" name='cover_image' class="form-control-file" id='coverImage' accept='image/png, image/jpeg'>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bookFile" class="col-sm-2 col-form-label">Book File</label>
                    <div class="col-sm-10">
                        <input type="file" name='file' class="form-control-file" id="bookFile" accept=".pdf, .mobi, .epub">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-right">Edit this book</button>
            </form>
        </div>
    </div>
@endsection
