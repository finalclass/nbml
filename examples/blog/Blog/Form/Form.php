<?php
namespace Blog;

class Form extends \Nbml\Component
{

  static public $PATH = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\blog\Blog\Form\Form.nbml';

  /**
   * @return \Blog\Form
   */
  static public function create() {
    return new \Blog\Form();
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
     * @return \Blog\Form
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

$current = $model->current();
?>

<form action="/save" method="post">

    <dl>
        <dt><label for="topic_title">Topic name:</label></dt>
        <dd>
            <input id="topic_title"
                   type="text"
                   name="title"
                   value="<?=$current['title']?>"/>
        </dd>

        <dt><label for="topic_body">Topic content</label></dt>
        <dd>
            <textarea id="topic_body" name="body" cols="30" rows="10"><?=$current['body']?></textarea>
        </dd>
    </dl>

    <input type="hidden" name="id" value="<?=$current['id']?>">
    <input type="submit" value="Save"/>

</form>

                    <?php        
       $this->text = ob_get_clean();
       return $this;
    }
}



