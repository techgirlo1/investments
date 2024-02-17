<?php


namespace App\Http\Controllers;
use App\Interfaces\InvestmentRepositoryInterface;
use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
class InvestmentController extends Controller
{

    protected $investmentRepository;

    public function __construct(InvestmentRepositoryInterface $investmentRepository)
    {
        $this->investmentRepository = $investmentRepository;
    }

    
    public function index(): JsonResponse
    {
        $investments = $this->investmentRepository->getAllInvestments();
        return response()->json(['investments' => $investments]);
    }

    public function investmentById($investmentId): JsonResponse
    {
        $investment = $this->investmentRepository->findInvestmentById($investmentId);

        if (!$investment) {
            return response()->json(['error' => 'Investment not found'], 404);
        }

        return response()->json(['investment' => $investment]);
    }


    public function create(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $investment = Investment::create([
            'user_id' => Auth::id(),
            'amount' => $request->input('amount'),
        ]);

        return response()->json(['message' => 'Investment created successfully', 'investment' => $investment], 201);
    }

    public function showInvestments()
    {
        $investments = Investment::where('user_id', Auth::id())->get();
        return response()->json(['investments' => $investments]);
    }


    
   
}

