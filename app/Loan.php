<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public function payments()
    {
        return $this->hasmany('App\Repayment', 'loan_id');
    }
}
