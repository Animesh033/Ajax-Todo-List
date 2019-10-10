<?php

namespace App\Http\Controllers;

use App\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = TodoList::all();
        return view('list', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // Validate the request...

        $flight = new TodoList;

        $flight->item = $request->input;

        $flight->save();

        return 'Done!';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function show(TodoList $todoList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function edit(TodoList $todoList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodoList $todoList)
    {
        //
        $item = TodoList::find($request->id);
        $item->item = $request->value;
        $item->save();
        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoList $todoList)
    {
        //
    }

    public function delete(Request $request)
    {
        TodoList::where('id', $request->id)->delete();
        return $request->all();
    }

    public function search(Request $request)
    {
        $term = $request->term; // only 'term' works, dont use input name here i.e $request->name_of_input;

        $searchitems = TodoList::where('item', 'LIKE', '%'.$term.'%')->get();
// dd($items);
        if (count($searchitems) == 0) {
            $items[] = 'No Item Found';
            return $items; 
        }else{
            foreach ($searchitems as $value) {
                $items[] = $value->item;
            }
            // dd($items);
            return $items;
        }
    }
}
