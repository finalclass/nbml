<?php
namespace Blog;

class Table extends \Nbml\Component
{

  static public $DIR = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\blog\Blog\Table\Table.nbml';

  /**
   * @return \Blog\Table
   */
  static public function create() {
    return new \Blog\Table();
  }

	protected $options = array(
				'model' => null,

			);

	public function __construct($options = array())
	{
        parent::__construct($options);
		
	$this->options['model'] = new \Blog\TopicModel();
	
	}

	
        
    
    /**
     * @return \Blog\Table
     */
    public function __invoke()
    {
              $model = $this->options['model'];
                            ob_start();

              ?><?php /**
 * @var $this \Nbml\Component
 *
 * @var $model \Blog\TopicModel
 */
?>
<table>
    <thead>
    <tr>
        <td>Id</td>
        <td>Name</td>
        <td>Operations</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($model->all() as $record): ?>
    <tr>
        <td><?=$record['id']?></td>
        <td><?=$record['title']?></td>
        <td>
            <ul>
                <li>
                    <a href="/edit?id=<?=$record['id']?>">edit</a>
                </li>
                <li>
                    <a href="/remove?id=<?=$record['id']?>">remove</a>
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



