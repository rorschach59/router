<?php

require 'model/DatabaseModel.php';

class DefaultController
{

    const PATH_VIEWS = 'view';

    /**
     * Show a template
     * @param string $file Pathfile
     * @param array  $data Datas will be used on the view
     */
    public static function show($file, array $data = array())
    {
        
        // Call the class for render
        $engine = new \League\Plates\Engine(self::PATH_VIEWS);

        // Notification message
        // $flash_message = (isset($_SESSION['flash']) && !empty($_SESSION['flash'])) ? (object) $_SESSION['flash'] : null;

        $flash_message = self::flashMessage();

        $engine->addData( compact('flash_message') );
        // Add each datas to the view
        foreach($data as $key => $value) {
            $engine->addData( [ $key => $value ] );
        }

        // Delete the extension, not usefull but just in case
        $file = str_replace('.php', '', $file);

        // Render the template
        echo $engine->render('common/header', compact(''));
        echo $engine->render($file);
        echo $engine->render('common/footer', compact(''));
        
        // Delete the notification messages to see them only one time
        if(isset($_SESSION['flash'])) {
            unset($_SESSION['flash']);
        }
        die();
    }

    private static function flashMessage()
    {

        $flash_message = (isset($_SESSION['flash']) && !empty($_SESSION['flash'])) ? (object) $_SESSION['flash'] : null;

        if(isset($flash_message) && !empty($flash_message)) {
            return '
            <div class="alert alert-'.$flash_message->level.' alert-dismissible fade show" role="alert">
                '.$flash_message->message.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        }

    }
}