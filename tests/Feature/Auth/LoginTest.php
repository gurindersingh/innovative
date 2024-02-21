<?php

use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Auth\Login;
use App\Providers\RouteServiceProvider;

describe('login_test', function () {

    it('shows_login_page', function () {

        $this->get('/login')->assertSeeLivewire(Login::class);
    });

    it('can_authenticate_user', function () {
        $user = User::factory()->create();

        $component = Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'password');

        $component->call('login');

        $component
            ->assertHasNoErrors()
            ->assertRedirect(RouteServiceProvider::DASHBOARD);
    });

    it('throws_error_if_invalid_credentials', function () {
        $user = User::factory()->create();

        $component = Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'random-password');

        $component->call('login');

        $component
            ->assertHasErrors()
            ->assertNoRedirect();
    });
});
