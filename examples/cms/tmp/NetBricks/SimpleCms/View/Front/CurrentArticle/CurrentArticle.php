<?php
namespace NetBricks\SimpleCms\View\Front;

class CurrentArticle extends \Nbml\Component
{

  static public $PATH = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\cms\public\..\src\NetBricks\SimpleCms\View\Front\CurrentArticle.nbml';

  /**
   * @return \NetBricks\SimpleCms\View\Front\CurrentArticle
   */
  static public function create() {
    return new \NetBricks\SimpleCms\View\Front\CurrentArticle();
  }

	protected $options = array(
				'model' => null,

			);

	public function __construct($options = array())
	{
        parent::__construct($options);
		
	$this->options['model'] = new \NetBricks\SimpleCms\ViewModel\ArticleViewModel();
	
	}

	
        
    
    /**
     * @return \NetBricks\SimpleCms\View\Front\CurrentArticle
     */
    public function __invoke()
    {
              $model = $this->options['model'];
                            ob_start();

              ?><?php /**
 * @var $this \Nbml\Component
 *
 * @var $model \NetBricks\SimpleCms\ViewModel\ArticleViewModel
 */ ?>

<h2><?=$model->article->title?></h2>

<?=$model->article->body?>

                    <?php        
       $this->text = ob_get_clean();
       return $this;
    }
}



