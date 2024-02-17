<?php


namespace App\Interfaces;

use App\Models\Investment;

interface InvestmentRepositoryInterface
{
    public function getAllInvestments();

    public function findInvestmentById($investmentId);

    
}
