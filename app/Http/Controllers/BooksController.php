<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderBy('created_at','desc')->paginate(30);
        return view('books.index')->with('books',$books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate_data = $request->validate([
            'title' => 'required|string',
            'author' => 'string|max:100',
            'publish_date' => 'integer|nullable',
            'pages_number' => 'integer|nullable',
            'cover_image' => 'nullable|image|mimes:jpeg,png|max:1999',
            'file' => 'nullable|file|mimes:pdf,epub,mobi',
        ]);

        $cover_image_name='no-image.png';
        $file_name='';

        if($request->hasFile('cover_image'))
        {
            $cover_image_name = $request->file('cover_image')->getClientOriginalName();
            $request->file('cover_image')->storeAs('public/cover_images',$cover_image_name);
        }
        if($request->hasFile('file'))
        {
            $file_name = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/books',$file_name);
        }
        if(empty($request->input('description')))
            $description='No description provided';
        else
            $description=$request->input('description');

        $title_slug = $request->input('title');

        //removing uppercase, spaces & polish special characters
        $title_slug = str_replace(' ','-', $title_slug);
        $title_slug=str_replace(
            ['ą','ć','ę','ł','ń','ó','ś','ź','ż','Ą','Ć','Ę','Ł','Ń','Ó','Ś','Ź','Ż'],
            ['a','c','e','l','n','o','s','z','z','a','c','e','l','n','o','s','z','z',],
            $title_slug
        );
        $title_slug = strtolower($title_slug);

        $book = new Book();

        $book->title = $request->input('title');
        $book->title_slug = $title_slug;
        $book->author = $request->input('author');
        $book->publish_date = $request->input('publish_date');
        $book->description = $description;
        $book->filename = $file_name;
        $book->cover_image = $cover_image_name;
        $book->pages_number = $request->input('pages_number');


        $book->save();

        return redirect('/books')->with('success', $book->title.' - another book added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($title_slug)
    {
        $book=Book::where('title_slug','=',$title_slug)->first();

        //return var_dump($book);
        return view('books.show')->with('book',$book);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($title_slug)
    {
        $book =Book::where('title_slug','=',$title_slug)->first();

        return view('books.edit')->with('book', $book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $title_slug)
    {
        $this->validate($request,[
            'title' => 'required|string',
            'author' => 'string|max:100',
            'publish_date' => 'integer|nullable',
            'pages_number' => 'integer|nullable',
            'cover_image' => 'nullable|image|mimes:jpeg,png|max:1999',
            'file' => 'nullable|file|mimes:pdf,epub,mobi',
        ]);

        $cover_image_name='no-image.png';
        $file_name='';

        if($request->hasFile('cover_image'))
        {
            $cover_image_name = $request->file('cover_image')->getClientOriginalName();
            $request->file('cover_image')->storeAs('public/cover_images',$cover_image_name);
        }
        if($request->hasFile('file'))
        {
            $file_name = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/books',$file_name);
        }
        if(empty($request->input('description')))
            $description='No description provided';
        else
            $description=$request->input('description');

        $title_slug = $request->input('title');

        //removing uppercase, spaces & polish special characters
        $title_slug = str_replace(' ','-', $title_slug);
        $title_slug=str_replace(
            ['ą','ć','ę','ł','ń','ó','ś','ź','ż','Ą','Ć','Ę','Ł','Ń','Ó','Ś','Ź','Ż'],
            ['a','c','e','l','n','o','s','z','z','a','c','e','l','n','o','s','z','z',],
            $title_slug
        );
        $title_slug = strtolower($title_slug);


        $book = Book::where('title_slug','=',$title_slug)->first();

        $book->title = $request->input('title');
        $book->title_slug = $title_slug;
        $book->author = $request->input('author');
        $book->publish_date = $request->input('publish_date');
        $book->pages_number = $request->input('pages_number');
        $book->description = $description;

        if($description!='')
            $book->description = $description;
        if($file_name!='')
            $book->filename = $file_name;
        if($cover_image_name!='no-image.png')
            $book->cover_image = $cover_image_name;

        $book->save();

        return redirect('/books/'.$book->title_slug)->with('success', $book->title.' - successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Download the specified file form storage
     *
     */
    public function download($title_slug, $ext)
    {
        // This function should be expanded in the future for other formats & user roles

        $book=Book::where('title_slug','=',$title_slug)->first();

        return response()->download('storage/books/'.$book->filename);
    }
}
