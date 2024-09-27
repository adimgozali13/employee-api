<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Leave::orderBy('created_at', 'desc')->get();
            // $user = User::where('id',$request->user_id)->first();
            // if ($user->role == 'employee') {
            //     $data = $data->where('user_id', $request->user_id);
            // }
            // $data = $data->get();
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Successfully retrieved data.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Failed retrieved data.'
            ], 500);
        }
    }

    public function requestLeave(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $cl = Leave::where([
            'user_id' => $request->user_id,
            'status' => 'pending',
        ])->first();

        if (!empty($cl)) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'you have already submitted a leave request, please wait for approval from your supervisor..'
            ], 402);
        }


        try {
            $leave = Leave::create([
                'user_id' => $request->user_id,
                'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'),
                'end_date' => Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d'),
                'status' => 'pending',
            ]);
            return response()->json([
                'success' => true,
                'data' => $leave,
                'message' => 'Successfully submitted leave request.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function manageLeave(Request $request)
    {
        try {
            $leave = Leave::where('id', $request->id)->first();
            $leave->status = $request->status;
            $leave->save();
            return response()->json([
                'success' => true,
                'data' => $leave,
                'message' => 'Data successfully updated.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Failed to update data.'
            ], 500);
        }
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
