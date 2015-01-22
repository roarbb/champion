<?php namespace Champion\Utils;

trait Redirector
{
    /**
     * @param $path
     *
     * @SuppressWarnings("exit")
     */
    public function redirect($path)
    {
        $url = new Url();
        $link = $url->getAppBaseUri() . $path;

        header("Location: " . $link);
        die();
    }
}
