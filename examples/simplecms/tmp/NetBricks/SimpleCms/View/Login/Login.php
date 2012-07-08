<?php
namespace NetBricks\SimpleCms\View;

class Login extends \Nbml\Component
{

  static public $PATH = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\cms\public\..\src\NetBricks\SimpleCms\View\Login\Login.nbml';

  /**
   * @return \NetBricks\SimpleCms\View\Login
   */
  static public function create() {
    return new \NetBricks\SimpleCms\View\Login();
  }

	protected $options = array(
				'model' => null,

			);

	public function __construct($options = array())
	{
        parent::__construct($options);
		
	$this->options['model'] = new \NetBricks\SimpleCms\ViewModel\LoginViewModel();
	
            \Nbml\Component\Application::getInstance()
                                ->styleSheets()->add('/css/login.css');

        
	}

	
        
    
    /**
     * @return \NetBricks\SimpleCms\View\Login
     */
    public function __invoke()
    {
              $model = $this->options['model'];
                            ob_start();

              ?><?php /**
 * [Css('/css/login.css')]
 * @var $this \Nbml\Component
 *
 * @var $model \NetBricks\SimpleCms\ViewModel\LoginViewModel
 */ ?>
<form action="" method="post">

    <?php foreach($model->errorMessages as $msg): ?>
    <p class="warning"><?=$msg?></p>
    <?php endforeach; ?>

    <dl>
        <dt>
            <label for="username_input">Username</label>
        </dt>
        <dd>
            <input id="username_input"
                   type="text"
                   name="username"
                   value="<?=$model->username?>"/>
        </dd>

        <dt>
            <label for="password_input">Password</label>
        </dt>
        <dd>
            <input id="password_input"
                   type="password"
                    name="password"/>
        </dd>
    </dl>

    <input type="submit" value="Login"/>

</form>
                    <?php        
       $this->text = ob_get_clean();
       return $this;
    }
}



