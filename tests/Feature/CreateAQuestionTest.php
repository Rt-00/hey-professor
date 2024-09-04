<?php

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('should be able to create a new question bigger tham 255 characters', function () {
    // Arrange :: Preparar
    $user = \App\Models\User::factory()->create();
    actingAs($user);

    // Act
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 260).'?',
    ]);

    // Assert
    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260).'?']);
});

it('should check if ends with question mark ?', function () {});

it('should have at least 10 characters', function () {
    // Arrange :: Preparar
    $user = \App\Models\User::factory()->create();
    actingAs($user);

    // Act
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 8).'?',
    ]);

    // Assert
    $request->assertSessionHasErrors([
        // 'question' => 'The question field must be at least 10 characters.'
        'question' => __('validation.min.string', [
            'min' => 10,
            'attribute' => 'question',
        ]),
    ]);
});
