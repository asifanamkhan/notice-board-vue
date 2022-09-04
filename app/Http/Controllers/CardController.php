<?php

namespace App\Http\Controllers;

use App\Repositories\Board\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try {

            $order = Card::getMaxOrder($request->column_id);

            $data = [
                'column_id' => $request->column_id,
                'order' => $order['data'] + 1,
                'title' => $request->title,
                'description' => $request->description
            ];

            $card = Card::save($data);
            return response()->json($card);

        } catch (Exception $ex) {
            return [
                'status' => 'error',
                'data' => $ex->getMessage()
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Board\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Board\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Board\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $order = Card::getMaxOrder($request->column_id);

            $data = [
                'column_id' => $request->column_id,
                'title' => $request->title,
                'order' => $order['data'] + 1,
                'description' => $request->description ?? null
            ];

            $card = Card::update($id, $data);
            return response()->json($card);

        } catch (Exception $ex) {
            return [
                'status' => 'error',
                'data' => $ex->getMessage()
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Board\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }

    public function swap(Request $request)
    {
        try {

            $data = [
                'column_id' => $request->column_id,
                'from' => $request->from,
                'to' => $request->to
            ];

            $card = Card::swap($data);
            return response()->json($card);

        } catch (\Exception $ex) {
            return [
                'status' => 'error',
                'data' => $ex->getMessage()
            ];
        }
    }
}
