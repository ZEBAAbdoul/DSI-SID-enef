<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dashboard extends Component
{
    public array $stats;
    public $prochainesSessions;
    public $formationsPopulaires;
    public $inscriptionsParMois;

    /**
     * Create a new component instance.
     */
    public function __construct(
        array $stats = [],
        $prochainesSessions = null,
        $formationsPopulaires = null,
        $inscriptionsParMois = null
    ) {
        $this->stats = $stats;
        $this->prochainesSessions = $prochainesSessions;
        $this->formationsPopulaires = $formationsPopulaires;
        $this->inscriptionsParMois = $inscriptionsParMois;

        $user = User::count();
        view()->share('user', $user);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard');
    }
}