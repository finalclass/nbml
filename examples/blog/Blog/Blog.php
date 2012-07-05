<?php


class Blog extends \Nbml\Component
{

  static public $DIR = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\blog\Blog\Blog.nbml';

  /**
   * @return \Blog
   */
  static public function create() {
    return new \Blog();
  }

	protected $options = array(
				'list_state' => true,

				'form_state' => false,

				'list_button' => null,

				'add_button' => null,

				'table' => null,

				'form' => null,

			);

	public function __construct($options = array())
	{
        parent::__construct($options);
		
	$this->options['current_state'] = 'listState';
		$this->options['list_button'] = new \Blog\MenuButton();
	$this->options['add_button'] = new \Blog\MenuButton();
	$this->options['table'] = new \Blog\Table();
	$this->options['form'] = new \Blog\Form();
	
	}

	
    
	/**
	 * @param $value null
	 * @return Blog|boolean
	 */
	public function listState($value = null)
	{
		if($value !== null) {
			    if($value) {
    $this->options['current_state'] = 'listState';
    } else if($this->options['current_state'] == 'listState'){
    $this->options['current_state'] = '';
    }
    
			return $this;
		}
		return @$this->options['current_state'] == 'listState';

	}    
	/**
	 * @param $value null
	 * @return Blog|boolean
	 */
	public function formState($value = null)
	{
		if($value !== null) {
			    if($value) {
    $this->options['current_state'] = 'formState';
    } else if($this->options['current_state'] == 'formState'){
    $this->options['current_state'] = '';
    }
    
			return $this;
		}
		return @$this->options['current_state'] == 'formState';

	}                    
    
    /**
     * @return \Blog
     */
    public function __invoke()
    {
              $listState = $this->listState();
              $formState = $this->formState();
              $listButton = $this->options['list_button'];
              $addButton = $this->options['add_button'];
                      $table = '';
        if(@$this->options['current_state'] == 'listState') {
            if(@$this->options['table']) {
                $table = $this->options['table'];
            } else {
                                    $table = new \Blog\Table();
                            }
        }
                      $form = '';
        if(@$this->options['current_state'] == 'formState') {
            if(@$this->options['form']) {
                $form = $this->options['form'];
            } else {
                                    $form = new \Blog\Form();
                            }
        }
                            ob_start();

              ?><?php /**
 * @var $this \Nbml\Component
 *
 * [State] @var $listState boolean(true)
 * [State] @var $formState boolean(false)
 *
 * @var $listButton \Blog\MenuButton
 * @var $addButton \Blog\MenuButton
 *
 * [OnState('listState')]
 * @var $table \Blog\Table
 *
 * [OnState('formState')]
 * @var $form \Blog\Form
 */ ?>

<ul>
    <li><?=$listButton->label('List')->href('/')?></li>
    <li><?=$addButton->label('Add topic')->href('/add')?></li>
</ul>

<div class="content">
    <?=$table . $form?>
</div>
                    <?php        
       $this->text = ob_get_clean();
       return $this;
    }
}



