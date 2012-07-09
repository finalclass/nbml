<?php
namespace Blog;

class MenuButton extends \Nbml\Component
{

  static public $PATH = 'D:\Dokumenty\nbml\strona_projektu\www\vendor\finalclass\nbml\examples\blog\Blog\MenuButton\MenuButton.nbml';

  /**
   * @return \Blog\MenuButton
   */
  static public function create() {
    return new \Blog\MenuButton();
  }

	protected $options = array(
				'normal_state' => true,

				'selected_state' => false,

				'selected_class' => 'selected',

				'label' => null,

				'href' => null,

			);

	public function __construct($options = array())
	{
        parent::__construct($options);
		
	$this->options['current_state'] = 'normalState';
					
	}

	
    
	/**
	 * @param $value null
	 * @return MenuButton|boolean
	 */
	public function normalState($value = null)
	{
		if($value !== null) {
			    if($value) {
    $this->options['current_state'] = 'normalState';
    } else if($this->options['current_state'] == 'normalState'){
    $this->options['current_state'] = '';
    }
    
			return $this;
		}
		return @$this->options['current_state'] == 'normalState';

	}    
	/**
	 * @param $value null
	 * @return MenuButton|boolean
	 */
	public function selectedState($value = null)
	{
		if($value !== null) {
			    if($value) {
    $this->options['current_state'] = 'selectedState';
    } else if($this->options['current_state'] == 'selectedState'){
    $this->options['current_state'] = '';
    }
    
			return $this;
		}
		return @$this->options['current_state'] == 'selectedState';

	}    
	/**
	 * @param $value null
	 * @return MenuButton|string
	 */
	public function selectedClass($value = null)
	{
		if($value !== null) {
			$this->options['selected_class'] = $value;
			return $this;
		}
		return $this->options['selected_class'];
	}    
	/**
	 * @param $value null
	 * @return MenuButton|string
	 */
	public function label($value = null)
	{
		if($value !== null) {
			$this->options['label'] = $value;
			return $this;
		}
		return $this->options['label'];
	}    
	/**
	 * @param $value null
	 * @return MenuButton|string
	 */
	public function href($value = null)
	{
		if($value !== null) {
			$this->options['href'] = $value;
			return $this;
		}
		return $this->options['href'];
	}    
    
    /**
     * @return \Blog\MenuButton
     */
    public function __invoke()
    {
              $normalState = $this->normalState();
              $selectedState = $this->selectedState();
                      $selectedClass = '';
        if(@$this->options['current_state'] == 'selectedState') {
            if(@$this->options['selected_class']) {
                $selectedClass = $this->options['selected_class'];
            } else {
                                    $selectedClass = 'selected';
                            }
        }
              $label = $this->options['label'];
              $href = $this->options['href'];
                            ob_start();

              ?><?php /**
 * @var $this \Nbml\Component
 *
 * [State] @var $normalState boolean(true)
 * [State] @var $selectedState boolean(false)
 *
 * [OnState('selectedState')]
 * [Public]
 * @var $selectedClass string('selected')
 *
 * [Public] @var $label string
 * [Public] @var $href string
 */ ?>

<a href="<?=$href?>"
   title="<?=$label?>"
   class="<?=$selectedClass?>">
    <?=$label?>
</a>
                    <?php        
       $this->text = ob_get_clean();
       return $this;
    }
}



