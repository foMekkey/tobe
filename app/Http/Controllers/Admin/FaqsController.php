<?php

namespace App\Http\Controllers\Admin;
use App\Faq;
use App\DataTables\FaqsDataTable;
use App\Http\Requests\FaqRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class FaqsController extends Controller
{

    /**
     * @param FaqsDatatable $faqsDatatable
     * @return mixed
     */
    public function index(FaqsDataTable $faqsDatatable)
    {
        return $faqsDatatable->render('backend.faqs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.faqs.create');
    }


    /**
     * @param FaqRequest $FaqRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FaqRequest $FaqRequest)
    {
        $data = $FaqRequest->only(['question','answer']);
        Faq::insert($data);

        return redirect('faqs')->with(['success' =>  __('pages.success-add')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faq = Faq::find($id);
        return  view('backend.faqs.edit',compact('faq'));
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
            'question'=>'required',
            'answer'=>'required'
        ]);
        
        $data = $request->only(['question','answer']);
        
        Faq::where('id', $id)->update($data);

        return redirect('faqs')->with(['success' =>  __('pages.success-edit')]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $faq = Faq::find($id);

        $check = $faq->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));

        }
    }
}
