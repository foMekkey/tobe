<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\DataTables\BlogDatatable;
use App\Http\Requests\BlogRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class BlogController extends Controller
{

    /**
     * @param BlogDatatable $blogDatatable
     * @return mixed
     */
    public function index(BlogDatatable $blogDatatable)
    {
        return $blogDatatable->render('backend.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blog.create');
    }


    /**
     * @param BlogRequest $blogRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(BlogRequest $blogRequest)
    {
        $data = $blogRequest->only(['lang', 'title', 'date', 'content', 'created_by']);
        if (isset($blogRequest->image) ||  $blogRequest->image != null) {
            $data['image'] = $blogRequest->image->storePublicly(
                path: 'main',
                options: 'contabo'
            );
        }

        $data['date'] = Carbon::createFromFormat('m/d/Y', $data['date']);

        Blog::insert($data);

        return redirect('blog')->with(['success' =>  __('pages.success-add')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::find($id);
        $blog->date = Carbon::parse($blog->date)->format('m/d/Y');

        return  view('backend.blog.edit', compact('blog'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'lang' => 'required',
            'title' => 'required',
            'date' => 'required',
            'content' => 'required',
            'created_by' => 'required',
        ]);

        $data = $request->only(['lang', 'title', 'date', 'content', 'created_by']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->storePublicly(
                path: 'main',
                options: 'contabo'
            );
        }

        $data['date'] = Carbon::createFromFormat('m/d/Y', $data['date']);

        Blog::where('id', $id)->update($data);

        return redirect('blog')->with(['success' =>  __('pages.success-edit')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $blog = Blog::find($id);

        $check = $blog->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));
        }
    }
}