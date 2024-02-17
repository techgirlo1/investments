<?php


namespace App\Repositories;

use App\Models\Investment;
use App\Interfaces\InvestmentRepositoryInterface;
class InvestmentRepository implements InvestmentRepositoryInterface
{
    public function getAllInvestments()
    {
        return Investment::all();
    }

    public function findInvestmentById($investmentId)
    {
        return Investment::findOrFail($investmentId);
    }

    
}
