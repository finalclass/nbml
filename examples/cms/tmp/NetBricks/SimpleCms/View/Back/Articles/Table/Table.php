<?php
namespace NetBricks\SimpleCms\View\Back\Articles;

class Table extends \Nbml\Component
{

  static public $PATH = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\cms\public\..\src\NetBricks\SimpleCms\View\Back\Articles\Table.nbml';

  /**
   * @return \NetBricks\SimpleCms\View\Back\Articles\Table
   */
  static public function create() {
    return new \NetBricks\SimpleCms\View\Back\Articles\Table();
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
     * @return \NetBricks\SimpleCms\View\Back\Articles\Table
     */
    public function __invoke()
    {
                            ob_start();

              ?><?php /**
 * [AdminAccess]
 * @var $this \Nbml\Component
 */
?>

<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Operations</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach (\NetBricks\SimpleCms\Model\Article::all() as $article): ?>
    <tr>
        <td><?=$article->id?></td>
        <td><?=$article->title?></td>
        <td>
            <ul class="operations">
                <li>
                    <a href="/admin/articles/edit?id=<?=$article->id?>"
                       title="Edit"
                       class="edit">
                        Edit
                    </a>
                </li>
                <li>
                    <a href="/admin/articles/remove?id=<?=$article->id?>"
                       title="Remove"
                       class="remove"
                       onclick="return confirm('Are you sure?');">
                        Remove
                    </a>
                </li>
            </ul>
        </td>
    </tr>
        <?php endforeach; ?>
    </tbody>
</table>
                    <?php        
       $this->text = ob_get_clean();
       return $this;
    }
}



