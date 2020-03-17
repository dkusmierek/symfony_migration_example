<?php

class defaultActions extends sfActions {
    public function executeIndex(sfWebRequest $request) {
        $this->title= "Symfony 1.4 Page";
    }
}
