<?php

class AppController {
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