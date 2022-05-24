<?php

class AppController {
    private $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isPost() : bool
    {
           return $this->request === "POST";
    }

    protected function isGet() : bool
    {
        return $this->request === "GET";
    }

    protected function render(string $filename = null, array $variables = []){
        $filenamePath = 'public/views/'.$filename.'.php';
        $output = 'File not found';

        if(file_exists($filenamePath)){
            extract($variables);

            ob_start();
            include $filenamePath;
            $output = ob_get_clean();
        }

        print $output; // print website
    }
    
}