<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\Log;
use Auth;

class PostObserver {

    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post) {
        Log::create([
            'user_id' => Auth::user()->id,
            'content_id' => $post->id,
            'content_type' => 'Publicación',
            'action' => 'Crear',
            'description' => 'El usuario #' . Auth::user()->id . ' creó el post #' . $post->id . '.'
        ]);
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updating(Post $post) {
        $old_post = Post::find($post->id);
        if ($old_post->tittle != $post->tittle) {
            Log::create([
                'user_id' => Auth::user()->id,
                'content_id' => $post->id,
                'content_type' => 'Publicación',
                'action' => 'Actualizar',
                'description' => 'El usuario #' . Auth::user()->id . ' actualizó el título de la publicación #' . $post->id . ' de "'
                . $old_post->tittle . '" a "' . $post->tittle . '".'
            ]);
        }
        if ($old_post->text != $post->text) {
            Log::create([
                'user_id' => Auth::user()->id,
                'content_id' => $post->id,
                'content_type' => 'Publicación',
                'action' => 'Actualizar',
                'description' => 'El usuario #' . Auth::user()->id . ' actualizó el texto de la publicación #' . $post->id . ' de "'
                . $old_post->text . '" a "' . $post->text . '".'
            ]);
        }
        if ($old_post->type_id != $post->type_id) {
            Log::create([
                'user_id' => Auth::user()->id,
                'content_id' => $post->id,
                'content_type' => 'Publicación',
                'action' => 'Actualizar',
                'description' => 'El usuario #' . Auth::user()->id . ' actualizó el tipo de la publicación#' . $post->id . ' de "'
                . $old_post->get_id_name('types', $old_post->type_id) . '" a "' . $post->get_id_name('types', $post->type_id) . '".'
            ]);
        }
        if ($old_post->category_id != $post->category_id) {
            Log::create([
                'user_id' => Auth::user()->id,
                'content_id' => $post->id,
                'content_type' => 'Publicación',
                'action' => 'Actualizar',
                'description' => 'El usuario #' . Auth::user()->id . ' actualizó la categoría de la publicación #' . $post->id . ' de "'
                . $old_post->get_id_name('categories', $old_post->category_id) . '" a "' . $post->get_id_name('categories', $post->category_id) . '".'
            ]);
        }
        if ($old_post->status_id != $post->status_id) {
            Log::create([
                'user_id' => Auth::user()->id,
                'content_id' => $post->id,
                'content_type' => 'Publicación',
                'action' => 'Actualizar',
                'description' => 'El usuario #' . Auth::user()->id . ' actualizó el estado de la publicación #' . $post->id . ' de "'
                . $old_post->get_id_name('statuses', $old_post->status_id) . '" a "' . $post->get_id_name('statuses', $post->status_id) . '".'
            ]);
        }
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post) {
        Log::create([
            'user_id' => Auth::user()->id,
            'content_id' => $post->id,
            'content_type' => 'Publicación',
            'action' => 'Eliminar',
            'description' => 'El usuario #' . Auth::user()->id . ' eliminó el post #' . $post->id . '.'
        ]);
    }

}
