<?php
namespace NetBricks\SimpleCms\View;

class Application extends \Nbml\Component\Application
{

  static public $PATH = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\cms\public\..\src\NetBricks\SimpleCms\View\Application.nbml';

  /**
   * @return \NetBricks\SimpleCms\View\Application
   */
  static public function create() {
    return new \NetBricks\SimpleCms\View\Application();
  }

	protected $options = array(
				'model' => null,

			);

	public function __construct($options = array())
	{
        parent::__construct($options);
		
	$this->options['model'] = new \NetBricks\SimpleCms\ViewModel\ApplicationViewModel();
	
	}

	
        
    
    /**
     * @return \NetBricks\SimpleCms\View\Application
     */
    public function __invoke()
    {
              $model = $this->options['model'];
                            ob_start();

              ?><?php /**
 * @var $this \Nbml\Component\Application
 *
 * @var $model \NetBricks\SimpleCms\ViewModel\ApplicationViewModel
 */

echo $model->getContent();
        
       $this->text = ob_get_clean();
       return $this;
    }
}



