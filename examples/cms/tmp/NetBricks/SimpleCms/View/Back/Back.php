<?php
namespace NetBricks\SimpleCms\View;

class Back extends \Nbml\Component
{

  static public $PATH = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\cms\public\..\src\NetBricks\SimpleCms\View\Back\Back.nbml';

  /**
   * @return \NetBricks\SimpleCms\View\Back
   */
  static public function create() {
    return new \NetBricks\SimpleCms\View\Back();
  }

	protected $options = array(
				'model' => null,

			);

	public function __construct($options = array())
	{
        parent::__construct($options);
		
	$this->options['model'] = new \NetBricks\SimpleCms\ViewModel\BackViewModel();
	        if(!\NetBricks\SimpleCms\Di::isLogged()) {
            header('Location: /login');
        }

            \Nbml\Component\Application::getInstance()
                                ->styleSheets()->add('/css/back.css');

        
	}

	
        
    
    /**
     * @return \NetBricks\SimpleCms\View\Back
     */
    public function __invoke()
    {
              $model = $this->options['model'];
                            ob_start();

              ?><?php /**
 * [AdminAccess]
 * [Css('/css/back.css')]
 * @var $this \Nbml\Component
 *
 * @var $model \NetBricks\SimpleCms\ViewModel\BackViewModel
 *
 */ ?>
<div class="header">
NetBricks SimpleCMS
    <ul class="user_menu">
        <li>
            <a href="/">frontend</a>
        </li>
        <li>
            <a href="/logout">logout</a>
        </li>
    </ul>
</div>

<div class="menu">
    <ul>
        <li>
            <a href="/admin/password">Change password</a>
        </li>
        <li>
            <a href="/admin/articles">Articles</a>
        </li>
    </ul>
</div>

<div class="content">
    <?=$model->getContent()?>
</div>

<div class="footer">

</div>
                    <?php        
       $this->text = ob_get_clean();
       return $this;
    }
}



