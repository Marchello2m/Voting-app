<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Http\Response;
use Livewire\Component;

class MarkCommentAsNotSpam extends Component
{
    public Comment $comment;

    protected $listeners = ['setMarkAsNotSpamComment'];

    public function setMarkAsNotSpamComment($commentId)
    {
        $this->comment = Comment::findOrFail($commentId);

        $this->emit('markAsNotSpamCommentWasSet');
    }

    public function markAsNotSpam()
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->comment->spam_reports=0;
        $this->comment->save();

        $this->emit('commentWasMarkedAsNotSpam', 'Comment was marked as not spam!');
    }

    public function render()
    {
        return view('livewire.mark-comment-as-not-spam');
    }
}
