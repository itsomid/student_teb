<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DebitCardStatus;
use App\Functions\DateFormatter;
use App\Functions\Filter;
use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Services\DebitCard;
use Illuminate\Http\Request;


class DebitCardTransactionController extends Controller
{
    public function index()
    {
        $filters= Filter::filter()
            ->add('id', request()->input('id'))
            ->add('user_id', request()->input('user_id'))
            ->add('user_id', request()->input('user_id'))
            ->add('status', request()->input('status'));

       $transactions= auth()->user()->can('debit-card.index.access-all')
           ?   DebitCard::index($filters->get())
           :   DebitCard::own_cards(auth()->id(), $filters->get());

        return view('dashboard.debit_card.index')
            ->with(['transactions' => $transactions]);
    }

    public function create()
    {
        return view('dashboard.debit_card.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'user_id'               => ['required', 'numeric'],
            'tracking_code'         => ['required'],
            'amount'                => ['required', 'numeric'],
            'transaction_date'      => ['required'],
            'filename'              => ['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'description'           => ['required']
        ]);

        $imageName = time().'.'.$request->filename->extension();
        $request->filename->move(public_path('images/DebitCards'), $imageName);

        DebitCard::store([
            'user_id'               =>  $request->user_id,
            'tracking_code'         =>  $request->tracking_code,
            'amount'                =>  $request->amount,
            'transaction_date'      =>  DateFormatter::format($request->transaction_date),
            'status'                =>  DebitCardStatus::PENDING,
            'filename'              =>  $imageName,
            'description'           =>  $request->description,
        ]);

        Toast::message()->success()->notify();
        return redirect()->route('admin.debit-card.index');
    }

    public function edit($debitCard)
    {
        $debitCard=DebitCard::show($debitCard);

        return view('dashboard.debit_card.edit')->with([
            'debitCard'  =>  $debitCard
        ]);
    }

    public function update($debitCard, Request $request)
    {
        $debitCard=DebitCard::show($debitCard);

        $this->validate($request,[
            'user_id'               => ['required', 'numeric'],
            'tracking_code'         => ['required'],
            'amount'                => ['required', 'numeric'],
            'transaction_date'      => ['required'],
            'filename'              => ['image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'description'           => ['required']
        ]);

        $imageName= $debitCard->filename;

        if ($request->has('filename'))
        {
            $imageName = time().'.'.$request->filename->extension();
            $request->filename->move(public_path('images/DebitCards'), $imageName);
        }

        DebitCard::update($debitCard->id, [
            'user_id'               =>  $request->user_id,
            'tracking_code'         =>  $request->tracking_code,
            'amount'                =>  $request->amount,
            'transaction_date'      =>  DateFormatter::format($request->transaction_date),
            'status'                =>  DebitCardStatus::PENDING,
            'filename'              =>  $imageName,
            'description'           =>  $request->description,
        ]);

        Toast::message()->success()->notify();
        return redirect()->back();

    }

    public function destroy($debitCard)
    {
        DebitCard::delete($debitCard);
        Toast::message()->danger()->notify();
        return redirect()->back();
    }
}
