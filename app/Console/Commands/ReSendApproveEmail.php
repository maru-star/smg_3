<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

// メール送信用
use App\Mail\SendUserAprove;
use Illuminate\Support\Facades\Mail;




class ReSendApproveEmail extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'command:re_send_approve_email';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = '予約承認依頼メールをユーザーにおくり、該当メールの承認がなければサイド送信する';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    // 以下の内容は成功
    // $select_targets = Reservation::where('reservation_status', 2)->whereNotNull('approve_send_at')->get();
    // foreach ($select_targets as $key => $value) {
    //   $user = User::find($value->user_id);
    //   $email = $user->email;
    //   Mail::to($email)->send(new SendUserAprove($value->id));
    //   logger('メール自動送信テスト' . $key);
    // }
  }
}
