<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\View;
use Tests\TestCase;
class UserTest extends TestCase
{
    public function testExample()
    {
        $user = (new FunctionsTest)->get_user();
        //dd($user);
        $this->actingAs($user)
            ->get('/login')
            ->assertRedirect('home');
        $response = $this->get('index_usuario/1/0');
        $this->assertTrue($response->isOk());
        View::make('catalogos.listados.usuarios_list')->with([
                    'items' => User::all(),
                    'titulo_catalogo' => 'Catálogo',
                    'user' => 1,
                    'tableName'=>'hola',
                    'npage'=> 0,
                    'tpaginas' => 0,
                ]);
    }

}
