<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PostCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $content ;
    public $username ;
    public $image ;
    public $timeAgo ;
    public $userImage ;
    public $post ;

    public function __construct($post,$content,$userImage=null,$image=null,$timeAgo=null,$username=null)
    {
        $this->post = $post;
       $this->content = $content ;
       $this->username = $username ;
       $this->image = $image ;
       $this->userImage = $userImage ;
       $this->timeAgo = $timeAgo ?? 'just now';
        // dd($this->post,$this->content,$this->username,$this->image,$this->userImage,$this->timeAgo);
    //    dd($this->content,$this->username,$this->image,$this->user_image,$this->timeAgo);

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post-card');
    }
}
