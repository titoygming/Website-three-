<?php

namespace App\Livewire\Manager;

use App\Concerns\ErrorHandler;
use App\Events\RechargeRequestAccepted;
use App\Events\RechargeRequestDone;
use App\Events\RechargeRequestRejected;
use App\Models\RechargeRequest;
use App\Services\WalletManagementService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.manager')]
class RechargeRequests extends Component
{
    use ErrorHandler;

    public ?int $quantity = 5;
    public string $search = '';

    public bool $modal = false;
    public bool $viewDetail = false;
    public int $amount = 0;
    public string $request_id = '';

    public ?RechargeRequest $request = null;

    #[Computed()]
    public function rechargeRequests(): LengthAwarePaginator
    {
        return RechargeRequest::query()->paginate($this->quantity);
    }

    public function markAsRejected(RechargeRequest $rechargeRequest): void
    {
        try {
            $rechargeRequest->markAsRejected();
        } catch (\Throwable $th) {
            $this->dialog()->error('general', __('Failed to mark recharge request as rejected. Please try again later.'))->send();
            return;
        }
        broadcast(new RechargeRequestRejected($rechargeRequest->user));
        $this->dialog()->success('Success', __('Recharge request has been marked as rejected'))->send();
    }

    public function markAsAccepted(RechargeRequest $rechargeRequest): void
    {

        try {
            $rechargeRequest->markAsApproved();
        } catch (\Throwable $th) {
            $this->dialog()
                ->error('general', __('Failed to mark recharge request as accepted. Please try again later.'))
                ->send();
            return;
        }

        $this->toast()
            ->success('Success', __('Recharge request has been marked as accepted'))
            ->send();

        $this->modal = true;
        $this->amount = $rechargeRequest->amount;
        $this->request_id = $rechargeRequest->id;

        broadcast(new RechargeRequestAccepted($rechargeRequest->user));
    }

    public function rechargeUserAccount(RechargeRequest $rechargeRequest): void
    {
        $this->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:50000']
        ]);

        DB::beginTransaction();
        try {
            $rechargeRequest->markAsDone();
            (new WalletManagementService())
                ->credit($rechargeRequest->user, $this->amount);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            $this->dialog()->error('general', 'Failed to recharge user account')->send();
            return;
        }

        $this->amount = 0;
        $this->modal = false;
        $this->request_id = '';
        broadcast(new RechargeRequestDone($rechargeRequest->user));
        $this->dialog()->success('Success', 'User account has been recharged!.')->send();
    }

    public function rechargeAccount(RechargeRequest $rechargeRequest): void
    {
        $this->modal = true;
        $this->amount = $rechargeRequest->amount;
        $this->request_id = $rechargeRequest->id;
    }

    public function viewDetails(RechargeRequest $rechargeRequest): void
    {
        $this->request = $rechargeRequest;
        $this->viewDetail = true;
    }



    #[Title('Recharge Requests')]
    public function render(): View
    {
        return view('livewire.manager.recharge-requests');
    }
}
