<?php

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

test('Un usuario no puede eliminarse a si mismo', function (){
    // 1) Crear un usuario en la BD d e pruebas
    $user = User::factory()->create(
        [
            'email_verified_at' => now()
        ]
    );

    // 2) Simular que el usuario inicio sesion
    $this->actingAs($user, 'web');

    // 3) Simular que intenta borrar un usuario
    $response = $this->delete(route('admin.users.destroy', $user));

    // 4) Esperar a que el servidor bloquee esta accion
    $response->assertStatus(403);

    // 5) Verificamos que el usuario siga existiendo en DB
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
    ]);
});