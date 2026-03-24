<?php

use Osoobe\Promocodes\Exceptions\PromocodeDoesNotExistException;
use Osoobe\Promocodes\Exceptions\PromocodeExpiredException;
use Osoobe\Promocodes\Facades\Promocodes;
use Osoobe\Promocodes\Models\Promocode;

it('should throw exception when promocode is expired', function () {
    $code = 'ABC-DEF';
    $promocode = Promocode::factory()->code($code)->notExpired()->boundToUser(false)->usagesLeft(2)->create();

    expect($promocode->expired_at)->toBeNull();

    expirePromocode($code);

    Promocodes::code($code)->apply();
})->throws(PromocodeExpiredException::class);

it('should return error if promocode not found', function () {
    $code = 'FOO-BAR';
    expirePromocode($code);
})->throws(PromocodeDoesNotExistException::class);
