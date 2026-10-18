<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('landing page menampilkan hero, fitur, dan link login', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee(config('app.name'))
        ->assertSee('Masuk ke Aplikasi')
        ->assertSee(url('/login'), false)
        ->assertSee('Rekap Kehadiran');
});
