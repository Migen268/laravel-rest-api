<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
use DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   //select all books
        return Book::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate([
            'title'=>'required',
            'author'=>'required',
            'price'=>'required',
        ]);

        //create a book
        return Book::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Book::find($id);
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
        $book = Book::find($id);
        $book->update($request->all());
        //DB::statement("Update books set title='".$request->title."' where id=".$id);        
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Book::destroy($id);
    }

    /**
     * Search with title of the book.
     *
     * @param  str  $title
     * @return \Illuminate\Http\Response
     */
    public function kerko($title)
    {
       // return DB::select("Select  * from books where title like '%".$title."%'");
         return Book::where('title','like','%'.$title.'%')->get();
    }


    /**
     *Check if a book exists.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check_existence($id)
    {
         $nr= DB::select("Select  count(1) a from books where id = ".$id);

         if($nr[0]->a==1)
             $msg="The book exists";
         else
            $msg="The book does not exist";

        return $msg ;
    }
}
