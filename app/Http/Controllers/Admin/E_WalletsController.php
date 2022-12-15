<?php

namespace App\Http\Controllers\Admin;
use App\E_Wallet;
use App\DataTables\E_WalletsDataTable;
use App\Http\Requests\E_WalletRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class E_WalletsController extends Controller
{

    /**
     * @param E_WalletsDatatable $e_walletsDatatable
     * @return mixed
     */
    public function index(E_WalletsDataTable $e_walletsDatatable)
    {
        return $e_walletsDatatable->render('backend.e_wallets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.e_wallets.create');
    }


    /**
     * @param E_WalletRequest $E_WalletRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(E_WalletRequest $E_WalletRequest)
    {
        $data = $E_WalletRequest->only(['number','company_name_ar','company_name_en','active']);
        E_Wallet::insert($data);

        return redirect('e_wallets')->with(['success' =>  __('pages.success-add')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $e_wallet = E_Wallet::find($id);

        return  view('backend.e_wallets.edit',compact('e_wallet'));
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
            'number'=>'required',
            'company_name_ar'=>'required',
            'company_name_en'=>'required',
            'active'=>'required',
            
        ]);
        
        $data = $request->only(['number','company_name_ar','company_name_en','active']);
        
        E_Wallet::where('id', $id)->update($data);

        return redirect('e_wallets')->with(['success' =>  __('pages.success-edit')]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $e_wallet = E_Wallet::find($id);

        $check = $e_wallet->delete();

        if ($check) {
            return Response::json($id, '200');
        } else {
            return redirect()->back()->with('error', __('pages.success-delete'));

        }
    }
}
