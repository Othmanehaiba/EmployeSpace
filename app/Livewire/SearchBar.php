<?php

use Livewire\Component;

class SearchBar extends Component{

    public $search = "";

    public function render(){
    	return view('components.search-bar');
    }
}


?>