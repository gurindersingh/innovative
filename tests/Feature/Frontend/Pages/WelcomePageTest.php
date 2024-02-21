<?php

use App\Livewire\Frontend\Pages\Welcome;

describe('welcome_page_test', function() {

    it('shows_welcome_page', function() {
        $res = $this->get('/')->assertSeeLivewire(Welcome::class)->assertSee('Login');

        expect($res->status())->toBe(200);
    });

});