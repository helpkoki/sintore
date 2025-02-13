<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DatabaseAPI;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class getUserDetailsController extends Controller
{
    protected $databaseAPI;

    public function __construct(DatabaseAPI $databaseAPI)
    {
        $this->databaseAPI = $databaseAPI;
    }

    public function getUserDetails(Request $request)
{
    header('Content-Type: application/json');
    $response = [];

    $user_id = Session::get('user_id');
    $email = Session::get('email');

    if (!$email || !$user_id) {
        return response()->json(['error' => 'User is not logged in']);
    }

    try {
        $user = $this->databaseAPI->getUserByEmail($email);

        if ($user && $user->user_id == $user_id) {
            $company = isset($user->company_id) ? 
                $this->databaseAPI->getCompanyById($user->company_id) : null;

            $response = [
                'user' => [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'user_id' => $user->user_id
                ],
                'company' => $company
            ];
        } else {
            $response = ['error' => 'User data mismatch'];
        }
    } catch (\Exception $e) {
        Log::error("Error fetching user data: " . $e->getMessage());
        $response = ['error' => 'An unexpected error occurred'];
    }

    return response()->json($response);
}
}