<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use App\Models\RechargeRequest;
use Livewire\Attributes\Computed;
use TallStackUi\Traits\Interactions;
use App\Enums\RechargeRequestStatus;
use App\Events\RechargeRequestPlaced;

class RechargeForm extends Component
{

    use WithFileUploads, Interactions;

    public string $tab = 'natcash';

    public string $sender_fullname;
    public string $transcode;
    public ?int $amount;
    public string $sender_number;

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $screenshot;


    public mixed $paymentMethods = [
        'natcash' => [
            'provider' => 'NatCash',
            'description' => 'Pay with NatCash and get your balance instantly.',
            'holder_name' => 'NatCash',
            'account_number' => '1234 5678 9012 3456',
        ],
        'moncash' => [
            'provider' => 'MonCash',
            'description' => 'Pay with MonCash and get your balance instantly.',
            'holder_name' => 'MonCash',
            'account_number' => '1234 5678 9012 4444',
        ]
    ];


    #[Computed()]
    public function paymentMethod(): array
    {
        return $this->paymentMethods[$this->tab] ?? $this->paymentMethods['natcash'];
    }

    public function submitRequest(): void
    {
        $this->validate([
            'sender_fullname' => 'required|string|max:255',
            'transcode' => 'required|string|max:255',
            'amount' => 'required|integer|min:1|max:50000',
            'sender_number' => 'required|string|max:20',
            'screenshot' => 'required|image|max:4096|mimes:jpeg,png,jpg', // 4MB
        ]);

        try {
            RechargeRequest::query()->create([
                'user_id' => user()->id,
                'payment_method' => $this->paymentMethod['provider'],
                'sender_name' => $this->sender_fullname,
                'transcode' => $this->transcode,
                'amount' => $this->amount,
                'number' => $this->sender_number,
                'status' => RechargeRequestStatus::Pending->value,
                'screenshot_path' => $this->screenshot->store('screenshots', 'public')
            ]);
        } catch (\Throwable $th) {
            $this->dialog()->error('Error', 'An error occurred while submitting your recharge request. Please try again later.')->send();
            return;
        }

        broadcast(new RechargeRequestPlaced(user()));
        $this->reset(['sender_fullname', 'transcode', 'amount', 'sender_number', 'screenshot']);
        $this->dialog()->success('Success', 'Your recharge request has been submitted successfully.')->flash()->send();
        $this->redirectRoute('recharge-requests');
    }

    #[Title('Recharge')]
    public function render(): View
    {
        return view('livewire.recharge-form');
    }
}
