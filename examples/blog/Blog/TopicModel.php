<?php
namespace Blog;

class TopicModel
{

    public function __construct()
    {
        if (!isset($_SESSION['topics'])) {
            $_SESSION['topics'] = array(
                array('id' => 1, 'title' => 'First topic', 'body' => 'content of first topic'),
                array('id' => 2, 'title' => 'Second topic', 'body' => 'Lorem ipsum dolor!')
            );
        }
    }

    public function all()
    {
        return $_SESSION['topics'];
    }

    public function current()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : -1);
        $record = $this->find($id);
        if (!$record) {
            if (isset($_POST['id'])) {
                $record = $_POST;
            } else {
                $record = array('id' => -1, 'title' => '', 'body' => '');
            }
        }
        return $record;
    }

    public function find($id)
    {
        foreach ($this->all() as $record) {
            if ($record['id'] == $id) {
                return $record;
            }
        }
        return null;
    }

    public function getMaxId()
    {
        $max = 0;
        foreach ($this->all() as $record) {
            $max = $record['id'] > $max ? $record['id'] : $max;
        }
        return $max;
    }

    public function save($title, $body, $id = -1)
    {
        $id = (int)$id;
        $foundIndex = null;
        foreach ($this->all() as $index => $record) {
            if ($record['id'] == $id) {
                $foundIndex = $index;
                break;
            }
        }

        $record = array(
            'id' => $id,
            'title' => $title,
            'body' => $body
        );

        if (!$foundIndex && $id < 1) {
            $record['id'] = $this->getMaxId() + 1;
            $_SESSION['topics'][] = $record;
            return;
        }

        if($foundIndex === null) {
            throw new \Exception('Cannot add or update topic');
        }

        $_SESSION['topics'][$foundIndex] = $record;
    }

    public function remove($id)
    {
        foreach($this->all() as $index => $record) {
            if($record['id'] == $id) {
                break;
            }
        }
        if(!isset($index)) {
            return false;
        }
        unset($_SESSION['topics'][$index]);
        return true;
    }

}
