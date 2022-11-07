<?php

namespace App\Http\Controllers\Admin;
use App\Page;
use App\DataTables\PageDatatable;
use App\Http\Requests\PageRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class PageController extends Controller
{

    /**
     * @param PageDatatable $pagesDatatable
     * @return mixed
     */
    public function index(PageDatatable $pagesDatatable)
    {
        return $pagesDatatable->render('backend.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.create');
    }


    /**
     * @param PageRequest $pagesRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PageRequest $pagesRequest)
    {
        $data = $pagesRequest->only(['lang', 'title', 'content']);
        Page::insert($data);

        return redirect('pages')->with(['success' =>  __('pages.success-add')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find($id);

        return  view('backend.pages.edit',compact('page'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
//            'lang'=>'required',
            'title'=>'required',
            'content'=>'required',
        ]);
        
        $data = $request->only(['title', 'content']);
        Page::where('id', $id)->update($data);

        return redirect('pages')->with(['success' =>  __('pages.success-edit')]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $page = Page::find($id);

        $check = $page->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));

        }
    }
}
