<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\DataTables\BanksDataTable;
use App\Http\Requests\BankRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BanksExport;
use Response;

class BanksController extends Controller
{

    /**
     * @param BanksDatatable $banksDatatable
     * @return mixed
     */
    public function index(BanksDataTable $banksDatatable)
    {
        return $banksDatatable->render('backend.banks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banks.create');
    }


    /**
     * @param BankRequest $BankRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(BankRequest $BankRequest)
    {
        $data = $BankRequest->only(['bank_name_ar', 'bank_name_en', 'acc_name_ar', 'acc_name_en', 'acc_num', 'iban', 'active']);
        Bank::insert($data);

        return redirect('banks')->with(['success' =>  __('pages.success-add')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank = Bank::find($id);

        return  view('backend.banks.edit', compact('bank'));
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
            'bank_name_ar' => 'required',
            'bank_name_en' => 'required',
            'acc_name_ar' => 'required',
            'acc_name_en' => 'required',
            'acc_num' => 'required',
            'iban' => 'required',
            'active' => 'required',

        ]);

        $data = $request->only(['bank_name_ar', 'bank_name_en', 'acc_name_ar', 'acc_name_en', 'acc_num', 'iban', 'active']);

        Bank::where('id', $id)->update($data);

        return redirect('banks')->with(['success' =>  __('pages.success-edit')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $bank = Bank::find($id);

        $check = $bank->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));
        }
    }

    public function export()
    {
        return Excel::download(new BanksExport, 'banks_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
}
