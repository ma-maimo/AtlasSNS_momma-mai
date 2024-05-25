<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //初期ユーザー登録
        DB::table('users')->insert([
            'username' => '初期ユーザー',
            'mail' => 'syoki-yu-za-@syoki@com',
            'password' => bcrypt('syoki1234') //bcrypt( )→暗号化
        ]);
    }
}
