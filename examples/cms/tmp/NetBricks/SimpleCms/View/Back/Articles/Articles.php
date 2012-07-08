<?php
namespace NetBricks\SimpleCms\View\Back;

class Articles extends \Nbml\Component
{

  static public $PATH = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\cms\public\..\src\NetBricks\SimpleCms\View\Back\Articles\Articles.nbml';

  /**
   * @return \NetBricks\SimpleCms\View\Back\Articles
   */
  static public function create() {
    return new \NetBricks\SimpleCms\View\Back\Articles();
  }

	protected $options = array(
				'model' => null,

			);

	public function __construct($options = array())
	{
        parent::__construct($options);
		
	$this->options['model'] = new \NetBricks\SimpleCms\ViewModel\ArticlesViewModel();
	        if(!\NetBricks\SimpleCms\Di::isLogged()) {
            header('Location: /login');
        }

	}

	
        
    
    /**
     * @return \NetBricks\SimpleCms\View\Back\Articles
     */
    public function __invoke()
    {
              $model = $this->options['model'];
                            ob_start();

              ?><?php /**
 * [AdminAccess]
 * @var $this \Nbml\Component
 *
 * @var $model \NetBricks\SimpleCms\ViewModel\ArticlesViewModel
 */ ?>
<h2>Articles</h2>

<ul class="sub_menu">
    <li>
        <a href="/admin/articles">List</a>
    </li>
    <li>
        <a href="/admin/articles/add">Add article</a>
    </li>
</ul>

<?=$model->getContent()?>
                    <?php        
       $this->text = ob_get_clean();
       return $this;
    }
}



