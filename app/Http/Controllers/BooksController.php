<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('books.index');
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
            'publish_date' => 'integer',
            'pages_number' => 'integer',
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
            $request->file('cover_image')->storeAs('public/books',$file_name);
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
