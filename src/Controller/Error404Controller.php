<?php

namespace Alura\Mvc\Controller;

class Error404Controller implements Controller {
    public function __construct(private VideoRepository $repository) {
        
    }
    public function handle() {
        http_response_code(404);
    }
}