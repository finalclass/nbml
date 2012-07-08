<?php
namespace NetBricks\SimpleCms\View\Back;

class ChangePassword extends \Nbml\Component
{

  static public $PATH = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\simplecms\public\..\src\NetBricks\SimpleCms\View\Back\ChangePassword.nbml';

  /**
   * @return \NetBricks\SimpleCms\View\Back\ChangePassword
   */
  static public function create() {
    return new \NetBricks\SimpleCms\View\Back\ChangePassword();
  }

	protected $options = array(
				'model' => null,

			);

	public function __construct($options = array())
	{
        parent::__construct($options);
		
	$this->options['model'] = new \NetBricks\SimpleCms\ViewModel\ChangePasswordViewModel();
	        if(!\NetBricks\SimpleCms\Di::isLogged()) {
            header('Location: /login');
        }

	}

	
        
    
    /**
     * @return \NetBricks\SimpleCms\View\Back\ChangePassword
     */
    public function __invoke()
    {
              $model = $this->options['model'];
                            ob_start();

              ?><?php /**
 * [AdminAccess]
 * @var $this \Nbml\Component
 *
 * @var $model \NetBricks\SimpleCms\ViewModel\ChangePasswordViewModel
 */
?>

<h2>Change admin's password</h2>

<?php if($model->success): ?>
<p>Password changed successfully</p>
<?php else: ?>

<form action="" method="post">

    <dl>
        <dt>
            <label for="current_input">Current password</label>
        </dt>
        <dd>
            <input id="current_input"
                   type="password"
                   name="current"
                   class="<?=$model->currentInputClass?>"/>
            <?php if ($model->currentError): ?>
            <p class="warning"><?=$model->currentError?></p>
            <?php endif; ?>
        </dd>

        <dt>
            <label for="new_password_input">New password</label>
        </dt>
        <dd>
            <input id="new_password_input"
                   type="password"
                   name="new_password"
                   class="<?=$model->newPasswordInputClass?>"/>
            <?php if ($model->newPasswordError): ?>
            <p class="warning"><?=$model->newPasswordError?></p>
            <?php endif; ?>
        </dd>

        <dt>
            <label for="retype_password_input">Retype new password</label>
        </dt>
        <dd>
            <input id="retype_password_input"
                   type="password"
                   name="retype_password"
                   class="<?=$model->retypePasswordInputClass?>"/>
            <?php if ($model->retypePasswordError): ?>
            <p class="warning"><?=$model->retypePasswordError?></p>
            <?php endif; ?>
        </dd>
    </dl>

    <input type="submit" value="Change password">

</form>
<?php endif; ?>
                    <?php        
       $this->text = ob_get_clean();
       return $this;
    }
}



