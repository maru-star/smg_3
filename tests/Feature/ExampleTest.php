<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Admin;
use App\Models\Venue;


class ExampleTest extends TestCase
{
  /**
   * A basic test example.
   *
   * @return void
   */

  public function testLoginView()
  {
    $response = $this->get('admin/login');
    $response->assertStatus(200);
    // 認証されていないことを確認
    $this->assertGuest();
  }

  public function testNonloginAccess()
  {
    $this->visit('/signup')
      ->type('dup@gmail.com', 'email')
      ->type('testtest', 'password')
      ->type('testtest', 'password_confirmation')
      ->type('山田', 'last_name')
      ->type('太郎', 'first_name')
      ->press('保存')
      ->dontSee('会員登録完了');
  }
}
