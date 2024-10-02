<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CardTransactionStatusEnum;
use App\Functions\DateFormatter;
use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Models\CardTransaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CardTransactionController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {

       $cardTransactions = CardTransaction::query()->filterBy(
           request()->only(['amount', 'user_id', 'status', 'id', 'created_at'])
       );

       //If user's role is not admin then it only can own cards
       if(! Auth::guard('admin')->user()->hasRole('admin')){
           $cardTransactions->OwnCards(
               Auth::guard('admin')->id()
           );
       }

       $cardTransactions = $cardTransactions->paginate(15);

        return view('dashboard.card_transaction.index')
            ->with(['cardTransactions' => $cardTransactions]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.card_transaction.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request,[
            'student_id'            => ['required', 'exists:users,id'],
            'tracking_code'         => ['required', 'numeric'],
            'amount'                => ['required', 'numeric'],
            'paid_date'             => ['required'],
            'filename'              => ['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'description'           => ['required']
        ]);

        $imageName = time().'.'.$request->filename->extension();
        $request->filename->move(public_path('images/card-transactions'), $imageName);

        CardTransaction::query()->create([
            'student_id'            =>  $request->student_id,
            'tracking_code'         =>  $request->tracking_code,
            'amount'                =>  $request->amount,
            'paid_date'             =>  DateFormatter::format($request->paid_date),
            'status'                =>  CardTransactionStatusEnum::Pending,
            'filename'              =>  $imageName,
            'description'           =>  $request->description,
        ]);

        Toast::message()->success()->notify();
        return redirect()->route('admin.card-transaction.index');
    }

    /**
     * @param CardTransaction $cardTransaction
     * @return View
     */
    public function edit(CardTransaction $cardTransaction): View
    {
        return view('dashboard.card_transaction.edit')->with([
            'cardTransaction'  =>  $cardTransaction
        ]);
    }

    /**
     * @param CardTransaction $cardTransaction
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(CardTransaction $cardTransaction, Request $request): RedirectResponse
    {
        $this->validate($request,[
            'student_id'        => ['required', 'numeric', 'exists:users,id'],
            'tracking_code'     => ['required', 'numeric'],
            'amount'            => ['required', 'numeric'],
            'paid_date'         => ['required'],
            'filename'          => ['image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'description'       => ['required']
        ]);

        $imageName= $cardTransaction->filename;

        if ($request->has('filename'))
        {
            $imageName = time().'.'.$request->filename->extension();
            $request->filename->move(public_path('images/card-transactions'), $imageName);
        }

        CardTransaction::query()->where('id', $cardTransaction->id)->update([
            'student_id'            =>  $request->student_id,
            'tracking_code'         =>  $request->tracking_code,
            'amount'                =>  $request->amount,
            'paid_date'             =>  DateFormatter::format($request->paid_date),
            'status'                =>  CardTransactionStatusEnum::Pending,
            'filename'              =>  $imageName,
            'description'           =>  $request->description,
        ]);

        Toast::message()->success()->notify();
        return redirect(route('admin.card-transaction.index'));

    }

    /**
     * @param CardTransaction $cardTransaction
     * @return RedirectResponse
     */
    public function destroy(CardTransaction $cardTransaction): RedirectResponse
    {
        $cardTransaction->delete();
        Toast::message()->danger()->notify();
        return redirect()->back();
    }

    /**
     * @param CardTransaction $cardTransaction
     * @param Request $request
     * @return Response
     */
    public function changeStatus(CardTransaction $cardTransaction, Request $request): Response
    {
        $request->validate([
            'status' => ['required', Rule::enum(CardTransactionStatusEnum::class)]
        ]);

        $cardTransaction->update(['status' => $request->status]);

        return response($cardTransaction->withoutRelations(), 200);
    }

    /**
     * @param Request $request
     * @param CardTransaction $cardTransaction
     * @return Response
     */
    public function updateDescription(Request $request, CardTransaction $cardTransaction): Response
    {
        $request->validate([
            'description' => ['present']
        ]);

        $cardTransaction->update(['description' => $request->description]);

        return response([
            'message' => 'توضیحات با موفقیت ویرایش شد.'
        ]);
    }
}
