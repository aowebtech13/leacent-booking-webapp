<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


class SubscriptionController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Subscriptions have been removed.',
        ], 410);

    }

   
   
   

  
}