<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommController extends Controller
{
    //
    public function insComm(Request $info){
        // return $info;
        if (session('type') == 'user'){
            $usertype = 'username';
        }else if (session('type') == 'doctor'){
            $usertype = 'doctor';
        }
        if(isset($info->con_id)){
            $commentTo = 'consultation';
        }else if(isset($info->ans_id)){
            $commentTo = 'answer';
        }

        
        Comment::create([
            'com_content' => $info->content,
            $usertype => session('info.username'),
            $commentTo => $info->con_id,
        ]);
        // return redirect('showallcon');
    }

    public function showComm(){
        $com = Comment::get();
        return view('comment', ['value' => $com]);
    }

    public function deleteCom($id){
        Comment::where('com_id', $id)->delete();
        return redirect()->back();
    }

    public function getID(){
        $id = Comment::where('username', session('info.username'))->latest('con_id')->first()->con_id;
        return $id;
    }
}
