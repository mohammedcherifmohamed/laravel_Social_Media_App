<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class postCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $content ;
    public $username ;
    public $image ;
    public $timeAgo ;
    public $user_image ;

    public function __construct($content,$user_image=null,$image=null,$timeAgo=null,$username=null)
    {
       $this->content = $content ;
       $this->username = $username ;
       $this->image = $image ;
       $this->user_image = $user_image ;
       $this->timeAgo = $timeAgo ?? 'just now';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post-card');
    }
}
