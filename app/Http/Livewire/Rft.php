<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Session\SessionManager;
use App\Models\SignalBit\Rft as RftModel;
use App\Models\SignalBit\Rework;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class Rft extends Component
{
    public $orderInfo;
    public $orderWsDetailSizes;
    public $output;
    public $outputInput;
    public $sizeInput;
    public $sizeInputText;
    public $submitting;

    protected $rules = [
        'outputInput' => 'required|numeric|min:1',
        'sizeInput' => 'required',
    ];

    protected $messages = [
        'outputInput.required' => 'Harap tentukan kuantitas output.',
        'outputInput.numeric' => 'Harap isi kuantitas output dengan angka.',
        'outputInput.min' => 'Kuantitas output tidak bisa kurang dari 1.',
        'sizeInput.required' => 'Harap tentukan ukuran output.',
    ];

    protected $listeners = [
        'updateWsDetailSizes' => 'updateWsDetailSizes',
    ];

    public function mount(SessionManager $session, $orderWsDetailSizes)
    {
        $this->orderWsDetailSizes = $orderWsDetailSizes;
        $session->put('orderWsDetailSizes', $orderWsDetailSizes);
        $this->output = 0;
        $this->outputInput = 1;
        $this->sizeInput = null;
        $this->sizeInputText = null;
        $this->submitting = false;
    }

    public function updateWsDetailSizes()
    {
        $this->outputInput = 1;
        $this->sizeInput = null;
        $this->sizeInputText = '';

        $this->orderInfo = session()->get('orderInfo', $this->orderInfo);
        $this->orderWsDetailSizes = session()->get('orderWsDetailSizes', $this->orderWsDetailSizes);
    }

    public function clearInput()
    {
        $this->outputInput = 1;
        $this->sizeInput = null;
        $this->sizeInputText = '';
    }

    public function outputIncrement()
    {
        $this->outputInput++;
    }

    public function outputDecrement()
    {
        if (($this->outputInput-1) < 1) {
            $this->emit('alert', 'warning', "Kuantitas output tidak bisa kurang dari 1.");
        } else {
            $this->outputInput--;
        }
    }

    public function setSizeInput($size, $sizeText)
    {
        $this->sizeInput = $size;
        $this->sizeInputText = $sizeText;
    }

    public function submitInput()
    {
        $validatedData = $this->validate();

        $insertData = [];
        for ($i = 0; $i < $this->outputInput; $i++)
        {
            array_push($insertData, [
                'master_plan_id' => $this->orderInfo->id,
                'so_det_id' => $this->sizeInput,
                'status' => 'NORMAL',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        $insertRft = RftModel::insert($insertData);

        if ($insertRft) {
            $getSize = DB::table('so_det')
                ->select('id', 'size')
                ->where('id', $this->sizeInput)
                ->first();

            $this->emit('alert', 'success', $this->outputInput." output berukuran ".$getSize->size." berhasil terekam.");

            $this->outputInput = 1;
            $this->sizeInput = '';
        } else {
            $this->emit('alert', 'error', "Terjadi kesalahan. Output tidak berhasil direkam.");
        }
    }

    public function render(SessionManager $session)
    {
        $this->orderInfo = $session->get('orderInfo', $this->orderInfo);
        $this->orderWsDetailSizes = $session->get('orderWsDetailSizes', $this->orderWsDetailSizes);

        // Get total output
        $this->output = RftModel::
            where('master_plan_id', $this->orderInfo->id)->
            where('status', 'normal')->
            count();

        return view('livewire.rft');
    }

    public function dehydrate()
    {
        $this->resetValidation();
        $this->resetErrorBag();
    }
}
