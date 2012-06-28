<?php
namespace Nbml\Component;

class HtmlTag extends \Nbml\Component
{

  protected $options = array();

  public function __construct()
  {

  }


  /**
   * @return \Nbml\Component\HtmlTag
   */
  public function __invoke()
  {
    ob_start();

    ?>
  <?php
    $this->text = ob_get_clean();
    return $this;
  }
}



