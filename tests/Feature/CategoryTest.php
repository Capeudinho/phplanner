<?php

use App\Models\User;
use App\Models\Category;
use App\Enums\CategoryColor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_list_categories()
    {
        $user = User::factory()->create();
        $categories = Category::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->get(route('category.index'));

        $response->assertOk();
        $response->assertViewHas('categories', function ($viewCategories) use ($categories) {
            return $viewCategories->pluck('id')->sort()->values()->all() === $categories->pluck('id')->sort()->values()->all();
        });
    }

    /** @test */
    public function can_create_a_new_category()
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'Pessoal',
            'color' => CategoryColor::RED->value,
        ];

        $response = $this->actingAs($user)
            ->post(route('category.store'), $data);

        $response->assertRedirect(route('category.index'))
            ->assertSessionHas('success', 'Categoria criada com sucesso!');

        $this->assertDatabaseHas('categories', [
            'name' => $data['name'],
            'color' => $data['color'],
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function can_update_a_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = [
            'name' => 'Trabalho',
            'color' => CategoryColor::RED->value,
        ];

        $response = $this->actingAs($user)
            ->put(route('category.update', $category), $data);

        $response->assertRedirect(route('category.index'))
            ->assertSessionHas('success', 'Categoria atualizada com sucesso!');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => $data['name'],
            'color' => $data['color'],
        ]);
    }

    /** @test */
    public function can_delete_a_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->delete(route('category.destroy', $category));

        $response->assertRedirect(route('category.index'))
            ->assertSessionHas('success', 'Categoria excluída com sucesso!');

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    /** @test */
    public function cannot_access_another_users_category()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user)
            ->get(route('category.edit', $category));

        $response->assertRedirect(route('category.index'))
            ->assertSessionHas('error', 'Categoria não encontrada.');
    }

    /** @test */
    public function cannot_create_a_category_without_a_name()
    {
        $user = User::factory()->create();
        $data = [
            'color' => CategoryColor::RED->value,
        ];

        $response = $this->actingAs($user)
            ->post(route('category.store'), $data);

        $response->assertSessionHasErrors('name')
            ->assertSessionHas('errors', function ($errors) {
                return $errors->has('name') && $errors->first('name') === 'O nome da categoria é obrigatório.';
            });
    }

    /** @test */
    public function cannot_create_a_category_with_a_non_string_name()
    {
        $user = User::factory()->create();
        $data = [
            'name' => 12345,
            'color' => CategoryColor::RED->value,
        ];

        $response = $this->actingAs($user)
            ->post(route('category.store'), $data);

        $response->assertSessionHasErrors('name')
            ->assertSessionHas('errors', function ($errors) {
                return $errors->has('name') && $errors->first('name') === 'O nome da categoria deve ser uma string.';
            });
    }

    /** @test */
    public function cannot_create_a_category_without_a_color()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Categoria Sem Cor',
        ];

        $response = $this->actingAs($user)
            ->post(route('category.store'), $data);

        $response->assertSessionHasErrors('color')
            ->assertSessionHas('errors', function ($errors) {
                return $errors->has('color') && $errors->first('color') === 'A cor da categoria é obrigatória.';
            });
    }

    /** @test */
    public function cannot_create_a_category_with_an_invalid_color()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Categoria',
            'color' => 'invalid_color_value',
        ];

        $response = $this->actingAs($user)
            ->post(route('category.store'), $data);

        $response->assertSessionHasErrors('color')
            ->assertSessionHas('errors', function ($errors) {
                return $errors->has('color') && $errors->first('color') === 'A cor selecionada é inválida.';
            });
    }


    /** @test */
    public function cannot_update_a_category_without_a_name()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = [
            'color' => CategoryColor::BLUE->value,
        ];

        $response = $this->actingAs($user)
            ->put(route('category.update', $category), $data);

        $response->assertSessionHasErrors('name')
            ->assertSessionHas('errors', function ($errors) {
                return $errors->has('name') && $errors->first('name') === 'O nome da categoria é obrigatório.';
            });
    }

    /** @test */
    public function cannot_update_a_category_without_a_color()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = [
            'name' => 'Categoria Atualizada',
        ];

        $response = $this->actingAs($user)
            ->put(route('category.update', $category), $data);

        $response->assertSessionHasErrors('color')
            ->assertSessionHas('errors', function ($errors) {
                return $errors->has('color') && $errors->first('color') === 'A cor da categoria é obrigatória.';
            });
    }

    /** @test */
    public function cannot_update_another_users_category()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $otherUser->id]);

        $data = [
            'name' => 'Tentativa de Atualização',
            'color' => CategoryColor::RED->value,
        ];

        $response = $this->actingAs($user)
            ->put(route('category.update', $category), $data);

        $response->assertRedirect(route('category.index'))
            ->assertSessionHas('error', 'Categoria não encontrada.');
    }

    /** @test */
    public function cannot_update_a_category_with_an_invalid_color()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = [
            'name' => 'Categoria Atualizada',
            'color' => 'invalid_color_value',
        ];

        $response = $this->actingAs($user)
            ->put(route('category.update', $category), $data);

        $response->assertSessionHasErrors('color')
            ->assertSessionHas('errors', function ($errors) {
                return $errors->has('color') && $errors->first('color') === 'A cor selecionada é inválida.';
            });
    }
}
