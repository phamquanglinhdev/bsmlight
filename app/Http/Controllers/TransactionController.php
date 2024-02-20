<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use App\Models\Affiliate;
use App\Models\Card;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function createCardTransaction(Request $request): View
    {
        $cardId = $request->get('card_id');

        $card = Card::query()->where('id', $cardId)->firstOrFail(['id', 'uuid']);

        $crudBag = new CrudBag();

        $crudBag->setAction('transaction.store.card');
        $crudBag->setLabel('Giao dịch thẻ học');
        $crudBag->setHasFile(true);

        $crudBag->addFields([
            'name' => 'card_id',
            'label' => 'Thẻ học',
            'type' => 'select',
            'options' => [
                $card['id'] => $card['uuid']
            ],
            'required' => true
        ]);

        $crudBag->addFields([
            'name' => 'amount',
            'type' => 'number',
            'label' => 'Số tiền',
            'attributes' => [
                'suffix' => 'đ'
            ],
            'required' => true
        ]);

        $crudBag->addFields([
            'name' => 'notes',
            'type' => 'textarea',
            'label' => 'Ghi chú',
            'class' => 'col-10 mb-3'
        ]);

        $crudBag->addFields([
            'name' => 'affiliate_users',
            'type' => 'select-multiple',
            'label' => 'Nhân sự hưởng doanh số',
            'options' => User::query()->where('branch', Auth::user()->{'branch'})->get(['id', 'name', 'uuid'])->mapWithKeys(
                fn($user) => [
                    $user->id => $user->name . ' - ' . $user->uuid
                ]
            )->toArray(),
        ]);

        $crudBag->addFields([
            'name' => 'transaction_type',
            'type' => 'select',
            'label' => 'Loại giao dịch',
            'options' => [
                Transaction::RENEW_TYPE => 'Gia hạn - Renew',
                Transaction::NEW_TYPE => 'Mới - New',
            ],
        ]);

        $crudBag->addFields([
            'name' => 'object_image',
            'type' => 'upload',
            'label' => 'Bằng chứng giao dịch',
            'class' => 'col-10'
        ]);


        return view('create', [
            'crudBag' => $crudBag
        ]);
    }

    public function storeCardTransaction(Request $request)
    {
        $this->validate($request, [
            'card_id' => 'required|exists:cards,id',
            'amount' => 'required',
            'transaction_type' => 'required',
            'object_image' => 'file|nullable',
            'affiliate_users' => 'array|nullable',
            'affiliate_users.*' => 'integer|exists:users,id',
        ]);

        $dataToCreateTransaction = [
            'object_type' => Transaction::CARD_TRANSACTION_TYPE,
            'object_id' => $request->get('card_id'),
            'uuid' => Carbon::now()->timestamp,
            'amount' => str_replace(',', '', $request->get('amount')),
            'transaction_type' => $request->get('transaction_type'),
            'notes' => $request->get('notes') ?? 'Không có ghi chú',
            'status' => Transaction::PENDING_STATUS,
            'object_image' => $request->file('object_image') ? uploads($request->file('object_image')) : null,
            'created_by' => Auth::id()
        ];

        $affiliate_users = $request->get('affiliate_users');

        DB::transaction(function () use ($dataToCreateTransaction, $affiliate_users) {
            /**
             * @var Transaction $transaction
             */
            $transaction = Transaction::query()->create($dataToCreateTransaction);

            foreach ($affiliate_users ?? [] as $userId) {
                Affiliate::query()->updateOrCreate([
                    'transaction_id' => $transaction->id,
                    'user_id' => $userId,
                ], [
                    'transaction_id' => $transaction->id,
                    'user_id' => $userId,
                    'transaction_amount' => $transaction->amount
                ]);
            }
        });

        return redirect('/card/show/' . $request->get('card_id'));
    }


    public function accept(int $id): RedirectResponse
    {
        /**
         * @var Transaction $transaction
         */
        $transaction = Transaction::query()->findOrFail($id);

        DB::transaction(function () use ($transaction) {
            $transaction->update([
                'status' => Transaction::ACTIVE_STATUS
            ]);
            $this->handleEffect($transaction);
        });


        return redirect()->back()->with('success', 'Giao dịch đã được phê duyệt');
    }

    public function deny(int $id): RedirectResponse
    {

        $transaction = Transaction::query()->findOrFail($id);

        $transaction->update([
            'status' => Transaction::CANCEL_STATUS
        ]);

        return redirect()->back()->with('success', 'Giao dịch đã bị từ chối');
    }

    private function handleEffect(Transaction $transaction)
    {
        if ($transaction['object_type'] == Transaction::CARD_TRANSACTION_TYPE) {
            /**
             * @var Card $card
             */
            $card = Card::query()->findOrFail($transaction['object_id']);

            $daily = $card->getDailyFeeAttribute();

            $totalFee = $card->paid_fee + $transaction->amount;

            $addedDay = 0;

            if ($totalFee > $card->original_fee) {
                $addedDay = $transaction->amount / $daily;
            }

            $card->update([
                'paid_fee' => $totalFee,
                'original_days' => $card->original_days + $addedDay,
                'original_fee' => $card->original_fee + ($addedDay * $daily),
            ]);
        }
    }
}
