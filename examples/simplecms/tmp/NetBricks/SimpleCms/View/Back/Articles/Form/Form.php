<?php
namespace NetBricks\SimpleCms\View\Back\Articles;

class Form extends \Nbml\Component
{

  static public $PATH = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\cms\public\..\src\NetBricks\SimpleCms\View\Back\Articles\Form.nbml';

  /**
   * @return \NetBricks\SimpleCms\View\Back\Articles\Form
   */
  static public function create() {
    return new \NetBricks\SimpleCms\View\Back\Articles\Form();
  }

	protected $options = array(
				'model' => null,

			);

	public function __construct($options = array())
	{
        parent::__construct($options);
		
	$this->options['model'] = new \NetBricks\SimpleCms\ViewModel\ArticlesFormViewModel();
	        if(!\NetBricks\SimpleCms\Di::isLogged()) {
            header('Location: /login');
        }

	}

	
        
    
    /**
     * @return \NetBricks\SimpleCms\View\Back\Articles\Form
     */
    public function __invoke()
    {
              $model = $this->options['model'];
                            ob_start();

              ?><?php /**
 * [AdminAccess]
 * @var $this \Nbml\Component
 *
 * @var $model \NetBricks\SimpleCms\ViewModel\ArticlesFormViewModel
 */ ?>
<h2>
    <?=$model->article->id ? 'Edit' : 'Add'?>
    article
</h2>
<form action="" method="post">

    <dl>
        <dt>
            <label for="title_input">Title:</label>
        </dt>
        <dd>
            <input id="title_input"
                   type="text"
                    name="title"
                    value="<?=$model->article->title?>"
                    class="<?=$model->titleInputClassName?>"/>
            <?php if($model->titleError): ?>
            <p class="warning"><?=$model->titleError?></p>
            <?php endif; ?>
        </dd>

        <dt>
            <label for="body_textarea">Body</label>
        </dt>
        <dd>
            <textarea id="body_textarea"
                      name="body"
                      cols="30"
                      rows="10"
                      class="<?=$model->bodyTextareaClassName?>"
                    ><?=$model->article->body?></textarea>
            <?php if($model->bodyError): ?>
            <p class="warning"><?=$model->bodyError?></p>
            <?php endif; ?>
        </dd>
    </dl>

    <input type="hidden" name="id" value="<?=$model->article->id?>" />
    <input type="submit" value="Save" />

</form>
                    <?php        
       $this->text = ob_get_clean();
       return $this;
    }
}



