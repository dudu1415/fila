<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\DiveMade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MakeDiv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $num1;
    public $num2;
    public $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($num1,$num2,$userId)
    {
        $this->num1 = $num1;
        $this->num2 = $num2;
        $this->userId =$userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $div = $this->num1 / $this->num2;
        $user = User::find($this->userId);
        if($div){
            $user->notify(new DiveMade('Sucesso!','Div = ',$div));
        }
        if($this->num2 == 0)
            $user->notify(new DiveMade('Erro!','Divisão por zero'));
    }
}
