<?php
	class Article
  {
    public $headline;
    public $articlebody;
    public $date;
    public $href;
		public $category;

    function __construct($parameters = array()) {
        foreach($parameters as $key => $value) {
            $this->$key = $value;
        }
    }
	}
