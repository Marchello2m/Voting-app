<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CommentNotifications extends Component
{
    const NOTIFICATION_THRESHOLD =20;
    public $notifications;
    public $notificationsCount;
    public $isLoading;

    protected $listeners =['getNotifications'];

    public function mount()
    {
        $this->notifications = collect([]);
        $this->isLoading = true;
        $this->getNotificationsCount();
    }

    public function getNotificationsCount()
    {
        $this->notificationsCount = auth()->user()->unreadNotifications()->count();

        if ($this->notificationsCount > self::NOTIFICATION_THRESHOLD){
            $this->notificationsCount = self::NOTIFICATION_THRESHOLD. '+';
        }
    }

    public function getNotifications()
    {

        $this->notifications=  auth()->user()->unreadNotifications()
            ->latest()
            ->take(self::NOTIFICATION_THRESHOLD)
            ->get();

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.comment-notifications');
    }
}
