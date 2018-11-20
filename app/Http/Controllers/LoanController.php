<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Loan;

class LoanController extends Controller
{
    
    public function store(Request $request)
    {
        $userEmail = User::where('email', '=' , $request->inputEmail)->first();

        if (!empty($userEmail)) {

            $loan = new Loan;
            $loan->user_id = $userEmail->id;
            $loan->duration = $request->duration;
            $loan->repayment_frequency = $request->repayment_frequency;
            $loan->interest_rate = $request->interest_rate;
            $loan->arrangement_fee = $request->arrangement_fee;
            $loan->loan_amount = $request->loan_amount;
            $loan->loan_balance = $request->loan_amount;
            $loan->save();

            return response()->json([
                'code' => '01',
                'status' => 'Loan Saved for User '.$userEmail->name
            ]);

        } else {

            return response()->json([
                'code' => '02',
                'status' => 'Invalid User'
            ]);

        }
    }

    public function update(Request $request)
    {
        $loan = Loan::find($request->id);

        if (!empty($loan)) {

            $loan->duration = $request->duration;
            $loan->repayment_frequency = $request->repayment_frequency;
            $loan->interest_rate = $request->interest_rate;
            $loan->arrangement_fee = $request->arrangement_fee;
            $loan->loan_amount = $request->loan_amount;
            $loan->loan_balance = $request->loan_amount;
            $loan->save();

            return response()->json([
                'code' => '01',
                'status' => 'Loan Updated'
            ]);

        } else {

            return response()->json([
                'code' => '02',
                'status' => 'Invalid Loan ID'
            ]);

        }
    }

    public function destroy(Request $request)
    {
        $loan = Loan::find($request->id);

        if (!empty($loan)) {

            $loan->delete();

            return response()->json([
                'code' => '01',
                'status' => 'Loan Deleted'
            ]);

        } else {

            return response()->json([
                'code' => '02',
                'status' => 'Invalid Loan ID'
            ]);

        }
    }

}
