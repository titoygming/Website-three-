<?php

namespace App\Livewire\Manager;

use App\Concerns\ErrorHandler;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.manager')]
class Users extends Component
{
    use ErrorHandler, WithPagination;

    public mixed $search = '';

    public mixed $quantity = 5;

    #[Computed()]
    public function users(): LengthAwarePaginator
    {
        return User::query()
            ->when($this->search, fn ($query, $search) => $query->whereLike('email', "%{$search}%")->orWhereLike('name', "%{$search}%"))
            ->paginate($this->quantity);
    }

    public function inactiveUser(User $user): void
    {
        try {
            (new UserService)->incative($user);
        } catch (\Throwable $th) {
            // throw $th;
            $this->dialog()->error('Error', 'Something went wrong')->send();

            return;
        }

        $this->dialog()->success('Success', __('User has been inactive successfully'))->send();
    }

    public function activeUser(User $user): void
    {
        try {
            (new UserService)->active($user);
        } catch (\Throwable $th) {
            // throw $th;
            $this->dialog()->error('Error', 'Something went wrong')->send();

            return;
        }

        $this->dialog()->success('Success', __('User has been active successfully'))->send();
    }

    public function banUser(User $user): void
    {
        try {
            (new UserService)->ban($user);
        } catch (\Throwable $th) {
            // throw $th;
            $this->dialog()->error('Error', 'Something went wrong')->send();

            return;
        }

        $this->dialog()->success('Success', __('User has been banned successfully'))->send();
    }

    public function unBanUser(User $user): void
    {
        try {
            (new UserService)->active($user);
        } catch (\Throwable $th) {
            // throw $th;
            $this->dialog()->error('Error', 'Something went wrong')->send();

            return;
        }

        $this->dialog()->success('Success', __('User has been unbanned successfully'))->send();
    }

    #[Title('Users')]
    public function render(): View
    {
        return view('livewire.manager.users');
    }
}
