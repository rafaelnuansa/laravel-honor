<?php

namespace App\View\Components;

use App\Models\Pegawai;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Component;

class NavbarPegawai extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $pegawaiId = Auth::guard('pegawai')->user()->id;
        $navpegawai = Pegawai::find($pegawaiId);
        return ViewFacade::make('components.navbar-pegawai', [
            'navpegawai' => $navpegawai
        ]);
    }
}
