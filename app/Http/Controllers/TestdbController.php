<?php

namespace App\Http\Controllers;

use App\Models\Testdb;
use Illuminate\Http\Request;

class TestdbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Testdb $testdb)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testdb $testdb)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testdb $testdb)
    {
        // リクエストボディを取得
        $data = json_decode($request->getContent(), true);

        // 送信されたデータの処理
        $count = $data['count'];

        $testdb->test += $count;

        $testdb->save();

        return response()->json(['count' => $testdb->test]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testdb $testdb)
    {
        //
    }
}
