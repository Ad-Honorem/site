<?php

namespace ADH\NewsBundle\Controller;

use ADH\NewsBundle\Entity\News;
use ADH\NewsBundle\Form\FilterNewsType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller {
	public function newsAction(News $news, $prefix = "", $link = false, $more = false) {
		return ($this->render("ADHNewsBundle:Block:news.html.twig", array(
				"news" => $news,
				"id" => $prefix . "news-block-" . $news->getId(),
				"link" => $link,
				"more" => $more,
				"category_field" => $this->createForm(new FilterNewsType())->createView()->offsetGet("category")->vars["full_name"]
		)));
	}
}