<?php

class HelloWorld extends \Nbml\Component\Application
{

    static public $DIR = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\hello_world\HelloWorld\HelloWorld.nbml';

    /**
     * @return \HelloWorld
     */
    static public function create()
    {
        return new \HelloWorld();
    }

    protected $options = array();

    public function __construct($options = array())
    {
        parent::__construct($options);
    }


    /**
     * @return \HelloWorld
     */
    public function __invoke()
    {
        ob_start();

        ?><?php /**
     * @var $this \Nbml\Component\Application
     */
        ?>

    Hello World!
    <?php
        $this->text = ob_get_clean();
        return $this;
    }
}



