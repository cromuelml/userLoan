<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Loan;
use App\Repayment;

class RepaymentController extends Controller
{
    
    public function store(Request $request)
    {
        $Loan = Loan::find($request->id);

        if (!empty($Loan)) {

            if ($request->arrangement_fee <= $Loan->loan_balance) {

                $repayment = new Repayment;
                $repayment->user_id = $Loan->user_id;
                $repayment->loan_id = $Loan->id;
                $repayment->repayment_date = $request->repayment_date;
                $repayment->arrangement_fee = $request->arrangement_fee;
                $repayment->save();

                
                $Loan->loan_balance = $Loan->loan_balance - $request->arrangement_fee;
                $Loan->save();

                return response()->json([
                    'code' => '01',
                    'status' => 'Loan Repayment Saved for Loan '.$Loan->id
                ]);

            } else {

                return response()->json([
                    'code' => '02',
                    'status' => 'Loan Repayment('.$request->arrangement_fee.') is greater than Loan Balance Amount('.$Loan->loan_balance.')'
                ]);

            }
            
        } else {

            return response()->json([
                'code' => '02',
                'status' => 'Invalid Loan ID'
            ]);

        }
    }

    public function update(Request $request)
    {
        $repayment = Repayment::find($request->id);
        $old_repayment = $repayment->arrangement_fee;

        $Loan = Loan::find($repayment->loan_id);

        if (!empty($repayment)) {

            if ($request->arrangement_fee <= $Loan->loan_balance) {

                $repayment->repayment_date = $request->repayment_date;
                $repayment->arrangement_fee = $request->arrangement_fee;
                $repayment->save();

                $LoanUpdate = Loan::find($repayment->loan_id);
                $LoanUpdate->loan_balance = ($LoanUpdate->loan_balance + $old_repayment) - $request->arrangement_fee;
                $LoanUpdate->save();

                return response()->json([
                    'code' => '01',
                    'status' => 'Loan Repayment Updated'
                ]);

            } else {

                return response()->json([
                    'code' => '02',
                    'status' => 'Loan Repayment('.$request->arrangement_fee.') is greater than Loan Balance Amount('.$Loan->loan_balance.')'
                ]);

            }

        } else {

            return response()->json([
                'code' => '02',
                'status' => 'Invalid Loan Repayment ID'
            ]);

        }
    }

    public function destroy(Request $request)
    {
        $repayment = Repayment::find($request->id);

        if (!empty($repayment)) {

            $repayment->delete();
            $LoanUpdate = Loan::find($repayment->loan_id);
            $LoanUpdate->loan_balance = $LoanUpdate->loan_balance + $repayment->arrangement_fee;
            $LoanUpdate->save();

            return response()->json([
                'code' => '01',
                'status' => 'Loan Repayment Deleted'
            ]);

        } else {

            return response()->json([
                'code' => '02',
                'status' => 'Invalid Loan Repayment ID'
            ]);

        }
    }

}
