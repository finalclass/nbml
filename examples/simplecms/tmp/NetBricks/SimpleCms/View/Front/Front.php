<?php
namespace NetBricks\SimpleCms\View;

class Front extends \Nbml\Component
{

  static public $PATH = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\cms\public\..\src\NetBricks\SimpleCms\View\Front\Front.nbml';

  /**
   * @return \NetBricks\SimpleCms\View\Front
   */
  static public function create() {
    return new \NetBricks\SimpleCms\View\Front();
  }

	protected $options = array(
				'current_article' => null,

			);

	public function __construct($options = array())
	{
        parent::__construct($options);
		
	$this->options['current_article'] = new \NetBricks\SimpleCms\View\Front\Article();
	
	}

	
        
    
    /**
     * @return \NetBricks\SimpleCms\View\Front
     */
    public function __invoke()
    {
              $currentArticle = $this->options['current_article'];
                            ob_start();

              ?><?php /**
 * @var $this \Nbml\Component
 *
 * @var $currentArticle \NetBricks\SimpleCms\View\Front\Article
 */ ?>
<ul>
    <?php foreach(\NetBricks\SimpleCms\Model\Article::all() as $article): ?>
    <li>
        <a href="/article?id=<?=$article->id?>"><?=$article->title?></a>
    </li>
    <?php endforeach ?>
</ul>

<?= $currentArticle ?>
                    <?php        
       $this->text = ob_get_clean();
       return $this;
    }
}



