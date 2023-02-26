<?php

namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class DiaryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    /**
     * @test
     */
    public function it_lists_all_the_user_diaries()
    {
        $this->get(route('diaries.index'))
            ->assertOk()
            ->assertInertia(
                fn (Assert $page) => $page->component('Diaries/Index')->has('diaries', $this->user->diaries()->count()),
            );
    }

    /**
     * @test
     */
    public function it_stores_a_diary_if_all_fields_are_valid()
    {
        $this->get(route('diaries.index'))->assertOk();
        $diaryName = 'A random name';
        $this->post(route('diaries.store', compact('diaryName')))->assertRedirect(route('diaries.index'));

        $this->assertDatabaseHas('diaries', [
            'name' => $diaryName,
            'is_deletable' => true,
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * @test
     */
    public function it_does_not_store_a_diary_if_any_field_is_not_valid()
    {
        $this->get(route('diaries.index'))->assertOk();
        $this->post(route('diaries.store'))
            ->assertSessionHasErrors('diaryName')
            ->assertRedirect(route('diaries.index'));
    }

    /**
     * @test
     */
    public function it_deletes_a_diary_and_all_of_its_attached_screenplays()
    {
        $diary = $this->diaries['custom'];
        $this->get(route('diaries.index'))->assertOk();
        $this->delete(route('diaries.destroy', compact('diary')))
            ->assertRedirect(route('diaries.index'));

        $this->assertSoftDeleted('diaries', ['id' => $diary->id]);
    }

    /**
     * @test
     */
    public function it_does_not_delete_a_main_diary()
    {
        $diary = $this->diaries['watched'];
        $this->assertEquals(0, $diary->is_deletable);
        $this->get(route('diaries.index'))->assertOk();
        $this->delete(route('diaries.destroy', compact('diary')))
            ->assertRedirect(route('diaries.index'));

        $this->assertModelExists($diary);
    }
}
