<?php

namespace App\Http\Controllers\Trainer;
use App\DataTables\TrainerDiscussionsDatatable;
use App\User;
use App\Discussion_Comment;
use App\Discussion;
use App\Courses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Auth;
use File;
use URL;

class DiscussionsController extends Controller
{
    public function index(TrainerDiscussionsDatatable $discussionsDatatable)
    {
        return $discussionsDatatable->render('trainer.discussions.index');
    }

    public function create()
    {

        $courses = Courses::where('user_id',Auth::id())->get();
        return view('trainer.discussions.create',compact('courses'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title'          => 'required|max:190',
            'body'           => 'required'
        ]);

        $discussion = new Discussion;
        $discussion->title      = $request->title;
        $discussion->body       = $request->body;
        $discussion->privacy    = $request->privacy;
        $discussion->course_id  = $request->course_id;
        $discussion->user_id    = Auth::id();

        if(!is_null($request->attachment))
        {
            $file = $request->attachment;
            $name =date('d-m-y').time().rand().'.'.$file->getClientOriginalExtension();
            $file->move('uploads/attachment/',$name);
            $discussion->attachment      = $name;
            $discussion->attachment_type = $file->getClientOriginalExtension();
        }

        $discussion->save();

        return redirect('trainer/discussions')->with(['success' =>  __('pages.success-add')]);
    }

    public function edit($id)
    {
        $discussion = Discussion::find($id);
        $courses = Courses::where('user_id',Auth::id())->get();
        return  view('trainer.discussions.edit',compact('discussion','courses'));
    }


    public function update(Request $request)
    {
        $this->validate($request,[
            'title'          => 'required|max:190',
            'body'           => 'required'
        ]);

        $discussion = Discussion::find($request->id);
        $discussion->title      = $request->title;
        $discussion->body       = $request->body;
        $discussion->privacy    = $request->privacy;
        $discussion->course_id  = $request->course_id;

        if(!is_null($request->attachment))
        {
            File::delete('uploads/attachment/'.$discussion->attachment);
            $file = $request->attachment;
            $name =date('d-m-y').time().rand().'.'.$file->getClientOriginalExtension();
            $file->move('uploads/attachment/',$name);
            $discussion->attachment      = $name;
            $discussion->attachment_type = $file->getClientOriginalExtension();
        }

        $discussion->save();

        return redirect('trainer/discussions')->with(['success' =>  __('pages.success-edit')]);
    }

    public function show($id)
    {
        $discussion = Discussion::with('User','Course','Comments.User')->find($id);
        return  view('trainer.discussions.view',compact('discussion'));
    }

    public function destroy($id)
    {
        $discussion = Discussion::findOrFail($id);
        File::delete('uploads/attachment/'.$discussion->attachment);
        $check = $discussion->delete();
        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));

        }
    }

    # add comment (ajax)
    public function AddComment($user_id,$comment,$discussion_id)
    {
        $discussion_comment = new Discussion_Comment;
        $discussion_comment->discussion_id = $discussion_id;
        $discussion_comment->user_id       = $user_id;
        $discussion_comment->comment       = $comment;
        $discussion_comment->save();
        return response()->json([
            'status' =>'1',
            'message'=>'done',
            'data'   =>$discussion_comment
        ]);
    }


}
