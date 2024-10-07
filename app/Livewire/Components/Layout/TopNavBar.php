<?php

namespace App\Livewire\Components\Layout;

use App\Livewire\Actions\Logout;
use Livewire\Component;

class TopNavBar extends Component
{
    public function render()
    {
        return view('livewire.components.layout.top-nav-bar');
    }

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}
