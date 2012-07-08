<?php
namespace NetBricks\SimpleCms\View\Back;

class Dashboard extends \Nbml\Component
{

  static public $PATH = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\cms\public\..\src\NetBricks\SimpleCms\View\Back\Dashboard.nbml';

  /**
   * @return \NetBricks\SimpleCms\View\Back\Dashboard
   */
  static public function create() {
    return new \NetBricks\SimpleCms\View\Back\Dashboard();
  }

	protected $options = array(
			);

	public function __construct($options = array())
	{
        parent::__construct($options);
		
	        if(!\NetBricks\SimpleCms\Di::isLogged()) {
            header('Location: /login');
        }

	}

	
    
    
    /**
     * @return \NetBricks\SimpleCms\View\Back\Dashboard
     */
    public function __invoke()
    {
                            ob_start();

              ?><?php /**
 * [AdminAccess]
 * @var $this \Nbml\Component
 */ ?>
Dashboard
                    <?php        
       $this->text = ob_get_clean();
       return $this;
    }
}



