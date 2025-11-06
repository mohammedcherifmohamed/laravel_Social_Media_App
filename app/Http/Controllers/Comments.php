<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\PostsModel;
    use Illuminate\Support\Facades\Auth;
    use App\Models\comments as CommentModel;

     class Comments{

        public function add_comment(Request $req){
            CommentModel::create([
                'post_id' => $req->input('post_id') ,
                'user_id' => auth()->id() ,
                'content' => $req->input('content'), 
            ]);
            return response()->json([
                    'success' => true,
                    'data' => $req->all()
            ]);
        }

        public function get_comments($id){
            
            $comments = Commentmodel::where('post_id',$id)->with('user')->paginate(10);  
            return response()->json([
                "success" => true ,
                'data' => $comments->items(),  
                'next_page_url' => $comments->nextPageUrl(), 
            ]);
        }
        
    }


