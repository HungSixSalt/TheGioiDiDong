<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CommentModel;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    function comment(Request $request) {
        if(!empty($request->id) && !empty($request->comment) && !empty(session('user_customer_id')) ){
            $comment = CommentModel::create([
                'product_id'=>$request->id,  
                'user_customer_id'=>session('user_customer_id'),  
                'comment_content'=>$request->comment,  
                'created_at'=>now(), 
            ]);
            return true;
        }
        return false;
    }
}
