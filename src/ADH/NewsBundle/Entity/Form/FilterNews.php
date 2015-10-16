<?php

namespace ADH\NewsBundle\Entity\Form;

use ADH\NewsBundle\Entity\CategoryNews;

class FilterNews {
	/**
	 * The category
	 * 
	 * @var CategoryNews
	 */
	private $category;
	
	/**
	 * Has category
	 * 
	 * @return boolean
	 */
	public function hasCategory() {
		return (!is_null($this->category));
	}
	
	/**
	 * Get category
	 * 
	 * @return CategoryNews
	 */
	public function getCategory() {
		return ($this->category);
	}
	
	/**
	 * Set category
	 * 
	 * @param CategoryNews $category
	 */
	public function setCategory(CategoryNews $category) {
		$this->category = $category;
	}
}
