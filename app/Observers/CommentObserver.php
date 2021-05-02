<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Log;
use Auth;

class CommentObserver {

    /**
     * Handle the Comment "created" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function created(Comment $comment) {
        $post = Post::find($comment->post_id);
        if ($post->type_id == 2) {
            $action = ' respondió a la pregunta #';
            if ($post->status_id == 1) {
                $confirmation = '. Se cambiará el estado de la pregunta a "Actualizada".';
            } else {
                $confirmation = '.';
            }
        } else {
            $action = ' comentó en la publicación informativa #';
            $confirmation = '.';
        }
        Log::create([
            'user_id' => Auth::user()->id,
            'content_id' => $comment->post_id,
            'content_type' => 'Comentario',
            'action' => 'Crear',
            'description' => 'El usuario #' . Auth::user()->id . $action . $comment->post_id . $confirmation
        ]);
    }

}
