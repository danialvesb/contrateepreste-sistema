<?php

namespace App\Http\Controllers;

use App\Models\User\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function sendEvaluate(Request $request)
    {
        $data = $request->all();
        $evaluation = new Evaluation();

        $evaluation->fill(['comment' => $data['comment'],
            'rating' => $data['rating'],
            'reply' => '0',
            'solicitation_id' => $data['solicitation_id']]);
        $evaluation->save();

        DB::table('solicitations')
            ->where('id', $data['solicitation_id'])
            ->update(['is_evaluate' => '1']);

        print_r($evaluation);exit();
    }

    public function sendReply(Request $request)
    {
        $data = $request->all();

        DB::table('evaluations')
            ->where('id', $data['evaluation_id'])
            ->update(['reply' => $data['reply']]);

        return response(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
