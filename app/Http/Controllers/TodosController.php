<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Todo;
use Illuminate\Support\Facades\DB;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // ログインしていたら
        if (Auth::check()) {

            $todos = Todo::all();   // 全データ取得
            // return var_dump($todos);
            return view('todos.index',["todos" => $todos]);
        } 
        else 
        {
        // ログインしていなかったら、Login画面を表示
            return view('auth.login');
        }
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
        // ログインしていたら
        if (Auth::check()) {
            $todo = new Todo();

            if($request->body=='' )
            {
                $error_msg = '追加内容が正しくありません';
                return view('todos.error')->with('error_msg',$error_msg);
            }

            $todo->body = $request->body;
            $todo->save();
            return redirect('/todos/index');
            } 
        else 
        {
        // ログインしていなかったら、Login画面を表示
            return view('auth.login');
        }
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
    public function edit(todo $todo)
    {
        //
        // ログインしていたら
        if (Auth::check()) {
            return view('todos.edit')->with('todo',$todo);        } 
        else 
        {
        // ログインしていなかったら、Login画面を表示
            return view('auth.login');
        }        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,todo $todo)
    {
        //
        // ログインしていたら
        if (Auth::check()) {
            $todo->body = $request->body;
            $todo->save();
            return redirect('/todos/index');
            } 
        else 
        {
        // ログインしていなかったら、Login画面を表示
            return view('auth.login');
        }       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(todo $todo)
    {
        //
        // ログインしていたら
        if (Auth::check()) {
            $todo->delete();
            return redirect('/todos/index');
                } 
        else 
        {
        // ログインしていなかったら、Login画面を表示
            return view('auth.login');
        }
    }

    public function search(Request $request)
    {
        $search = $request->input('body_search');
        
        //入力フォームで入力した文字列を含むカラムを取得します
        if ($request->has('body_search') && $search != '') {
            $todos = Todo::where('body', 'like', '%'.$search.'%')->get();
            // $todos = DB::table('todos')->where('body', 'like', '%'.$search.'%')->get();
            // return var_dump($todos);
            return view('todos.index',["todos" => $todos]);
        }

        $error_msg = '検索条件に当てはまりません';
        return view('todos.error')->with('error_msg',$error_msg);
    }
}
